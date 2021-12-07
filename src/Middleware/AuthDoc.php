<?php

namespace Victoranw\Laradoc\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Victoranw\Laradoc\Http\Traits\AuthTrait;

class AuthDoc
{
    use AuthTrait;

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard(config('laradoc.auth.guard'))->check() || !$this->userCanAccess()) {
            return redirect()->route('laradoc.view.login');
        }
        return $next($request);
    }
}
