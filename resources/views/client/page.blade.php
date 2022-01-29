@extends('laradoc::client.template', [
    'pageTitle' => $category->name
])

@section('client-head')
<style>
.doc_nav .selected, .doc_nav .selected:hover
{
    font-weight: 400;
    color: {{config('laradoc.color')}};
}

.square-selected {
    background: #fff;
    margin-right: 10px;
    width: 3px;
    height: 20px;
}

.js-btn:hover .square-selected {
    background: rgba(0, 0, 0, .2);
}

.selected .square-selected, .selected:hover .square-selected
{
    background: {{config('laradoc.color')}};    
}

.js-btn, .js-btn a{
    color: rgba(0, 0, 0, 0.7);
    font-weight: 300;
}

.js-btn:hover, .js-btn:hover a {
    color: rgba(0, 0, 0, 1);
}

</style>
@endsection

@section('client-content')
<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="sticky-top">
                <div class="pt-3">
                    <h1>{{$category->name}}</h1>
                    @if ($category->parent || count($children) > 0)
                        <hr>
                    @endif
                    <ul class="pl-0 mb-0" style="list-style-type: none;">
                        @if ($category->parent)
                            <li class="js-btn">
                                <a style="text-decoration: none;" class="text-dark" href="{{route('laradoc.client.page', $category->parent->id)}}">
                                    <i class="fas fa-arrow-left mr-2"></i>Retour
                                </a>
                            </li>
                        @endif
                        @foreach ($children as $child)
                            <li class="js-btn">
                                <a style="text-decoration: none;" class="text-dark" href="{{route('laradoc.client.page', $child->id)}}">
                                    <i class="fas fa-external-link-square-alt mr-2"></i>{{$child->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <hr>
                <div class="doc_nav">
                    <ul class="pl-0" style="list-style-type: none">
                        @if (isset($category))
                            @foreach ($category->pages as $index => $categoryPage)
                                <li class="d-flex align-items-center js-btn mb-3 {{$index == 0 ? 'selected' : ''}} pr-5" style="cursor: pointer">
                                    <div class="square-selected"></div>
                                    {{$categoryPage->name}}
                                </li>
                            @endforeach
                        @endif
                        @if (count($category->pages) <= 0)
                            <small class="font-weight-light text-secondary">
                                Aucune page
                            </small>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="mt-3 doc-reader">
                <div class="js-section"></div>
                @if (count($category->pages) <= 0)
                <div class="bg-light p-3 border my-rounded text-center shadow">
                    <img height="75" class="mt-2" src="https://cdn-icons-png.flaticon.com/512/869/869078.png" />
                    <h4 class="font-weight-light mt-2 mb-1">
                        Aucun contenu disponible
                    </h4>
                    <p class="text-secondary font-weight-light">Cette page ne possède pas de contenu</p>
                </div>
                @endif
                @foreach ($category->pages as $index => $page)
                    <section class="my-5 js-section" id="{{'section-'.$page->id}}">
                        <h3 class="section_title mb-4">
                            <b>
                                <span class="text-my-primary">#</span>
                                {{$page->name}}
                            </b>
                        </h3>
                        <div class="pl-4 pb-5 page-content-reader">
                            {!!$page->content!!}
                        </div>
                        @if ($index < count($category->pages) - 1)
                            <hr class="mt-3" style="border-top: 1px solid #E4E4E4" />
                        @endif
                    </section>
                @endforeach
            </div>
        </div>
    </div>

    <button class="btn bg-my-primary btn-scrolltop text-white rounded-circle shadow" style="position: fixed; right: 50px; bottom: 50px;">
        <i class="fas fa-arrow-up mb-0"></i>
    </button>
</div>
@endsection
