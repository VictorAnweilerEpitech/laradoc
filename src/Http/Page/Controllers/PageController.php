<?php

namespace Victoranw\Laradoc\Http\Page\Controllers;

use Illuminate\Http\Request;
use Victoranw\Laradoc\Models\Page;

use Victoranw\Laradoc\Models\Category;

use Victoranw\Laradoc\Http\Controllers\LaradocController;
use Victoranw\Laradoc\Http\Page\Requests\PageEditAddRequest;

class PageController extends LaradocController
{
    public function browseByCategorie($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        return $category->pages;
    }

    public function create(PageEditAddRequest $request)
    {
        $page = new Page;
        $page->fill($request->validated());
        $page->save();

        return $page;
    }

    public function update(PageEditAddRequest $request, $pageId)
    {
        $page = Page::findOrFail($pageId);
        $page->fill($request->all());
        $page->save();

        return $page;
    }

    public function view($pageId)
    {
        $page = Page::findOrFail($pageId);
        return $page;
    }

    public function delete($pageId)
    {
        $page = Page::findOrFail($pageId);
        $page->delete();
    }
}
