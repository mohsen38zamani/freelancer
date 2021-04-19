@extends('site.mainpage')
@section('page_content')
    @php
        $page = \Request::segment(1);
        $page_action = \Request::segment(2);
         if(\Request::segment(3)){
             $item_id = \Request::segment(3);
         }

    @endphp
    @section('page-title') {{ ucfirst($page_action) . ' ' .$page . 's' }} @endsection
    <!-- main profile -->
    <div class="container">
        <div class="row">
            <!-- profile -->
            <div class="col-12 col-md-12">
                <div class="profile">
                    <div class="top-div-profile">
                        <h1 class="title-profile line-height2-5">Portfolios</h1>
                        @if($authenticatied)
                            <a class="btn btn-success saveSetting line-height2-5" href="/portfolio/new" target="_blank">+ Add item</a>
                        @endif
                    </div>
                    <div class="contact-profile">
                        @if (count($portfolio))
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach($portfolio as $key => $item)
                                            <div class="col-md-3 portfolio-box m-b-30">
                                                <a href="@if($authenticatied){{ url("/portfolio/edit/") }}@else{{ url("/portfolio/view/") }}@endif/{{ $item->portfolioid }}" class="">{{--display-inline-block user_profile_img--}}
                                                    <img src="@if(isset($item->attachment) && $item->attachment->path){{ asset($item->attachment->path) }}@else{{ asset('/images/question.jpg') }} @endif"
                                                         class="img-responsive portfolio-image" alt="portfolio picture" title="{{ $item->name }}">
                                                    <div class="">
                                                        <span class="portfolio-image-text">{{ $item->name }}</span>
                                                    </div>
                                                </a>
                                            </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center">
                                <div class="display-inline-block user_profile_img">
                                    <img src="{{ asset('/images/portfolio.png') }}" class="img-responsive display-inline-block" alt="portfolio picture" title="portfolio">
                                </div>
                                <span>You dont have any portfolio. <a href="{{ dd("/portfolio/new") }}">Click to add a new portfolio!</a></span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script-extend')

@endsection
