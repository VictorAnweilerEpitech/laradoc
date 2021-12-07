<?php

namespace Victoranw\Laradoc\Http\Member\Controllers;

use Illuminate\Http\Request;

use Victoranw\Laradoc\Models\DocumentationPermission;
use Victoranw\Laradoc\Http\Controllers\LaradocController;

class MemberController extends LaradocController
{
    public function getModel()
    {
        $guard = config('auth.guards')[config('laradoc.auth.guard')];
        $provider = config('auth.providers')[$guard['provider']];
        $model = app($provider['model']);

        return $model;
    }

    public function browseAllow()
    {
        $model = $this->getModel();
        $membersId = $model::all()->pluck('id');

        $members = DocumentationPermission::whereIn('user_id', $membersId)->with('user')->get();
        return $members;
    }

    public function browseNotAllow()
    {
        $model = $this->getModel();

        $userAllowed = DocumentationPermission::all()->pluck('user_id');

        $members = $model::whereNotIn('id', $userAllowed)->get();

        return $members;
    }

    public function allow($memberId)
    {
        $model = $this->getModel();
        $member = $model::findOrFail($memberId);
        $authorisation = new DocumentationPermission;
        $authorisation->user_id = $member->id;
        $authorisation->admin = 0;
        $authorisation->save();
    }

    public function removeAllow($memberId)
    {
        $authorisation = DocumentationPermission::where('user_id', $memberId)->firstOrFail();
        $authorisation->delete();
    }

    public function changePermission(Request $request, $memberId)
    {
        $authorisation = DocumentationPermission::where('user_id', $memberId)->firstOrFail();
        $authorisation->admin = $request->admin;
        $authorisation->save();
    }
}
