<?php

namespace Victoranw\Laradoc\Models;

use Victoranw\Laradoc\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = "laradoc_categories";
    protected $fillable = ['name', 'parent_id'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }
}
