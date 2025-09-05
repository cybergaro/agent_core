<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetUserLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            App::setLocale(auth()->user()->lang);
        }

        return $next($request);
    }
}