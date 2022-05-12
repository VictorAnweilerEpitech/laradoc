@extends('laradoc::admin.template.base', [
    'pageTitle' => $pageTitle ?? 'Admin'
])

@section('style')
    {{-- EditorCss --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/plugins/table/ui/trumbowyg.table.min.css">

    {{-- MyCss --}}
    <link href="{{route('laradoc.assets.css', 'admin/admin.css')}}" rel="stylesheet" />
@endsection

{{-- <div style="background: {{config('laradoc.color')}};">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3 text-white">
            <div>
                <img style="margin-right: 5px;" src="{{config('laradoc.logo')}}" height="18" />
                <b>{{config('laradoc.name')}}</b>
            </div>
            <img src="https://eu.ui-avatars.com/api/?name=Victor+Anweiler" class="rounded-circle" height="25" />
        </div>
    </div>
</div> --}}
@section('content')
<div id="app">
    @yield('admin-content')
</div>
</div>
@endsection
@section('scripts')
    {{-- VueJs --}}
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    {{-- Axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- Editor --}}
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/trumbowyg.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/langs/fr.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/plugins/table/trumbowyg.table.min.js"></script>
    {{-- My Script --}}
    <script id="scriptappadmin" src="{{route('laradoc.assets.js', 'admin/appadmin.js')}}" config="{{json_encode(config('laradoc'))}}"></script>
@endsection
