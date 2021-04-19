<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page-title')</title>
    @php
        $page = "site";
        $get_page = "profile";
        if(isset($_REQUEST['Secourity'])){
            $get_page = "security";
        }
        else{
            $get_page = \Request::segment(1);
        }

    @endphp
    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/icon" href="{{ asset('/images/favicon.png') }}"/>

{{--    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">--}}
    <!-- CSS
    ================================================== -->
    <!-- Bootstrap css file-->
    <link href="{{ asset('/css/bootstrap.min1.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Default Theme css file -->
    <link id="switcher" href="{{ asset('/css/default-theme.css') }}" rel="stylesheet">
    <!-- Slick slider css file -->
    <link href="{{ asset('/css/slick.css') }}" rel="stylesheet">
    <!-- Photo Swipe Image Gallery -->
    <link rel='stylesheet prefetch' href="{{ asset('/css/photoswipe.css') }}">
    <link rel='stylesheet prefetch' href="{{ asset('/css/default-skin.css') }}">
    <link href="{{ asset('/css/flag_icon.css')}}" rel="stylesheet">

    <!-- Main structure css file -->
    <link href="{{ asset('/css/style_theme.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/my-style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/orginalGamaweb.css') }}" rel="stylesheet">

    {{--    <!-- Google fonts -->--}}
    {{--    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>--}}
    {{--    <link href='http://fonts.googleapis.com/css?family=Habibi' rel='stylesheet' type='text/css'>--}}
    {{--    <link href='http://fonts.googleapis.com/css?family=Cinzel+Decorative:900' rel='stylesheet' type='text/css'>--}}

    @yield('css-extend')
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
    <div id="header">
        <!-- END MENU -->
        <!-- dropdown -->
        <div class="">
            <div class="container">
                <!-- main menu white -->
                <ul class="nav nav-me navbar-light display-ruby-block">
                    <li class="navbar-header"><a href="{{url('/')}}"><img class="img-responsive" src="{{ asset('/images/logo_dark.png') }}"></a></li>
                    <li class="active">
                        <div class="dropdown this-dropdown this-dropdown-dLabel1 p-lr-10">
                            <a href="#" id="dLabel1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="text-inverse-me">
                                <p class="text-inverse-me"><span class="fa fa-search pr-2"></span> @lang($page.'.Browse')</p></a>
                            <!-- down -->
                            <div class="dropdown-menu cm-dropdown-menu pddm" aria-labelledby="dLabel1">
                                <div class="row m-t-10 m-b-20">
                                    <div class="col-md-12">
                                        <div class="col-md-1">
                                            <i class="fa fa-search fa-2x p-t-10 cursor-p" id="btn_search"></i>
                                        </div>
                                        <div class="col-md-11">
                                            <input type="text" name="txt_search" id="txt_search" class="form-control" placeholder="Please enter any word...">
                                        </div>
                                    </div>
                                </div>
                                <div class="ContDropDown rep-display p-all-10">
                                    <div class="border-right">
                                        <div class="col-md-12">
                                            <a href="{{ url("/browse-freelancer") }}">
                                                <div class="col-md-2">
                                                    <i class="fa fa-user fa-2x"></i>
                                                </div>
                                                <div class="col-md-10">
                                                    <strong class="p-r-15">@lang($page.'.Freelancers')</strong>
                                                    <span>@lang($page.'.Browse for your favourite freelancer')</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="">
                                        <div class="col-md-12">
                                            <a href="{{ url("/browse-project") }}">
                                                <div class="col-md-2">
                                                    <i class="fa fa-desktop fa-2x"></i>
                                                </div>
                                                <div class="col-md-10">
                                                    <strong class="p-r-15">@lang($page.'.Projects')</strong>
                                                    <span>@lang($page.'.Browse available projects to work on')</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-10 m-b-20 freelancer_search">
                                    <div class="col-md-12">
                                        <lable class="p-all-10">@lang('site.freelancers')</lable>
                                        <br>
                                        <ul class="f_search_list">
                                            <li class="f_search_item_list">
                                                <a href="" class="f_search_item_link">
                                                    <div class="col-md-2 col-sm-2 col-xs-2 m-t-5">
                                                        <img
                                                            src="{{ asset('/images/50x50.jpg') }}"
                                                            class="img-responsive display-inline-block f_search_item_img"
                                                            alt="">
                                                    </div>
                                                    <div class="col-md-10 m-t-8">
                                                        <b class="f_search_item_name"></b>
                                                        <p class="f_search_item_description">@lang('user_profile.Nothing to display')</p>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <a class="f_lbl_more text-primary p-all-5" href="{{ url('/browse-freelancer') }}" data-href="{{ url('/browse-freelancer') }}"><b class="p_search_more">@lang('site.more')...</b></a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row m-t-10 m-b-20 project_search">
                                    <div class="col-md-12">
                                        <lable class="p-all-10">@lang('site.projects')</lable>
                                        <br>
                                        <ul class="p_search_list">
                                            <li class="p_search_item_list">
                                                <a href="" class="p_search_item_link">
                                                    <div class="col-md-2 m-t-5">
                                                        <i class="fa fa-desktop fa-2x p-t-10 cursor-p"></i>
                                                    </div>
                                                    <div class="col-md-10 m-t-8">
                                                        <b class="p_search_item_name"></b>
                                                        <p class="p_search_item_description">@lang('user_profile.Nothing to display')</p>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <a class="p_lbl_more text-primary p-all-5" href="{{ url('/browse-project') }}" data-href="{{ url('/browse-project') }}"><b class="p_search_more">@lang('site.more')...</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a href="{{url('/all-project')}}"><p class="text-inverse-me"><span class="fa fa-desktop pr-2"></span> @lang('site.My Projects')</p></a></li>
                    @if(isset($current_user) && isset($chat))
                    <li><a href="{{url('/chats')}}" target="_blank"><p class="text-inverse-me"><span class="fa fa-comments-o pr-2"></span> @lang('site.Chat') @if($chat)<img class="img-responsive new-chat" src="{{ asset('/images/new.png') }}">@endif </p></a></li>
                    @endif
                    {{--<li><a href="#" ><p class="text-inverse-me"><span class="fa fa-inbox pr-2"></span> Inbox</p></a></li>--}}
                    <!-- profile & button-->
                    @if($current_user)
                        <li class="profile-li profile-border">
                            <!-- profile menu -->
                            <div class="dropdown this-dropdown">
                                <a href="#" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="display-inline-block user_profile_img">
                                        <img
                                            src="@if(isset($current_user->profile_img->path) && $current_user->profile_img->path){{ asset($current_user->profile_img->path) }}@else{{ asset('/images/50x50.jpg') }} @endif"
                                            class="img-responsive display-inline-block" alt="user profile picture"
                                            title="user profile picture">
                                    </div>
                                    @if($current_user->username)
                                        <strong>{{ '@'.$current_user->username }}</strong>
                                    @else
                                        <strong>{{ $current_user->name . ' ' . $current_user->family}}</strong>
                                    @endif
                                </a>
                                <!-- down -->
                                <div class="dropdown-menu cm-dropdown-menu" aria-labelledby="dLabel">
                                    <div class="ContDropDown rep-display">
                                        <div class="finances-DD">
                                            <div class="title-finances-DD">
                                                <h4>@lang($page.'.Finances')</h4>
                                                <a href="{{url('/profile/'.$current_page_user->username.'/edit?Payment')}}">@lang($page.'.Manage')</a>
                                            </div>
                                            <ul>
                                                <li>@lang('site.Balances')</li>
                                                <li class="bance">
                                                    <strong class="">${{ $current_page_user->hourly_rate_value }}</strong>
                                                    <span> USD/hr</span>
                                                </li>
{{--                                                <li><a href="">Deposit Funds</a></li>--}}
{{--                                                <li><a href="">Withdraw Funds</a></li>--}}
                                                <li><a href="{{url('/profile/'.$current_page_user->username.'/edit?Payment')}}">@lang('site.Transaction History')</a></li>
{{--                                                <li><a href="">Financial Dashboard</a></li>--}}
                                            </ul>
                                        </div>
                                        <!--  -->
                                        <div class="account-DD">
                                            <div class="title-account-DD">
                                                <h4>@lang($page.'.Account')</h4>
                                                <a href="{{url('/profile/'.$current_page_user->username.'/edit')}}">@lang($page.'.Manage')</a>
                                            </div>
                                            <ul>
                                                <li><a href="{{url('/profile/'.$current_user->username)}}">@lang($page.'.View Profile')</a></li>
                                                {{--                                        <li><a href="">Manage Membership</a></li>--}}
                                                <li><a href="{{url('/profile/'.$current_page_user->username.'/edit')}}">@lang($page.'.User Settings')</a></li>
                                                {{--<li><a href="">Discover Insights</a></li>--}}
                                                <li><a href="{{url('/faq/help')}}">@lang($page.'.Get Support')</a></li>
                                                {{--<li><a href="">Invite Friend</a></li>--}}
                                                <li><a href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a></li>
                                            </ul>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- button post project -->
                        <li class="project-li"><a href="{{url('/postProject')}}" class="notHover"><button type="button" class="min-height35 btn post-project-btn">@lang($page.'.Post a Project')</button></a></li>
                    @else
                        <ul class="login-topbar">
                            <li class="profile-li">
                                <a href="{{url('/login')}}"><strong>@lang($page.'.sign in')</strong></a> &nbsp;&nbsp;
                                <a href="{{url('/register')}}"><strong>@lang($page.'.sign up')</strong></a>
                            </li>
                            <li class="project-li"><a href="{{url('/postProject')}}" class="notHover"><button type="button" class="min-height35 btn post-project-btn">@lang($page.'.Post a Project')</button></a></li>
                        </ul>
                    @endif
                </ul>
            </div>
        </div>

        <!-- second menu black -->
        <div class="SecondHeader-dashborad">
            <div class="topnav">
                <div class="container">
                    @if($current_user)<a href="{{url('/profile/'.$current_user->username)}}" @if($get_page == "profile") class="active" @endif>@lang($page.'.Profile') </a>@endif
                    <a href="{{url('/all-project')}}">@lang($page.'.Projects')</a>
                    <a href="{{url('/faq/help')}}" @if($get_page == "faq") class="active" @endif>@lang($page.'.Get Support')</a>
                    @if($current_user)<a href="{{url('/profile/'.$current_user->username . '/edit?Secourity')}}" @if($get_page == "security") class="active" @endif>@lang($page.'.Account Secourity') </a>@endif
                    @if($current_user)<a href="{{url('/portfolio/'.$current_user->username . '/list')}}" @if($get_page == "portfolio") class="active" @endif>@lang($page.'.Portfolio') </a>@endif
                </div>
            </div>
        </div>
    </div>
    <!--=========== END HEADER ================-->

    @yield('page_content')

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

</div>

<!-- jQuery Library  -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap default js -->
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<!-- slick slider -->
<script src="{{ asset('/js/slick.min.js') }}"></script>
<script src="{{ asset('/js/modernizr.custom.79639.js') }}" type="text/javascript"></script>
<!-- counter -->
<script src="{{ asset('/js/waypoints.min.js') }}"></script>
<script src="{{ asset('/js/jquery.counterup.min.js') }}"></script>
<!-- Doctors hover effect -->
<script src="{{ asset('/js/snap.svg-min.js') }}"></script>
<script src="{{ asset('/js/hovers.js') }}"></script>
<!-- Photo Swipe Gallery Slider -->
<script src='{{ asset('/js/photoswipe.min.js') }}'></script>
<script src='{{ asset('/js/photoswipe-ui-default.min.js') }}'></script>
<script src="{{ asset('/js/photoswipe-gallery.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('/js/custom.js') }}"></script>

<!-- Custom JS -->
<script>window.jQuery || document.write('<script src="/js/jquery-1.10.2.min.js"><\/script>')</script>
<script src="{{ asset('/js/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.reveal.js') }}"></script>
@yield('script-extend')
<script src="{{ asset('/js/search.js') }}"></script>
<script>
    var csrf_token = "{{csrf_token()}}";
    var url_profile = "{{ url('/profile/') }}/";
    var url_project = "{{ url('/project-detail/') }}/";
    var img_default = "{{ asset('/images/50x50.jpg') }}";
    var public_address = "{{ asset("/") }}";
    var message_tr = '@lang("user_profile.Nothing to display")';
</script>
</body>
</html>
