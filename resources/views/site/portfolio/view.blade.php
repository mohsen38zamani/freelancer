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
        @section('page-title') {{ ucfirst($page_action) . ' ' .$page . ' ' . $block_field['information']['name']['value'] }} @endsection
    <div class="container post-page">
        <div class="logo-des">
            <!-- title -->
            <div class="title-PostPage display-inline-block">
                <h1>{{ $block_field['information']['name']['value'] }}</h1>
            </div>
        </div>
        <div class="panel m-t-15">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        @if(isset($block_field['information']['attachment']) && isset($block_field['information']['attachment']['value']))
                            @foreach($block_field['information']['attachment']['value'] as $key => $item)
                            <div class="col-md-12">
                                @if(in_array(mime_content_type($item), $allowedMimeTypes))
                                    <img src="{{ asset($item) }}" alt="{{ $block_field['information']['name']['value'] }}" title="{{ $block_field['information']['name']['value'] }}" class="img-responsive">
                                @else
                                    <img src="{{ asset("images/PJ.jpg") }}" alt="{{ $block_field['information']['name']['value'] }}" title="{{ $block_field['information']['name']['value'] }}" class="img-responsive">
                                @endif
                            </div>
                            @php
                                $first_file = $key;
                            @endphp
                            @break
                            @endforeach
                            <br>
                            @foreach($block_field['information']['attachment']['value'] as $key => $item)
                                @if($key == $first_file) @continue @endif
                                <div class="col-md-3 m-t-15">
                                    @if(in_array(mime_content_type($item), $allowedMimeTypes))
                                        <img src="{{ asset($item) }}" alt="{{ $block_field['information']['name']['value'] }}" title="{{ $block_field['information']['name']['value'] }}" class="img-responsive">
                                    @else
                                        <img src="{{ asset("images/PJ.jpg") }}" alt="{{ $block_field['information']['name']['value'] }}" title="{{ $block_field['information']['name']['value'] }}" class="img-responsive">
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        <div class="col-md-12 m-t-20 p-t-40 bor18">
                            <h2>Description</h2>
                            <span>
                            {{ $block_field['information']['description']['value'] }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6 bor16">
                        <div class="col-md-3">
                            @if(in_array(mime_content_type($item), $allowedMimeTypes))
                                <img src="@if(isset($current_page_user->attachment->path) && $current_page_user->attachment->path){{ asset($current_page_user->attachment->path) }}@else{{ asset('/images/50x50.jpg') }} @endif"
                                     alt="orginal user profile picture" title="orginal user profile picture" class="img-responsive">
                            @else
                                <img src="{{ asset('/images/50x50.jpg') }}"
                                     alt="orginal user profile picture" title="orginal user profile picture">
                            @endif
                        </div>
                        <div class="col-md-9 m-t-10">
                            @if($current_page_user->name || $current_page_user->family)
                                <strong>{{ $current_page_user->name . ' ' . $current_page_user->family }}</strong>
                            @else
                                <strong>{{ $current_page_user->user->email }}</strong>
                            @endif
                            <!-- flag & country -->
                            <div class="flag m-t-10">
                                @if (isset($current_page_user->country->attachment))
                                    <img alt="Flag of country" src="{{ asset($current_page_user->country->attachment->path) }}" title="{{ $current_page_user->country->name }}" class="flag-country img-responsive" aria-label="{{ $current_page_user->country->name }}">

                                @endif
                                <span class="locality" itemprop="addressLocality">{{ $current_page_user->country->mainland->name }} / {{ $current_page_user->country->name }}</span>
                            </div>
                        </div>

                        <div class="col-md-12 m-t-40 line-height1-8">
                            <h2>About Me</h2>
                            <p>@if($current_page_user->description) {{ $current_page_user->description }} @endif</p>
                            <div class="m-t-20">
                                <strong class="">${{ $current_page_user->hourly_rate_value }}</strong>
                                <strong> USD/hr</strong>
                            </div>
                        </div>

                        <!-- what skills -->
                        <div class="col-md-12 m-t-40 bor18">
                            <h2>Tags</h2>
                            <ul class="tag-nav portfolio-view-skill">
                                @foreach($block_field['information']['skill']['option'] as $option_value => $option_label)
                                    @if(in_array($option_value, $block_field['information']['skill']['value']))
                                        <li><a href="#">{{ $option_label }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
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
