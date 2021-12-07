<?php

namespace Victoranw\Laradoc\Http\Controllers;

use Illuminate\Http\Request;
use Victoranw\Laradoc\Http\Controllers\LaradocController;

class AssetsController extends LaradocController
{
    protected $assetPath = __DIR__."/../../../public";

    public function styleFile(Request $request)
    {
        $path = $this->assetPath.'/css/'.$request->style;
        if (file_exists($path)) {
            return response(
                file_get_contents($path),
                200, ['Content-Type' => 'text/css']
            );
        }
    }

    public function scriptFile(Request $request)
    {
        $path = $this->assetPath.'/js/'.$request->script;
        if (file_exists($path)) {
            return response(
                file_get_contents($path),
                200, ['Content-Type' => 'application/javascript']
            );
        }
    }
}