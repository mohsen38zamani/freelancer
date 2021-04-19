<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/flag_icon.css')}}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield("header")
</head>
<body>

<div id="app">
    @yield('top_content')
    <div id="app">

        <main class="py-4">
        @yield('content')
            <!--=========== Start Footer ================-->
            @if(isset($footer) && \Request::segment(1) != "login" && \Request::segment(1) != "UserInfo"  && \Request::segment(1) != "skill"  && \Request::segment(1) != "Username=^s" && \Request::segment(1) != "register" && \Request::segment(1) != "Username" && \Request::segment(1) != "Username")
                <footer id="footer">
                    <!-- Start Footer Top -->
                    <div class="footer-top mt_5">
                        <div class="container">
                            <div class="row">
                                @if(collect($footer ?? ''[0])->contains('About Us'))
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="single-footer-widget">
                                            <div class="section-heading">
                                                <h2>@lang('footermenu.'.$footer ?? ''[0]->name)</h2>
                                                <div class="line"></div>
                                            </div>
                                            <p>@lang('footeritem.'.$footer ?? ''[0]->Footeritem[0]->name)</p>
                                        </div>
                                    </div>
                                @endif

                                @if(collect($footer ?? ''[1])->contains('Our Service'))
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="single-footer-widget">
                                            <div class="section-heading">
                                                <h2>@lang('footermenu.'.$footer ?? ''[1]->name)</h2>
                                                <div class="line"></div>
                                            </div>
                                            <ul class="footer-service">
                                                @foreach($footer ?? ''[1]->Footeritem as $list)
                                                    <li><a href="{{url($list->url)}}"><span class="fa fa-check"></span>@lang('footeritem.'.$list->name)</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                @if(collect($footer ?? ''[2])->contains('Tags'))
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="single-footer-widget">
                                            <div class="section-heading">
                                                <h2>@lang('footermenu.'.$footer ?? ''[2]->name)</h2>
                                                <div class="line"></div>
                                            </div>
                                            <ul class="tag-nav">
                                                @foreach($footer ?? ''[2]->Footeritem as $list)
                                                    <li><a href="{{url($list->url)}}">@lang('footeritem.'.$list->name)</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                @if(collect($footer ?? ''[3])->contains('Contact Info'))
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="single-footer-widget">

                                            <div class="section-heading">
                                                <h2>@lang('footermenu.'.$footer ?? ''[3]->name)</h2>
                                                <div class="line"></div>
                                            </div>

                                            <p>@lang('footeritem.'.$footer ?? ''[3]->Footeritem[0]->name)</p>
                                            <address class="contact-info">
                                                <p><span class="fa fa-home"></span>@lang('footeritem.'.$footer ?? ''[3]->Footeritem[1]->name)</p>
                                                <p><span class="fa fa-phone"></span>{{$footer ?? ''[3]->Footeritem[2]->name}}</p>
                                                <p><span class="fa fa-envelope"></span>{{$footer ?? ''[3]->Footeritem[3]->name}}</p>
                                            </address>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Start Footer Middle -->
                    <div class="footer-middle">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="footer-copyright disp_inline_flex">
                                        <a href="{{ url('locale/de') }}" ><div class="text-white m-r20 cursor-p lng-select"><span class="flag-icon flag-icon-de"> </span>  German</div></a>
                                        <a href="{{ url('locale/en') }}" ><div class="text-white m-r20 cursor-p lng-select"><span class="flag-icon flag-icon-en"> </span>  English</div></a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="footer-social">
                                        @if (isset($socialmedialist) && $socialmedialist)
                                            @foreach($socialmedialist as $item)
                                                <a href="{{ $item->link }}"><span class="fa {{ $item->description }}"></span></a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Footer Bottom -->
                    <div class="footer-bottom">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Design & Developed By <a rel="nofollow" href="http://www.gamaweb.ir/">GamaWeb</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            @endif
            <!--=========== End Footer ================-->
        </main>
    </div>

</div>
@yield('script')
</body>
</html>
