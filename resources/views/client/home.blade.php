@extends('laradoc::client.template', [
    'pageTitle' => 'Accueil'
])

@section('content')
    <div class="text-center">
        <div class="row">

        </div>
        <div class="col-12 col-md-6 offset-md-3">
            <h1 class="display-4">Bienvenue,</h1>
            <p class="mb-2">Que recherchez-vous ?</p>
            <input type="text" class="form-control my-rounded text-center font-weight-light" placeholder="Page, Section, Mot-clé, ...">
            <div class="pb-1 mt-2">
                @foreach ($categories as $category)
                    <div class="text-center d-inline-block mt-3">
                        <a href="{{route('laradoc.client.page', $category->id)}}" class="bg-light px-3 py-1 mr-1 font-weight-light my-rounded">
                            <small class="w-100 mb-0 text-secondary">{{$category->name}}</small>
                        </a>
                    </div>
                @endforeach
            </div>


        </div>
    </div>
@endsection
