<?php

namespace Victoranw\Laradoc\Http\Authentication\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Victoranw\Laradoc\Models\DocumentationPermission;

use Victoranw\Laradoc\Http\Authentication\Requests\LoginRequest;

use Victoranw\Laradoc\Http\Controllers\LaradocController;

class LoginController extends LaradocController
{
    public function loginView() {
        return view('laradoc::login');
    }

    public function connect(LoginRequest $request) {
        if (auth()->guard(config('laradoc.auth.guard'))->attempt([
            config('laradoc.auth.loginColumn') => $request->login,
            config('laradoc.auth.passwordColumn') => $request->password
        ])) {
            $user = Auth::guard(config('laradoc.auth.guard'))->user();
            if (DocumentationPermission::where('user_id', $user->id)) {
                setcookie('laradoc_user', json_encode($user), time() + (86400 * 31));
                return redirect()->intended(route('laradoc.client.home'));
            } else {
                // User can't access to documentation
                return redirect()->back();
            }
        } else {
            // User not found
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        if (isset($_COOKIE['laradoc_user'])) {
            unset($_COOKIE['laradoc_user']); 
            setcookie('laradoc_user', null, -1); 
        }
        return redirect()->route('laradoc.view.login');
    }
}
