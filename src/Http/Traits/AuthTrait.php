<?php

namespace Victoranw\Laradoc\Http\Traits;

use PhpParser\Node\Expr\Cast\Bool_;
use Victoranw\Laradoc\Models\DocumentationPermission;

trait AuthTrait
{
    public function getUser()
    {
        if (isset($_COOKIE['laradoc_user'])) {
            $guardName = config('laradoc.auth.guard');
            if ($guardName) {
                if ($providerName = config('auth.guards')[$guardName]['provider']) {
                    if ($modelPath = config('auth.providers')[$providerName]['model']) {
                        $model = app($modelPath);
                        $user = $model::find(json_decode($_COOKIE['laradoc_user'])->id);
                        return $user;
                    }
                }
            }
        }
    }

    public function userCanAccess() : Bool
    {
        if ($user = $this->getUser()) {
            return $this->getUser() && DocumentationPermission::where('user_id', $user->id)->first() ? true : false;
        }
        return false;
    }

    public function userIsAdmin() : Bool
    {
        if ($user = $this->getUser()) {
            return $this->userCanAccess() && DocumentationPermission::where('user_id', $user->id)->where('admin', 1)->first() ? true : false;
        }
        return false;
    }
}
