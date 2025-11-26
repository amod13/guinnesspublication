<?php

namespace App\Modules\Publication\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Publication\Services\Interfaces\BookServiceInterface;
use App\Modules\UserManagement\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    protected string $viewPrefix = 'publication::site.page.userDashboard.';
    protected $userService, $bookService;
    public function __construct(UserServiceInterface $userService,BookServiceInterface $bookService)
    {
        $this->userService = $userService;
        $this->bookService = $bookService;
    }

    public function userProfile()
    {
        $userId =  $this->getCurrentLoginUserId();
        $data['userDetail'] = $this->userService->findById($userId);

        return view($this->viewPrefix . 'profileInfo', ['data' => $data]);
    }

    public function userProfileEdit($languageId, $id)
    {
        $data['userDetail'] = $this->userService->findById($id);

        return view($this->viewPrefix . 'profileEdit', ['data' => $data]);
    }
    public function userProfileUpdate(Request $request, $languageId, $id)
    {
        $user = $this->userService->findById($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|confirmed|min:6',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->except(['password', 'password_confirmation', 'profile_image']);

        // Handle password update if provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Handle file upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profile_images', $filename);

            // Delete old file if exists
            if ($user->profile_image) {
                Storage::delete('public/profile_images/' . $user->profile_image);
            }

            $data['profile_image'] = $filename;
        }

        // Update user record via service
        $this->userService->updateRecord($data, $id);

        return redirect()->route('site.user.profile',['locale' => app()->getLocale()])->with('success', 'Profile updated successfully.');
    }

    public function userBookmarks($languageId, $id)
    {
        $data['bookmarks'] = $this->bookService->getBookmarksBooks($id);
        $data['userDetail'] = $this->userService->findById($id);

        // dd($data);

        return view($this->viewPrefix . 'bookMarkList', ['data' => $data]);
    }


    private function getCurrentLoginUserId()
    {
        return auth()->user()->id;
    }
}
