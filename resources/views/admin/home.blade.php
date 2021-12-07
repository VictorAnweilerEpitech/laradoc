@extends('laradoc::admin.template', [
    'pageTitle' => 'Admin'
])

@section('admin-content')
    <router-view
    class="d-block w-100"
    :lara-config="{{json_encode(config('laradoc'))}}"
    :user="{{json_encode(auth()->guard(config('laradoc.auth.guard'))->user())}}"
    ></router-view>
@endsection
