<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Session bata language ID liyera locale set garne
        $languageId = session('language', 'en'); // default English
        $locale = $languageId == 'en' ? 'en' : 'np';

        app()->setLocale($locale);

        return $next($request);
    }
}
