@section('css-extend')
    <link href="{{ asset('assets/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/sweet-alert/sweet-alert.min.css') }}" type="text/css" rel="stylesheet"/>
@endsection
@extends('site.mainpage')
@section('page_content')
    @if($permission)
        @php
            $page = \Request::segment(1);
            $page_action = \Request::segment(2);
             if(\Request::segment(3)){
                 $item_id = \Request::segment(3);
             }
            $allowedMimeTypes = ['image/jpeg','image/jpg','image/gif','image/png','image/bmp','image/svg+xml'];

        @endphp
        @section('page-title') @lang($page . '.' . $block_field['information']['title']['value']) @endsection
    <div class="container post-page">
        <div class="logo-des">
            <!-- title -->
            <div class="title-PostPage display-inline-block">
                <h1>
                    @if($lang != $def_lang)
                        @lang($page . '.' . $block_field['information']['title']['value'])
                    @else
                        {{ $block_field['information']['title']['value'] }}
                    @endif
                </h1>
            </div>
        </div>
        <div class="panel m-t-15">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <div class="col-md-12">
                    @if($lang != $def_lang)
                        @lang($page . '.' . $block_field['information']['content']['value'])
                    @else
                        {!! $block_field['information']['content']['value'] !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-danger m-t-150">
            <span>You do not have permission to view this page</span>
        </div>
    @endif
@endsection
@section('script-extend')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
