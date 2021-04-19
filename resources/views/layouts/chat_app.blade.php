@php
    $page = 'site';
    $current_page_user = $current_user;
    $get_page = "profile";
    if(isset($_REQUEST['Secourity'])){
        $get_page = "security";
    }
    else{
        $get_page = \Request::segment(1);
    }
@endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}: chat</title>
    <link rel="shortcut icon" type="image/icon" href="{{ asset('/images/favicon.png') }}"/>
    <link href="{{ asset('/assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Main structure css file -->
    <link href="{{ asset('/css/my-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/chat_app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<div id="app">
    <!--=========== BEGIN HEADER ================-->
    <div id="header">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <ul class="nav nav-me navbar-light display-ruby-block">
                    <li class="navbar-header"><a href="{{url('/profile/'.$current_user->user_profile->username)}}"><img class="img-responsive" src="{{ asset('/images/logo_dark.png') }}"></a></li>
                </ul>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->email }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

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

    <main class="py-4">
        <div id="app"></div>

        @yield('content')
    </main>
</div>
</body>
</html>
