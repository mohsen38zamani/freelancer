@extends('layouts.app')

{{--section header--}}
@section('header')
    <!-- Bootstrap css file-->
    <link href="{{asset('/css/bootstrap.min1.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/default-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/my-style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/gama.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/orginalGamaweb.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/pretty-checkbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/sweet-alert/sweet-alert.min.css') }}" type="text/css" rel="stylesheet"/>
@endsection

@section('content')
    @php
        $page = "site";
        $checkEdit = \Request::segment(2);
    @endphp
    <!--=========== BEGIN HEADER ================-->
    <div id="header">
        <!-- dropdown -->
        <div class="">
            <div class="container">
                <!-- main menu white -->
                <ul class="nav nav-me navbar-light display-ruby-block">
                    <li class="navbar-header"><a href="{{url('/')}}"><img class="img-responsive" src="{{ asset('/images/logo_dark.png') }}"></a></li>
                    <li class="active">
                        <div class="dropdown this-dropdown this-dropdown-dLabel1 p-lr-10">
                            <a href="#" id="dLabel1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="text-inverse-me"><p class="text-inverse-me"><span class="fa fa-search pr-2"></span> @lang($page.'.Browse')</p></a>
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
                    <li><a href="{{url('/all-project')}}"><p class="text-inverse-me"><span class="fa fa-desktop pr-2"></span> My Projects</p></a></li>
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
                                                <li>@lang($page.'.Balances')</li>
                                                <li class="bance">$0.00 USD</li>
                                                {{--                                                <li><a href="">Deposit Funds</a></li>--}}
                                                {{--                                                <li><a href="">Withdraw Funds</a></li>--}}
                                                <li><a href="#">@lang($page.'.Transaction History')</a></li>
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
                    <a href="{{url('/all-project')}}" class="active">My Projects</a>
                    @if($current_user)<a href="{{url('/profile/'.$current_user->username)}}">@lang($page.'.Profile') </a>@endif
                </div>
            </div>
        </div>
    </div>
    <!--=========== END HEADER ================-->

    <!-- content page -->
    <div class="container">
        <section id="main-container-dashbord">
            <div class="row">
            {{--     start content       --}}
            <!-- title And button -->
                <div class="col-md-12">
                    <!-- title -->
                    <div class="f-left title-project">
                        <h1>project</h1>
                    </div>
                    <!-- button toggle -->
                    <div class="f-right">
                        <div class="switcher">
                            <input type="radio" name="balance" id="tab_employer" class="switcher__input switcher__input--yin" checked="">
                            <label for="tab_employer" class="switcher__label">@lang($page.'.Employer')</label>

                            <input type="radio" name="balance" id="tab_freelancer" class="switcher__input switcher__input--yang">
                            <label for="tab_freelancer" class="switcher__label">@lang($page.'.Freelancer')</label>

                            <span class="switcher__toggle"></span>
                        </div>
                    </div>
                </div>
                <!-- dropdown -->
                <div class="col-md-12">
                    <ul id="tab_menu_main" class="display-flex nav-tabs-me">
                        <li id="get_project_open" class="active"><a data-toggle="tab" href="#Open">@lang($page.'.Open')</a></li>
                        <li id="get_project_workinprogress"><a data-toggle="tab" href="#Work_in_Progress">@lang($page.'.Work in Progress')</a></li>
                        <li id="get_project_past"><a data-toggle="tab" href="#Past_Projects">@lang($page.'.Past Projects')</a></li>
                    </ul>

                    <div class="tab-content">
                        {{--------------- Box Search ---------------}}
                        <div class="">
                            <div class="col-md-12 col-sm-6 p-all-10">
                                <!-- search -->
                                <div class="form-group d-flex">
                                    <input id="textSearch" type="search" class="form-control" placeholder="@lang($page.'.Enter name project')" />
                                    <button id="searchData" class="btn btn-gray2 ml-0" ><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>

                        {{--------------- menu -> open ---------------}}
                        <div class="tab-pane fade in active p-all-10">
                            <table class="table border-table-me">
                                <thead class="thead-dark">
                                <tr id="thead_table">
                                    {{--                                    menu table--}}
                                </tr>
                                </thead>
                                <tbody id="tr_List_record">
                                {{--                                tbody--}}
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                {{--     end content       --}}
            </div>
        </section>
    </div>
    <!--END content -->
@endsection

