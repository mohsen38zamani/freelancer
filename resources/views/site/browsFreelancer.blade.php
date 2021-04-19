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
    <link href="{{ asset('/assets/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/jquery-multi-select/multi-select.css') }}" rel="stylesheet">
    <!-- ION Slider -->
    <link href="{{ asset('/assets/ion-rangeslider/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/ion-rangeslider/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">

@endsection

@section('content')
    @php
        $page = "site";
        $checkEdit = \Request::segment(2);
        $search_text = '';
        if(isset($_REQUEST['p']))
            $search_text = $_REQUEST['p'];
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
                            <a href="#" id="dLabel1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="text-inverse-me"><p class="text-inverse-me"><span class="fa fa-search pr-2"></span>@lang($page.'.Browse') </p></a>
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
                    <li><a href="{{url('/all-project')}}"><p class="text-inverse-me"><span class="fa fa-desktop pr-2"></span>@lang($page.'.My Projects')</p></a></li>
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
    </div>
    <!--=========== END HEADER ================-->
    <!-- content page -->
    <div class="container">
        <section id="main-container-dashbord" >
            <div class="row">
                {{--     start content       --}}
                <div class="SaideBarAndContent col-md-12">
                    <div class="row">
                        <!-- saide bar left -->
                        <div class="col-md-3 col-sm-4">
                            <div class="sideBar-brows min-height600">
                                <!--project-->
                                <div class="display-flex type-sidebar-browse">
                                    <label class="fa fa-users m-t-2"></label>
                                    <strong class="m-l-10">@lang($page.'.Freelancer')</strong>
                                </div>
                                <!-- filter sidebar -->
                                <div class="filter-sidebar-brows">
                                    <!-- Skills -->
                                    <div class="skill-sidebar-borws">
                                        <h3>Skills</h3>
                                        @php
                                            $field_value = $block_field['information']['skill'];
                                            $field_key = "skill";
                                        @endphp
                                        <select
                                            name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                            id="selectSkill" data-placeholder="Select Skills"
                                            class="m-t-5 @if(!isset($field_value['select2'])) select2 @else form-control @endif @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                            @if(isset($field_value['multiple']) && $field_value['multiple']) multiple
                                            @endif
                                            @if($field_value['readonly']) readonly @endif
                                            @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                                        >
                                            @foreach($field_value['option'] as $option_value => $option_label)
                                                @if(isset($field_value['multiple']) && $field_value['multiple'])
                                                    <option value="{{ $option_value }}"
                                                            @if(in_array($option_value, $field_value['value'])) selected @endif>
                                                        @if($field_value['translate']) @lang($page.'.'.$option_label) @else {{ $option_label }} @endif
                                                    </option>
                                                @else
                                                    <option value="{{ $option_value }}"
                                                            @if($field_value['value'] == $option_value) selected @endif>
                                                        @if($field_value['translate']) @lang($page.'.'.$option_label) @else {{ $option_label }} @endif
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- type price -->
                                    <div class="language-sidebar-brows">
                                        <h3 class="jobState-sidebar-brows m-t-20">@lang($page.'.Hourly Price')</h3>
                                        <div class="">
                                            <input type="text" id="range_05">
                                        </div>
                                    </div>
                                    <!-- job state -->
                                    <div class="language-sidebar-brows">
                                        <h3>Country</h3>
                                        @php
                                            $field_value = $block_field['information']['Country'];
                                            $field_key = "Country";
                                        @endphp
                                        <select
                                            name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                            id="selectCountry" data-placeholder="Select Country"
                                            class="m-t-5 @if(!isset($field_value['select2'])) select2 @else form-control @endif @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                            @if(isset($field_value['multiple']) && $field_value['multiple']) multiple
                                            @endif
                                            @if($field_value['readonly']) readonly @endif
                                            @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                                        >
                                            <option value="0" selected> @lang($page.'.Select...')</option>
                                            @foreach($field_value['option'] as $option_value)
                                                @if(isset($field_value['multiple']) && $field_value['multiple'])
                                                    <option value="{{ $option_value->countryid }}">
                                                        @if($field_value['translate']) @lang($page.'.'.$option_value->name) @else {{ $option_value->name }} @endif
                                                    </option>
                                                @else
                                                    <option value="{{ $option_value->countryid }}">
                                                        @if($field_value['translate']) @lang($page.'.'.$option_value->name) @else {{ $option_value->name }} @endif
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- main content -->
                        <div class="col-md-9 col-sm-8">
                            <div class="list-skill-brows min-height600">
                                <!-- Search box -->
                                <div>
                                    <div class="row m-b-10 skill-brows">
                                        <div class="top-pagination-brows col-md-12">
                                            <div class="pageAndtext" style="display: flex;">

                                                <input id="textSearch" type="search" value="{{ $search_text }}" class="form-control" placeholder="@lang($page.'.Enter Name Freelancer...')" />

                                                <button id="btnSearch" class="btn btn-gray2 ml-0"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- List Project -->
                                <div id="div_list_freelancer">
                                {{--dynamically insert--}}
                                </div>
                            </div>
                            <!-- pagination -->
                            <div class="choose-broes">
                                <div class="">
                                    <div class="pagination-brows">
                                        <div class="container">
                                            <ul id="pagination-demo" class="pagination-lg pull-right"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--     end content       --}}
            </div>
        </section>
    </div>
    <!--END content -->

    {{--PopUp Page detail freelancer--}}
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-me">
            <div class="modal-content">
                <div class="modal-header dir-r">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title">@lang('site.project list')</h4>
                </div>
                <form action="{{ url("/browse-freelancer/chat_request") }}" method="post" id="frm_chat_equest" name="frm_chat_equest">
                    {{ csrf_field() }}
                    <input type="hidden" id="employerid" name="employerid" value="{{ $current_user->userid }}">
                    <input type="hidden" id="freelancerid" name="freelancerid" value="">
                    <div class="modal-body">
                    {{--  detail bid--}}
                    <div class="row">
                        <div class="col-md-12">
                            <label class="h4">@lang('site.projects')</label>
                            <div class="col-md-12 m-t-10">
                                <select class="select2" name="projects" id="projects">
                                    @if(isset($current_user) && ($current_user->projects))
                                        @foreach($current_user->projects as $key => $item)
                                        <option value="{{ $item->projectid }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('site.close')</button>
                    <button id="btn_chat_request" type="button" class="btn btn-success waves-effect waves-light">@lang('site.submit')</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->
