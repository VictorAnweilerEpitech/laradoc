<?php

namespace Victoranw\Laradoc\Http\Structure\Controllers;

use Illuminate\Http\Request;
use Victoranw\Laradoc\Http\Controllers\LaradocController;

use Victoranw\Laradoc\Http\Structure\Requests\StructureEditAddRequest;

use Victoranw\Laradoc\Models\Category;

class StructureController extends LaradocController
{
    public function home()
    {
        return view('laradoc::admin.structure');
    }

    public function structure()
    {
        $structures = Category::whereNull('parent_id')->with('children', 'parent')->get();

        return ['name' => 'Doc', 'children' => $structures];
    }

    public function create(StructureEditAddRequest $request)
    {
        $categorie = new Category;
        $categorie->fill($request->validated());
        $categorie->save();

        return $categorie;
    }

    public function update(StructureEditAddRequest $request, $categoryId)
    {
        $categorie = Category::findOrFail($categoryId);
        $categorie->fill($request->validated());
        $categorie->save();

        return $categorie;
    }

    public function view($categoryId)
    {
        $category = Category::findOrFail($categoryId)->load('children', 'parent');
        return $category;
    }

    public function delete($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->children()->delete();
        $category->delete();
    }
}