<?php

namespace Victoranw\Laradoc\Http\Home\Controllers;

use Illuminate\Http\Request;
use Victoranw\Laradoc\Http\Controllers\LaradocController;

use Victoranw\Laradoc\Http\Traits\AuthTrait;

class HomeController extends LaradocController
{
    public function admin() {
        return view('laradoc::admin.home');
    }
}