@endsection

@section('script')
    <!-- Bootstrap default js -->
    <script>window.jQuery || document.write('<script src="{{asset('/js/minified/jquery-1.11.0.min.js')}}"><\/script>')</script>
    <!-- jQuery  -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('/assets/fastclick/fastclick.js') }}"></script>
    <script src="{{ asset('/assets/sweet-alert/sweet-alert.min.js') }}"></script>
    <script src="{{ asset('/assets/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/ion-rangeslider/ion.rangeSlider.min.js') }}"></script>
    {{--    pagination--}}
    <script src="{{ asset('/js/jquery.twbsPagination.js') }}"></script>

    <script type="text/javascript">
        skills = null;
        textSearch = "";
        priceHourly =[];
        priceHourly[0] = "2";
        priceHourly[1] = "250";
        country = null;
        countAllRecord = null;
        // Select2
        jQuery(".select2").select2({
            width: '100%',
            allowClear : true
        });

        $(document).ready(function () {
            $('body').on('click', '.award_btn', function () {
                var freelancerid = $(this).attr('data-key');
                $('#freelancerid').val(freelancerid);
            });

            $('body').on('click', '#btn_chat_request', function () {
                $.ajax({
                    type: "POST",
                    url: '{{ url("/browse-freelancer/chat_request") }}',
                    data: $('#frm_chat_equest').serialize(),
                    success: function (result) {
                        if (result) {
                            swal("Notice", "Submit your request.", "success");
                        } else {
                            swal("Notice", "Reject request!", "error");
                        }
                    }
                });
            });

            $('.py-4').removeClass('py-4');

            $("#range_05").ionRangeSlider({
                type: "double",
                grid: false,
                min: "2",
                max: "250",
                from: "2",
                to: "250",
                step: 1,
                onChange: function () {
                    var slider = $("#range_05").data("ionRangeSlider");
                    // Get values
                    priceHourly[0] = slider.result.from;
                    priceHourly[1] = slider.result.to;
                },
                onFinish: function (data) {
                    load_list_freelancer(priceHourly,skills,country,textSearch);
                }
            });

            $('#selectSkill').change(function () {
                //----- set result skill.
                skills = $("#selectSkill").val();
                load_list_freelancer(priceHourly,skills,country,textSearch);
            });

            $('#selectCountry').change(function () {
                //----- set result skill.
                if($("#selectCountry").val() != 0){
                    country = $("#selectCountry").val();
                }else{
                    country = null;
                }
                load_list_freelancer(priceHourly,skills,country,textSearch);
            });

            $('#btnSearch').click(function () {
                //----- set result skill.
                textSearch = $("#textSearch").val();
                load_list_freelancer(priceHourly,skills,country,textSearch);
            });
            $(document).keypress(function(e) {
                textSearch = $("#textSearch").val();
                if(e.which == 13 && textSearch) {
                    load_list_freelancer(priceHourly,skills,country,textSearch);
                }
            });

            //----------load list Project.
            load_list_freelancer(priceHourly,skills,country,textSearch);

            if("{{ $search_text }}") {
                $('#btnSearch').click();
            }
        });

        function load_list_freelancer(priceHourly,skills,country,textSearch) {
            var formData = new FormData();
            var _val = "{{csrf_token()}}";
            formData.append('_token', _val);
            formData.append('priceHourly', priceHourly);
            formData.append('skills', skills);
            formData.append('country', country);
            formData.append('textSearch', textSearch);

            $.ajax({
                url: "{{url('/browse-freelancer/list')}}",
                type: 'POST',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (result) {
                    if(result.length > 0){
                        countAllRecord = Math.ceil((result.length) / 5);
                        $('#pagination-demo').twbsPagination('destroy');
                        $('#pagination-demo').twbsPagination({
                            totalPages: countAllRecord,
                            // the current page that show on start
                            startPage: 1,

                            // maximum visible pages
                            visiblePages: 5,

                            initiateStartPageClick: true,

                            // template for pagination links
                            href: false,

                            // variable name in href template for page number
                            hrefVariable: 5,

                            // Text labels
                            first: 'First',
                            prev: 'Previous',
                            next: 'Next',
                            last: 'Last',

                            // carousel-style pagination
                            loop: false,

                            // callback function
                            onPageClick: function (event, page) {
                                $('.page-active').removeClass('page-active');
                                $('#page'+page).addClass('page-active');
                            },

                            // pagination Classes
                            paginationClass: 'pagination',
                            nextClass: 'next',
                            prevClass: 'prev',
                            lastClass: 'last',
                            firstClass: 'first',
                            pageClass: 'page',
                            activeClass: 'active',
                            disabledClass: 'disabled'

                        });
                        $('#div_list_freelancer').empty();
                        countpage = 0;
                        pagenumber = 1;
                        flag_create = false;
                        $('#div_list_freelancer').append('<div id="page'+pagenumber+'" class="page"></div>');
                        $.each(result, function (key, value) {
                            tag = "";
                            $.each(value["freelancerinfo"]["skill_freelancer"], function (key, val) {
                                if(value["freelancerinfo"]["skill_freelancer"].length > key+1)
                                {
                                    tag = tag + val["skill"]["name"]+",";
                                }
                                else{
                                    tag = tag + val["skill"]["name"];
                                }
                            });

                            wageLabel = "";
                            if(value["hourly_rate_value"]){
                                wageLabel = value["hourly_rate_value"];
                            }
                            perHour = "per hour";
                            description="-";
                            if(value["description"] !== null){
                                description = value["description"]
                            }

                            url = "{{url('/profile/')."/"}}"+value["username"];
                            img_url="{{asset('images/50x50.jpg')}}";
                            if(value["attachment"] !== null)
                            {
                                img_url = "{{asset('/')}}"+value["attachment"]["path"];
                            }
                            $('#page'+pagenumber).append('<div class="display-block-resp border-brows">\n' +
                                '                                            <div class="col-md-9 col-sm-12">\n' +
                                '                                                <div class="col-md-12">\n'+
                                '                                                    <div class="col-md-2">\n'+
                                '                                                       <a href="{{ url('/profile/') }}/'+value["username"]+'"><img class="resp-img-avatar" src="'+img_url+'"/></a>\n'+
                                '                                                    </div>\n'+
                                '                                                    <div class="col-md-10">\n'+
                                '                                                       <div class="col-md-12 p-l-20">\n' +
                                '                                                           <a href="{{ url('/profile/') }}/'+value["username"]+'"><p class="h4 color-title m-all-0 text-inverse">'+value["name"]+" "+value["family"]+'</p></a>\n' +
                                '                                                       </div>\n' +
                                '                                                       <div class="col-md-12 p-l-20">\n' +
                                '                                                           <span class="text-describtion m-t-10">'+description+'</span>\n' +
                                '                                                       </div>\n' +
                                '                                                    </div>\n'+
                                '                                                </div>\n'+
                                '                                                <div class="col-md-12 m-t-20">\n' +
                                '                                                    <div class="col-md-8 display-flex line-height1">\n' +
                                '                                                        <label class="fa fa-calendar-o m-r-5"></label>\n' +
                                '                                                        <div class="dis-flex">\n' +
                                '                                                            <strong>Member Since:'+value["created_at"]+'</strong>\n' +
                                '                                                        </div>\n' +
                                '                                                    </div>\n' +
                                '                                                    <div class="col-md-4 display-flex line-height1">\n' +
                                '                                                        <label class="fa fa-map-marker m-r-5"></label>\n' +
                                '                                                        <strong>'+value["country"]["name"]+" "+value["country"]["timezone"]+'</strong>\n' +
                                '                                                    </div>\n' +
                                '                                                </div>\n' +
                                '                                                <div class="col-md-12 mt-1">\n' +
                                '                                                    <div class="col-md-12 line-height1 mt-2">\n' +
                                '                                                        <label class="fa fa-tag m-r-5"></label>\n' +
                                '                                                        <strong>'+tag+'</strong>\n' +
                                '                                                    </div>\n' +
                                '                                                </div>\n' +
                                '                                            </div>\n' +
                                '                                            <div class="col-md-3 col-sm-12">\n' +
                                '                                                <p class=" font-weight-bold h4">$'+wageLabel+' - '+ perHour +'</p>\n' +
                                '                                                <button class="award_btn mt-2 min-height35 btn btn-success w-100 font-weight-bold" data-key="'+value['userid']+'" data-toggle="modal" data-target="#con-close-modal"><label class="fa fa-user-plus"></label> Hire Me</button>\n' +
                                '                                            </div>\n' +
                                '                                        </div>');
                            countpage = countpage + 1;
                            if(countpage > 4)
                            {
                                flag_create = true;
                                pagenumber = pagenumber + 1;
                                countpage = 0;
                                $('#div_list_freelancer').append('<div id="page'+pagenumber+'" class="page"></div>');
                            }
                        });
                        $('#page1').addClass('page-active');
                    }
                    else{
                        countAllRecord = 1;
                        swal("Notice","@lang('site.No results found!')", "warning");
                    }
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
