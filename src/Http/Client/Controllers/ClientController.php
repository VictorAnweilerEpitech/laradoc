<?php

namespace Victoranw\Laradoc\Http\Client\Controllers;

use Illuminate\Http\Request;
use Victoranw\Laradoc\Models\Page;
use Victoranw\Laradoc\Models\Category;
use Victoranw\Laradoc\Http\Controllers\LaradocController;

class ClientController extends LaradocController
{
    public function home() {
        $categories = Category::orderBy('order')
                            ->whereNull('parent_id')
                            ->get();
        return view('laradoc::client.home', compact('categories'));
    }

    public function page($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $children = $category->children;

        $pages = Page::where('parent_id', $categoryId)->orderBy('order')->get()->unique('order')->groupBy('group');

        return view('laradoc::client.page', compact('pages', 'category', 'children'));
    }
}
