@extends('laradoc::template')

@section('head')
    {{-- EditorCss --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/plugins/table/ui/trumbowyg.table.min.css">

    {{-- MyCss --}}
    <link href="{{route('laradoc.assets.css', 'admin/admin.css')}}" rel="stylesheet" />

    @yield('admin-head')
@endsection

@section('content')
<div class="pt-2">
    @yield('admin-content')
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
    <script id="scriptappadmin" config="{{json_encode(config('laradoc'))}}" src="{{route('laradoc.assets.js', 'admin/appadmin.js')}}"></script>

    @yield('admin-scripts')
@endsection
