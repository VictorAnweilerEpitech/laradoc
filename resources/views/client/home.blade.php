@extends('laradoc::client.template', [
    'pageTitle' => 'Accueil'
])

@section('content')
    <div class="text-center">
        <div class="d-flex align-items-center justify-content-center mt-5 mb-4">
            <img class="mr-3" src="{{config('laradoc.logo')}}" height="70" />
            <div class="text-left">
                <h1 class="font-weight-light mb-0">{{config('laradoc.name') ?? 'LaraDoc'}}</h1>
                <h6 class="font-weight-light text-secondary">Documentation</h6>
            </div>
        </div>
        <div class="pb-1">
            @foreach ($categories as $category)
                <div class="text-center d-inline-block mt-3">
                    <a href="{{route('laradoc.client.page', $category->id)}}" class="bg-light px-3 pt-1 pb-2 mr-1 font-weight-light my-rounded" style="text-decoration: none;">
                        <small class="w-100 mb-0 text-secondary">{{$category->name}}</small>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
