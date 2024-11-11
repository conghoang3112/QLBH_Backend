<?php

namespace App\Http\Middleware;

use App\Helpers\Enums\SupportedLanguages;
use Closure;
use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;
use Illuminate\Support\Facades\App;

class Locale extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = $request->header('lang') ?? SupportedLanguages::VIETNAMESE;
        App::setLocale($lang);
        return $next($request);
    }
}
