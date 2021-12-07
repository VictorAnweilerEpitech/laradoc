@extends('laradoc::client.template', [
    'pageTitle' => $category->name
])

@section('content')
<style>
.doc__nav .selected
{
    color: {{config('laradoc.color')}};    
}

.doc__nav .selected:after
{
    color: {{config('laradoc.color')}};    
    background: {{config('laradoc.color')}};    
}
</style>
<aside class="doc__nav">
    <ul>
        @foreach ($category->pages as $index => $page)
            <li class="js-btn mb-3 {{$index == 0 ? 'selected' : ''}} pr-5">
                {{$page->name}}
            </li>
        @endforeach
    </ul>
</aside>
<article class="doc__content">
    <h1 class="mb-4">{{$category->name}}</h1>
    <div class="bg-light p-3 border rounded mb-4">
        <h5 class="font-weight-bold">Navigation</h5>
        <ul class="pl-0 mb-0" style="list-style-type: none;">
            @if ($category->parent)
                <li class="js-btn">
                    <i class="fas fa-arrow-left"></i>
                    <a href="{{route('laradoc.client.page', $category->parent->id)}}">Retour</a>
                </li>
            @endif
            @foreach ($category->children as $child)
                <li class="js-btn">
                    <i class="fas fa-link"></i>
                    <a href="{{route('laradoc.client.page', $child->id)}}">{{$child->name}}</a>
                </li>
            @endforeach
        </ul>
    </div>
    @if (count($children) > 0)
        <hr />
    @endif
    @foreach ($category->pages as $index => $page)
        <section class="js-section my-5 pt-2" style="min-height: 50vh;">
            <h3 class="section__title mb-4">
                <b>
                    <span class="text-my-primary">#</span>
                    {{$page->name}}
                </b>
            </h3>
            <div class="pl-4">
                {!!$page->content!!}
            </div>
            @if ($index < count($category->pages) - 1)
                <hr class="border-dark mt-4" />
            @endif
        </section>
    @endforeach
</article>
@endsection
