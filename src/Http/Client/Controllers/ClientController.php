<?php

namespace Victoranw\Laradoc\Http\Client\Controllers;

use Illuminate\Http\Request;
use Victoranw\Laradoc\Models\Category;
use Victoranw\Laradoc\Http\Controllers\LaradocController;

class ClientController extends LaradocController
{
    public function home() {
        $categories = Category::whereNull('parent_id')->get();
        return view('laradoc::client.home', compact('categories'));
    }

    public function page($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $children = $category->children;
        return view('laradoc::client.page', compact('category', 'children'));
    }
}
