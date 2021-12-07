<?php

namespace Victoranw\Laradoc\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Victoranw\Laradoc\Http\Traits\AuthTrait;

class AdminDoc
{
    use AuthTrait;

    public function handle(Request $request, Closure $next)
    {
        if (!$this->userIsAdmin()) {
            return redirect()->route('laradoc.client.home');
        }
        return $next($request);
    }
}
