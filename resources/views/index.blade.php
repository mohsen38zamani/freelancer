<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>monofreelancer : Home</title>

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/icon" href="{{asset('images/favicon.png')}}"/>

    <!-- CSS
    ================================================== -->
    <!-- Bootstrap css file-->
    <link href="{{asset('/css/bootstrap.min1.css')}}" rel="stylesheet">

    <link href="{{ asset('/assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Default Theme css file -->
    <link id="switcher" href="{{ asset('/css/default-theme.css')}}" rel="stylesheet">
    <!-- Slick slider css file -->
    <link href="{{ asset('/css/slick.css')}}" rel="stylesheet">
    <!-- Photo Swipe Image Gallery -->
    <link rel='stylesheet prefetch' href="{{ asset('/css/photoswipe.css') }}">
    <link rel='stylesheet prefetch' href="{{ asset('/css/default-skin.css') }}">
    <link rel='stylesheet prefetch' href="{{ asset('/css/my-style.css') }}">

    <!-- Main structure css file -->
    <link href="{{ asset('/css/style_theme.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/flag_icon.css')}}" rel="stylesheet">
    <!-- sweet alerts -->
    <link href="{{ asset('/assets/sweet-alert/sweet-alert.min.css') }}" type="text/css" rel="stylesheet"/>

@yield('header')

</head>


<body>
<div class="flex-center position-ref full-height">
    <!-- BEGAIN PRELOADER -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- END PRELOADER -->

    <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"><i class="fa fa-arrow-up"></i></a>
    <!-- END SCROLL TOP BUTTON -->

    <!--=========== BEGIN HEADER ================-->
    <header id="header">
        <!-- BEGIN MENU -->
        <div class="menu_area">
            <nav class="navbar navbar-default navbar-fixed-top mb-0" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <!-- FOR MOBILE VIEW COLLAPSED BUTTON -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- LOGO -->
                        <!-- TEXT BASED LOGO -->
                        <a href="{{url('/')}}"><img class="index-logo" src="{{asset('/images/logo_index.png')}}"></a>

						<div class="language-header">
                            <div class="footer-copyright disp_inline_flex">
                                <a href="{{ url('locale/de') }}" ><div class="text-white m-r20 cursor-p lng-select"><span class="flag-icon flag-icon-de"> </span>  German</div></a>
                                <a href="{{ url('locale/en') }}" ><div class="text-white m-r20 cursor-p lng-select"><span class="flag-icon flag-icon-en"> </span>  English</div></a>
                            </div>
                        </div>

                        <!-- IMG BASED LOGO  -->
                        <!--  <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="logo"></a>   -->
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul id="top-menu" class="nav navbar-nav navbar-right main-nav">
                            <li><a href="{{url('/postProject')}}">@lang('site.Post Project')</a></li>
{{--                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Page <span class="fa fa-angle-down"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">404 Page</a></li>
                                    <li><a href="#">Help</a></li>
                                </ul>
                            </li>--}}
                            <li>
                                <a href="{{route('contact')}}">@lang('site.Contact us')</a>
                            </li>

                            <li>
                                <a href="{{route('help')}}">@lang('site.Help Working')</a>
                            </li>

                            @if (Route::has('login'))
                                @auth
                                    @php
                                        $username = \App\User_profile::where('userid', \Illuminate\Support\Facades\Auth::id())->value('username');
                                    @endphp
                                    <li><a href="{{ url("/profile/$username") }}">@lang('site.Profile')</a></li>
                                @else
                                    <li><a href="{{ route('login') }}">| &nbsp; @lang('site.Login')</a></li>
                                    @if (Route::has('register'))
                                        <li ><a href="{{ route('register') }}">@lang('site.SignUp')</a></li>
                                    @endif
                                @endauth
                            @endif
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>
        </div>
        <!-- END MENU -->
    </header>
    <!--=========== END HEADER ================-->

    @yield('body')

    <!--=========== Start Footer ================-->
    <footer id="footer">
        <!-- Start Footer Top -->
        <div class="footer-top mt_5">
            <div class="container">
                <div class="row">
                    @if(collect($footer[0])->contains('About Us'))
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="single-footer-widget">
                                <div class="section-heading">
                                    <h2>@lang('footermenu.'.$footer[0]->name)</h2>
                                    <div class="line"></div>
                                </div>
                                <p>@lang('footeritem.'.$footer[0]->Footeritem[0]->name)</p>
                            </div>
                        </div>
                    @endif

                    @if(collect($footer[1])->contains('Our Service'))
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="single-footer-widget">
                                <div class="section-heading">
                                    <h2>@lang('footermenu.'.$footer[1]->name)</h2>
                                    <div class="line"></div>
                                </div>
                                <ul class="footer-service">
                                    @foreach($footer[1]->Footeritem as $list)
                                        <li><a href="{{url($list->url)}}"><span class="fa fa-check"></span>@lang('footeritem.'.$list->name)</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if(collect($footer[2])->contains('Tags'))
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="single-footer-widget">
                                <div class="section-heading">
                                    <h2>@lang('footermenu.'.$footer[2]->name)</h2>
                                    <div class="line"></div>
                                </div>
                                <ul class="tag-nav">
                                    @foreach($footer[2]->Footeritem as $list)
                                        <li><a href="{{url($list->url)}}">@lang('footeritem.'.$list->name)</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if(collect($footer[3])->contains('Contact Info'))
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="single-footer-widget">

                                <div class="section-heading">
                                    <h2>@lang('footermenu.'.$footer[3]->name)</h2>
                                    <div class="line"></div>
                                </div>

                                <p>@lang('footeritem.'.$footer[3]->Footeritem[0]->name)</p>
                                <address class="contact-info">
                                    <p><span class="fa fa-home"></span>@lang('footeritem.'.$footer[3]->Footeritem[1]->name)</p>
                                    <p><span class="fa fa-phone"></span>{{$footer[3]->Footeritem[2]->name}}</p>
                                    <p><span class="fa fa-envelope"></span>{{$footer[3]->Footeritem[3]->name}}</p>
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
    <!--=========== End Footer ================-->
    <div id="app"></div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<!-- jQuery Library  -->
<script src="{{ asset('/js/jquery.js') }}"></script>
<!-- Bootstrap default js -->
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<!-- slick slider -->
<script src="{{ asset('/js/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/modernizr.custom.79639.js') }}"></script>
<!-- counter -->
<script src="{{ asset('/js/waypoints.min.js') }}"></script>
<script src="{{ asset('/js/jquery.counterup.min.js') }}"></script>
<!-- Doctors hover effect -->
<script src="{{ asset('/js/snap.svg-min.js') }}"></script>
<script src="{{ asset('/js/hovers.js') }}"></script>
<!-- Photo Swipe Gallery Slider -->
<script src="{{ asset('/js/photoswipe.min.js') }}"></script>
<script src="{{ asset('/js/photoswipe-ui-default.min.js') }}"></script>
<script src="{{ asset('/js/photoswipe-gallery.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('/js/custom.js') }}"></script>

<!-- Custom JS -->
<script>window.jQuery || document.write('<script src="{{ asset('/js/jquery-1.10.2.min.js') }}"><\/script>')</script>
<script type="text/javascript" src="{{ asset('/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('/js/jquery.reveal.js') }}"></script>
@yield('script')
</body>
</html>
