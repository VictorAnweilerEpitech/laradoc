<?php

namespace Victoranw\Laradoc\Models;

use Victoranw\Laradoc\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $table = "laradoc_pages";
    protected $fillable = ['name', 'order', 'content', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
