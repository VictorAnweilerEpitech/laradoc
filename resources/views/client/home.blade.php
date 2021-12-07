@extends('laradoc::client.template', [
    'pageTitle' => 'Accueil'
])

@section('content')
<div class="row w-100">
    @foreach ($categories as $category)
        <div class="col-4">
            <div class="bg-white border rounded w-100 p-4 text-center">
                <h3 class="w-100 mb-0 font-weight-bold">{{$category->name}}</h3>
                <a href="{{route('laradoc.client.page', $category->id)}}" class="btn bg-my-primary text-white mt-2">
                    <i class="fas fa-eye" style="margin-right: 5px;"></i>Voir
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection
