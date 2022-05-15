@extends('laradoc::client.template', [
    'pageTitle' => 'Accueil'
])

@section('client-content')
    <div class="d-flex align-items-center justify-content-center mt-5 mb-5">
        <img class="mr-3" src="{{config('laradoc.logo')}}" height="70" />
        <div class="text-left">
            <h1 class="font-weight-light mb-0">{{config('laradoc.name') ?? 'LaraDoc'}}</h1>
            <h6 class="font-weight-light text-secondary">Documentation</h6>
        </div>
    </div>
    <div class="pb-1 row">
        @foreach ($categories as $category)
            <div class="mb-5 col-4">
                <div class="w-100 mb-0 border p-4 my-rounded">
                    <i class="fa-solid fa-book text-my-primary h4"></i>
                    <a class="text-my-primary" style="text-decoration: none" href="{{route('laradoc.client.page', $category->id)}}">
                        <h4>{{$category->name}}</h4>
                    </a>
                    <p>
                        Démarrez rapidement grâce à nos bibliothèques, clés API et outils d'intégration.
                    </p>
                    <button class="btn bg-my-primary text-white">
                        Consulter
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endsection
