<?php

namespace Victoranw\Laradoc\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentationPermission extends Model
{
    use HasFactory;

    protected $table = "documentation_permissions";

    public function user() {
        $guard = config('auth.guards')[config('laradoc.auth.guard')];
        $provider = config('auth.providers')[$guard['provider']];
        $model = app($provider['model']);

        return $this->belongsTo($model, 'user_id');
    }
}
