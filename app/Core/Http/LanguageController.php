<?php
namespace App\Core\Http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function setLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required'
        ]);

        session(['language' => $request->language]);

        return back();
    }

    public function switchLanguageForSite($lang)
    {
        if (!in_array($lang, ['en', 'np'])) {
            $lang = 'en';
        }

        session(['language' => $lang]);
        app()->setLocale($lang);

        // Get current path from referer
        $referer = request()->headers->get('referer');

        if ($referer) {
            // Extract path from referer URL
            $parsedUrl = parse_url($referer);
            $currentPath = $parsedUrl['path'] ?? '/';

            // Remove existing language prefix
            $cleanPath = preg_replace('/^\/(en|np)/', '', $currentPath);

            // Redirect to new language URL
            return redirect("/{$lang}{$cleanPath}");
        }

        // Fallback to homepage
        return redirect("/{$lang}");
    }

}
