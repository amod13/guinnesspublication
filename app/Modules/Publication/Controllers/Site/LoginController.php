<?php

namespace App\Modules\Publication\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Publication\Enums\HighlightTypeEnum;
use App\Modules\Publication\Services\Interfaces\PageServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    protected string $viewPrefix = 'publication::site.';
    protected $PageService;
    public function __construct(
        PageServiceInterface $PageService,
    ) {
        $this->PageService = $PageService;
    }

    public function loginForm()
    {
        $data['header_title'] = 'Login';

        return view($this->viewPrefix . 'page.auth.login', ['data' => $data]);
    }

   public function login(Request $request)
{
    $loginField = filter_var($request->name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    $credentials = [
        $loginField => $request->name,
        'password' => $request->password
    ];

    $redirectTo = $request->input('redirect_to'); // optional manual redirect

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        if ($redirectTo) {
            return redirect($redirectTo)->with('success', 'Login Successfully');
        }

        return redirect()->intended(route('home.index', ['locale' => app()->getLocale()]))
            ->with('success', 'Login Successfully');
    }

    // Return back with error if credentials don't match
    return redirect()->back()->withInput($request->only('name'))
        ->with('error', 'Invalid username/email or password');
}


    public function showRegisterForm()
    {
        $data['header_title'] = 'Register';

        return view($this->viewPrefix . 'page.auth.register', ['data' => $data]);
    }

    public function register(Request $request)
    {
        // 1. Validate Form Data
        $validated = $request->validate([
            'name' => [
                'required',
                'regex:/^\S*$/',
                'unique:users,name',
            ],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // 2. Create User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role_id' => 2
        ]);

        if ($user) {
            return redirect()->route('site.login.form', ['locale' => app()->getLocale()])
                ->with('success', 'Registration Successful!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Registration Failed!')
                ->with('open_register', true); // ⭐ IMPORTANT
        }
    }


    // // 3. Auto Login After Register
    // Auth::login($user);

    // // 4. Redirect Back Where User Came From (Optional)
    // $redirectTo = session('redirect_to');
    // if ($redirectTo) {
    //     session()->forget('redirect_to');
    //     return redirect($redirectTo)->with('success', 'Registration Successful!');
    // }

    // 5. Default Redirect

    public function logOut($language, Request $request)
    {
        Auth::logout();                 // logout user
        $request->session()->invalidate();  // session invalidate
        $request->session()->regenerateToken(); // CSRF token regenerate

        // redirect to home or previous page
        return redirect()->back()->with('success', 'Logout Successfully');
    }

    public function redirectToGoogle(Request $request)
    {
        $redirectTo = $request->redirect_to ?? url()->previous();

        $request->session()->put('redirect_to', $redirectTo);

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $redirectTo = $request->session()->get('redirect_to');

            $googleUser = Socialite::driver('google')->user();
            $user = $this->findOrCreateUser($googleUser, 'google');

            Auth::login($user);
            $request->session()->forget('redirect_to');

            if ($redirectTo) {
                return redirect($redirectTo)->with('success', 'Login Successfully');
            }

            return redirect()->intended(
                route('home.index', ['locale' => app()->getLocale()])
            )->with('success', 'Login Successfully');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed.');
        }
    }


    private function findOrCreateUser($socialUser, $provider)
    {
        // Check if user exists with this provider
        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($user) {
            return $user;
        }

        // Check if user exists with same email
        $existingUser = User::where('email', $socialUser->getEmail())->first();

        if ($existingUser) {
            // Link social account to existing user
            $existingUser->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
            return $existingUser;
        }

        // Create new user
        return User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'avatar' => $socialUser->getAvatar(),
            'role_id' => 4, // Default role
            'password' => Hash::make(Str::random(16)), // Random password
        ]);
    }
}
