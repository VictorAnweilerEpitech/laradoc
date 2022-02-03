@extends('laradoc::template')

@section('head')
    {{-- EditorCss --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/plugins/table/ui/trumbowyg.table.min.css">

    {{-- MyCss --}}
    <link href="{{route('laradoc.assets.css', 'client/client.css')}}" rel="stylesheet" />


    @yield('client-head')
@endsection

@section('content')
<div class="pt-2">
    @yield('client-content')
</div>
@endsection

@section('scripts')
    {{-- My Script --}}
    <script src="{{route('laradoc.assets.js', 'client/appclient.js')}}"></script>

    @yield('admin-scripts')
@endsection
