<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');
        
        if (!in_array($locale, ['en', 'np'])) {
            abort(404);
        }
        
        app()->setLocale($locale);
        session(['language' => $locale]);
        
        return $next($request);
    }
}