@section('script')
    <!-- Bootstrap default js -->
    <script>window.jQuery || document.write('<script src="{{asset('/js/minified/jquery-1.11.0.min.js')}}"><\/script>')</script>
    <!-- jQuery  -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('/assets/fastclick/fastclick.js') }}"></script>
    <script src="{{ asset('/assets/sweet-alert/sweet-alert.min.js') }}"></script>

    <script type="text/javascript">

        var typeTab = 0;
        var resizefunc = [];
        var typePost = "project";
        var typeTab = "opened";
        var id_type = 0;

        $(document).ready(function () {
            $('.py-4').removeClass('py-4');
            $('#tab_employer').click();
            searchData();
            $('#tab_employer').click(function () {
                $('#tab_menu_main').empty();

                $('#tab_menu_main').append('<li id="get_project_open" class="active"><a data-toggle="tab" href="#Open">@lang($page.'.Open')</a></li>\n' +
                    '<li id="get_project_workinprogress"><a data-toggle="tab" href="#Work_in_Progress">@lang($page.'.Work in Progress') </a></li>\n' +
                    '<li id="get_project_past"><a data-toggle="tab" href="#Past_Projects">@lang($page.'.Past Projects')</a></li>');

                typePost = "project";
                typeTab = "opened";
                id_type = 0;
                searchData();
            });

            $('#tab_freelancer').click(function () {
                $('#thead_table').empty();
                $('#tr_List_record').empty();

                $('#tab_menu_main').empty();

                $('#tab_menu_main').append('<li id="get_freelancer_bid" class="active"><a data-toggle="tab" href="#Open">@lang($page.'.Bid')</a></li>\n' +
                    '<li id="get_freelancer_workinprogress"><a data-toggle="tab" href="#Work_in_Progress">@lang($page.'.Work in Progress')</a></li>\n' +
                    '<li id="get_freelancer_past"><a data-toggle="tab" href="#Past_Projects">@lang($page.'.Past Projects')</a></li>');

                typePost = "freelancer";
                typeTab = "bid";
                id_type = 3;
                searchData();
            });
            //------click items in tab employer -> direct in page project detaile.
            $(document).on("click",".go_to_projectDetaile",function () {
                projectid = $(this).attr('data-value');
                window.location.href = "{{url('/project-detail/')}}/"+projectid;
            });
            //------click items in tab freelancer -> direct in page project proposal (request bids).
            $(document).on("click",".go_to_freelancer-proposal",function () {
                projectid = $(this).attr('data-value');
                window.location.href = "{{url('/project-proposal/')}}/"+projectid;
            });
            $(document).on("click","#get_project_open",function () {
                typePost = "project";
                typeTab = "opened";
                id_type = 0;
                searchData();
            });
            $(document).on("click","#get_project_past",function () {
                typePost = "project";
                typeTab = "closed";
                id_type = 1;
                searchData();
            });
            $(document).on("click","#get_project_workinprogress",function () {
                typePost = "project";
                typeTab = "working";
                id_type = 2;
                searchData();
            });
            $(document).on("click","#get_freelancer_bid",function () {
                typePost = "freelancer";
                typeTab = "bid";
                id_type = 3;
                searchData();
            });
            $(document).on("click","#get_freelancer_workinprogress",function () {
                typePost = "freelancer";
                typeTab = "working";
                id_type = 4;
                searchData();
            });
            $(document).on("click","#get_freelancer_past",function () {
                typePost = "freelancer";
                typeTab = "ending";
                id_type = 5;
                searchData();
            });
            $(document).on("click","#ending_project",function () {
               //----project end.
                manage_projectid = $(this).attr('data-value');
                swal({
                    title:"@lang('site.Are you sure you want to Ending the project?')",
                    text:"@lang('site.If you wish to ending project and press the Yes button')",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#4edd06",
                    confirmButtonText: "Yes",
                    closeOnConfirm: true
                }, function (isConfirm) {
                    if (Boolean(isConfirm)) {
                        project_ending(manage_projectid);
                    }
                });

            });
            $('#searchData').click(function () {
                searchData();
            })
        });

        function searchData() {
            var formData = new FormData();
            var _val = "{{csrf_token()}}";
            formData.append('_token', _val);
            formData.append('text', $('#textSearch').val());
            formData.append('type', typePost);
            formData.append('typeTab', typeTab);

            $.ajax({
                url: "{{url('/all-project/getProjectList')}}",
                type: 'POST',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (result) {
                    if(result){
                        switch (parseInt(id_type)) {
                            case 0:
                                projectOpened(result);
                                break;
                            case 1:
                                projectClosed(result);
                                break;
                            case 2:
                                projectWorking(result);
                                break;
                            case 3:
                                projectBid_F(result);
                                break;
                            case 4:
                                projectWorking_F(result);
                                break;
                            case 5:
                                projectEnding_F(result);
                                break;
                        }
                    }
                }
            });
        }
        //------tab employer
        function projectOpened(result){
            $('#thead_table').empty();
            $('#thead_table').append('<th scope="col">#</th>\n' +
                '<th scope="col">@lang($page.'.Name Project') </th>\n' +
                '<th scope="col">@lang($page.'.Create at')</th>\n' +
                '<th scope="col">@lang($page.'.Action')</th>');


            $('#tr_List_record').empty();
            $.each(result, function (key, value) {
                url = "{{url('/project-detail/edit/')}}/" + value["projectid"];
                $('#tr_List_record').append('<tr>\n' +
                    '                                <th scope="row"><div class="min-height">'+key+'</div> </th>\n' +
                    '                                <td class="go_to_projectDetaile pointer" data-value="'+value["projectid"]+'"><div class="min-height">'+value["name"]+'</div></td>\n' +
                    '                                <td><div class="min-height">'+value["updated_at"]+'</div></td>\n' +
                    '                                <td>\n' +
                    '                                   <div class="dropdown">\n' +
                    '                                       <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Select</button>\n' +
                    '                                       <ul class="dropdown-menu">\n' +
                    '                                           <li><a href="'+url+'">@lang($page.'.Edit')</a></li>\n' +
                    '                                           <li class="divider"></li>\n' +
                    '                                           <li class="pointer"><a onclick="delete_project('+value["projectid"]+',-1)">@lang($page.'.Delete')</a></li>\n' +
                    '                                           <li class="pointer"><a onclick="close_project('+value["projectid"]+')">@lang($page.'.Close')</a></li>\n' +

                    '                                       </ul>\n' +
                    '                                   </div>\n' +
                    '                                </td>\n' +
                    '                        </tr>');
            });
        };
        function projectClosed(result){
            $('#thead_table').empty();
            $('#thead_table').append('<th scope="col">#</th>\n' +
                '<th scope="col">@lang($page.'.Name Project')</th>\n' +
                '<th scope="col">@lang($page.'.Create at')</th>');

            $('#tr_List_record').empty();
            $.each(result, function (key, value) {
                url = "{{url('/project-detail/edit/')}}"+value["projectid"];
                $('#tr_List_record').append('<tr>\n' +
                    '                                <th scope="row"><div class="min-height">'+key+'</div> </th>\n' +
                    '                                <td class="go_to_projectDetaile pointer" data-value="'+value["projectid"]+'"><div class="min-height">'+value["name"]+'</div></td>\n' +
                    '                                <td><div class="min-height">'+value["updated_at"]+'</div></td>\n' +
                    '                        </tr>');
            });
        };
        function projectWorking(result){
            $('#thead_table').empty();
            $('#thead_table').append('<th scope="col">#</th>\n' +
                '<th scope="col">@lang($page.'.Name Project')</th>\n' +
                '<th scope="col">@lang($page.'.Name Freelancer')</th>\n' +
                '<th scope="col">@lang($page.'.Date Start')</th>\n' +
                '<th scope="col">@lang($page.'.Action')</th>');

            $('#tr_List_record').empty();
            $.each(result, function (key, value) {
                $('#tr_List_record').append('<tr>\n' +
                    '                                <th scope="row"><div class="min-height">'+key+'</div> </th>\n' +
                    '                                <td class="go_to_projectDetaile pointer" data-value="'+value["projectid"]+'"><div class="min-height">'+value["name"]+'</div></td>\n' +
                    '                                <td><div class="min-height">'+value["manage_project"]["bids_project"]["user_profile"]["name"]+" "+value["manage_project"]["bids_project"]["user_profile"]["family"]+'</div></td>\n' +
                    '                                <td><div class="min-height">'+value["manage_project"]["start_date"]+'</div></td>\n' +
                    '                                <td>\n' +
                    '                                   <div class="dropdown">\n' +
                    '                                       <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Select</button>\n' +
                    '                                       <ul class="dropdown-menu">\n' +
                    '                                           <li class="pointer"><a id="ending_project" data-value="'+value["manage_project"]["manage_projectid"]+'">@lang($page.'.Ending')</a></li>\n' +

                    '                                       </ul>\n' +
                    '                                   </div>\n' +
                    '                                </td>\n' +
                    '                        </tr>');
            });
        };

        //------tab freelancer
        function projectBid_F(result){
            $('#thead_table').empty();
            $('#thead_table').append('<th scope="col">#</th>\n' +
                '<th scope="col">@lang($page.'.Name Project')</th>\n' +
                '<th scope="col">@lang($page.'.Date Bid')</th>');

            $('#tr_List_record').empty();
            $.each(result, function (key, value) {
                $('#tr_List_record').append('<tr>\n' +
                    '                                <th scope="row"><div class="min-height">'+key+'</div> </th>\n' +
                    '                                <td class="go_to_freelancer-proposal pointer" data-value="'+value["projectid"]+'"><div class="min-height">'+value["project"][0]["name"]+'</div></td>\n' +
                    '                                <td><div class="min-height">'+value["created_at"]+'</div></td>\n' +
                    '                        </tr>');
            });
        };
        function projectWorking_F(result){
            $('#thead_table').empty();
            $('#thead_table').append('<th scope="col">#</th>\n' +
                '<th scope="col">@lang($page.'.Name Project')</th>\n' +
                '<th scope="col">@lang($page.'.Name Employer')</th>\n' +
                '<th scope="col">@lang($page.'.Date Start')</th>');

            $('#tr_List_record').empty();
            $.each(result, function (key, value) {
                $('#tr_List_record').append('<tr>\n' +
                    '                                <th scope="row"><div class="min-height">'+key+'</div> </th>\n' +
                    '                                <td class="go_to_freelancer-proposal pointer" data-value="'+value["projectid"]+'"><div class="min-height">'+value["project"][0]["name"]+'</div></td>\n' +
                    '                                <td><div class="min-height">'+value["project"][0]["user_profile"]["name"]+" "+value["project"][0]["user_profile"]["family"]+'</div></td>\n' +
                    '                                <td><div class="min-height">'+value["manage_project"]["start_date"]+'</div></td>\n' +
                    '                        </tr>');
            });
        };
        function projectEnding_F(result){
            $('#thead_table').empty();
            $('#thead_table').append('<th scope="col">#</th>\n' +
                '<th scope="col">@lang($page.'.Name Project')</th>\n' +
                '<th scope="col">@lang($page.'.Name Employer')</th>\n' +
                '<th scope="col">@lang($page.'.Date Ending')</th>');

            $('#tr_List_record').empty();
            $.each(result, function (key, value) {
                $('#tr_List_record').append('<tr>\n' +
                    '                                <th scope="row"><div class="min-height">'+key+'</div> </th>\n' +
                    '                                <td class="go_to_freelancer-proposal pointer" data-value="'+value["projectid"]+'"><div class="min-height">'+value["project"][0]["name"]+'</div></td>\n' +
                    '                                <td><div class="min-height">'+value["project"][0]["user_profile"]["name"]+" "+value["project"][0]["user_profile"]["family"]+'</div></td>\n' +
                    '                                <td><div class="min-height">'+value["manage_project"]["end_date"]+'</div></td>\n' +
                    '                        </tr>');
            });

        };


        function project_ending(id) {
            var formData = new FormData();
            var _val = "{{csrf_token()}}";
            formData.append('_token', _val);
            formData.append('id', id);

            $.ajax({
                url: "{{url('/project-ending')}}",
                type: 'POST',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (result) {
                    if (Boolean(result)) {
                        swal("Notice","@lang('site.Project is end.')", "success");
                        location.reload();
                    } else {
                        swal("Notice","@lang('site.Wrong in ending project.')", "error");
                    }
                }
            });
        }
        function delete_project(id,type) {
            swal({
                title:"@lang('site.Are you sure you want to delete the project?')",
                text:"@lang('site.If you wish to delete and press the Yes button')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4edd06",
                confirmButtonText: "Yes",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (Boolean(isConfirm)) {
                    var formData = new FormData();
                    var _val = "{{csrf_token()}}";
                    formData.append('_token', _val);
                    formData.append('id', id);

                    $.ajax({
                        url: "{{url('/project-detail/delete')}}",
                        type: 'POST',
                        data: formData,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        success: function (result) {
                            if (Boolean(result)) {
                                swal("Notice","@lang('site.Project is delete.')", "success");
                                if(type != -1){
                                    $('#tr'+type).remove();
                                }else{
                                    location.reload();
                                }
                            } else {
                                swal("Notice","@lang('site.Wrong in delete project.')", "error");
                            }
                        }
                    });
                }
            });
        }

        function close_project(id) {
            swal({
                title:"@lang('site.Are you sure you want to close the project?')",
                text:"@lang('site.If you wish to close and press the Yes button')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4edd06",
                confirmButtonText: "Yes",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (Boolean(isConfirm)) {
                    var formData = new FormData();
                    var _val = "{{csrf_token()}}";
                    formData.append('_token', _val);
                    formData.append('id', id);

                    $.ajax({
                        url: "{{url('/project-detail/close')}}",
                        type: 'POST',
                        data: formData,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        success: function (result) {
                            if (Boolean(result)) {
                                swal("Notice","@lang('site.Project is closed.')", "success");
                                location.reload();
                            } else {
                                swal("Notice","@lang('site.Wrong in closed project.')", "error");
                            }
                        }
                    });
                }
            });
        }
    </script>
    {{-- public search --}}
    <script src="{{ asset('/js/search.js') }}"></script>
    <script>
        var csrf_token = "{{csrf_token()}}";
        var url_profile = "{{ url('/profile/') }}/";
        var url_project = "{{ url('/project-detail/') }}/";
        var img_default = "{{ asset('/images/50x50.jpg') }}";
        var public_address = "{{ asset("/") }}";
        var message_tr = '@lang("user_profile.Nothing to display")';
    </script>
@endsection
