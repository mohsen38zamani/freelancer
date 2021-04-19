@extends('layouts.app')

{{--section header--}}
@section('header')

    {{-- css include--}}
    <link href="{{ asset('/assets/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/jquery-multi-select/multi-select.css') }}" rel="stylesheet">

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
        $page = \Request::segment(1);
        $page_lang = "site";
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
                            <a href="#" id="dLabel1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="text-inverse-me"><p class="text-inverse-me"><span class="fa fa-search pr-2"></span> @lang($page_lang.'.Browse')</p></a>
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
                    <li><a href="{{url('/all-project')}}"><p class="text-inverse-me"><span class="fa fa-desktop pr-2"></span> @lang($page_lang.'.My Projects')</p></a></li>
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
                                                <h4>@lang($page_lang.'.Finances')</h4>
                                                <a href="{{url('/profile/'.$current_user->username.'/edit?Payment')}}">@lang($page_lang.'.Manage')</a>
                                            </div>
                                            <ul>
                                                <li>@lang($page_lang.'.Balances')</li>
                                                <li class="bance">$0.00 USD</li>
                                                {{--                                                <li><a href="">Deposit Funds</a></li>--}}
                                                {{--                                                <li><a href="">Withdraw Funds</a></li>--}}
                                                <li><a href="#">@lang($page_lang.'.Transaction History')</a></li>
                                                {{--                                                <li><a href="">Financial Dashboard</a></li>--}}
                                            </ul>
                                        </div>
                                        <!--  -->
                                        <div class="account-DD">
                                            <div class="title-account-DD">
                                                <h4>@lang($page_lang.'.Account')</h4>
                                                <a href="{{url('/profile/'.$current_user->username.'/edit')}}">@lang($page_lang.'.Manage')</a>
                                            </div>
                                            <ul>
                                                <li><a href="{{url('/profile/'.$current_user->username)}}">@lang($page_lang.'.View Profile')</a></li>
                                                {{--                                        <li><a href="">Manage Membership</a></li>--}}
                                                <li><a href="{{url('/profile/'.$current_user->username.'/edit')}}">@lang($page_lang.'.User Settings')</a></li>
                                                {{--<li><a href="">Discover Insights</a></li>--}}
                                                <li><a href="{{url('/faq/help')}}">@lang($page_lang.'.Get Support')</a></li>
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
                        <li class="project-li"><a href="{{url('/postProject')}}" class="notHover"><button type="button" class="min-height35 btn post-project-btn">@lang($page_lang.'.Post a Project')</button></a></li>
                    @else
                        <ul class="login-topbar">
                            <li class="profile-li">
                                <a href="{{url('/login')}}"><strong>@lang($page_lang.'.sign in')</strong></a> &nbsp;&nbsp;
                                <a href="{{url('/register')}}"><strong>@lang($page_lang.'.sign up')</strong></a>
                            </li>
                            <li class="project-li"><a href="{{url('/postProject')}}" class="notHover"><button type="button" class="min-height35 btn post-project-btn">@lang($page_lang.'.Post a Project')</button></a></li>
                        </ul>
                    @endif
                </ul>
            </div>
        </div>
        <!-- second menu -->
        <div class="SecondHeader-dashborad">
            <div class="topnav">
                <div class="container">
                    <a href="{{url('/project-request/')}}@if(isset($project['projectid'])){{'/'.$project['projectid']}} @endif" class=" @if($page != 'project-proposal')active @endif ">@lang($page_lang.'.Details')</a>
                    <a href="{{url('/project-proposal/')}}@if(isset($project['projectid'])){{'/'.$project['projectid']}} @endif" class=" @if($page == 'project-proposal')active @endif ">@lang($page_lang.'.Proposal')</a>
                </div>
            </div>
        </div>
    </div>
    <!--=========== END HEADER ================-->

    <!-- content page -->
    <div class="container">
        <section id="main-container-dashbord">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="mt-20">
                        <!-- project detail -->
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
                <!-- information siderbar -->
                <div class="col-md-4 col-sm-4">
                    <div class="mb-10">
                        <!-- emplayer -->
                        <div class="card p-10-30">
                            <h1 class="title-profile">@lang($page_lang.'.About the employer')</h1>
                            <hr>
                            <div class="list-emplayer">
                                <ul>
                                    <li><i class="fa fa-map-marker font-initial"> {{$userProject['country']['name'].' '.$userProject['country']['timezone']}}</i></li>
                                    <li><i class="fa fa-clock-o font-initial"> Member since {{ date('jS \of F Y', strtotime($userProject->created_at)) }}</i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="Verifi">
                            <h2 class="title-profile">@lang($page_lang.'.Employer Verification')</h2>
                            <ul class="list-group">
                                <li class="list-group-item"><i class="fa fa-facebook @if($userProject->user_verification_items->facebook)Icon-image-verified @endif"></i>@lang($page_lang.'.Facebook Connected')  @if(!$userProject->user_verification_items->facebook)<span>@if($authenticatied)<a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-credit-card @if($userProject->user_verification_items->payment)Icon-image-verified @endif"></i> @lang($page_lang.'.Payment Verified') @if(!$userProject->user_verification_items->payment)<span>@if($authenticatied)<a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-phone @if($userProject->user_verification_items->phone)Icon-image-verified @endif"></i> @lang($page_lang.'.Phone Verified') @if(!$userProject->user_verification_items->phone)<span>@if($authenticatied)<a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-user @if($userProject->user_verification_items->identity)Icon-image-verified @endif"></i> @lang($page_lang.'.Identity Verified') @if(!$userProject->user_verification_items->identity)<span>@if($authenticatied)<a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-envelope @if($userProject->user_verification_items->email)Icon-image-verified @endif"></i> @lang($page_lang.'.Email Verified') @if(!$userProject->user_verification_items->email)<span>@if($authenticatied) <a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li>
                            </ul>
                        </div>
                    </div>
                </div>
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
    <script src="{{ asset('/assets/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/sweet-alert/sweet-alert.min.js') }}"></script>
    {{--    pagination--}}
    <script src="{{ asset('/js/jquery.twbsPagination.js') }}"></script>

    <script type="text/javascript">
        var typePayProject= 'project';
        var assistant_settingid;
        var array_skillFreelancer= [];
        var typeProject;
        var arrayMilestonDiv=[];
        var counter = 0;
        advanceOption_selected = new Array();
        // $('#box1').addClass('Card-shadow-select');

        // Select2
        jQuery(".select2").select2({
            width: '100%',
            allowClear: true
        });

        var resizefunc = [];

        $(document).ready(function () {
            $('.py-4').removeClass('py-4');
            load_list_freelancer();
            $(document).on('click','#btn_retract',function () {
                swal({
                    title:"@lang($page_lang.'.Are you sure you want to delete the bid?')" ,
                    text: "@lang($page_lang.'.If you wish to delete and press the Yes button')",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#4edd06",
                    confirmButtonText: "Yes",
                    closeOnConfirm: true
                }, function (isConfirm) {
                    if (Boolean(isConfirm)) {
                        bid_id = $('#btn_retract').attr('data-key');
                        var formData = new FormData();
                        var _val = "{{csrf_token()}}";
                        formData.append('_token', _val);
                        formData.append('bid_id', bid_id);
                        formData.append('roll', 3);

                        $.ajax({
                            url: "{{url('/request-freelancer/delete')}}",
                            type: 'POST',
                            data: formData,
                            processData: false,  // tell jQuery not to process the data
                            contentType: false,  // tell jQuery not to set contentType
                            success: function (result) {
                                if (result != 0) {
                                    swal("Notice","@lang($page_lang.'.Bid is delete.')", "success");
                                    {{--window.location.href = "{{url('/browse-project')}}";--}}
                                } else {
                                    swal("Notice","@lang($page_lang.'.Wrong in delete bid.')", "error");
                                }
                            }
                        });
                    }
                });
            })
        });

        function load_list_freelancer() {
            var formData = new FormData();
            var _val = "{{csrf_token()}}";
            formData.append('_token', _val);
            formData.append('projectid',"{{$project['projectid']}}");

            $.ajax({
                url: "{{url('/request-freelancer/list')}}",
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
                            wageLabel = "";
                            if(value["bid"]){
                                wageLabel = value["bid"];
                            }
                            if(value['type'] == "project"){
                                perHour = "in"+value['period_time']+'day';

                            }
                            else{
                                perHour = " /per hour";
                            }
                            description="-";
                            if(value["describe"] !== null){
                                description = value["describe"]
                            }

                            editUrl = "{{url('/project-request/'.$project['projectid'])}}";
                            img_url="{{asset('images/50x50.jpg')}}";
                            if(value['user_profile']["attachment"] !== null)
                            {
                                img_url = "{{asset('/')}}"+value['user_profile']["attachment"]["path"];
                            }

                            $('#page'+pagenumber).append('<div id="div_list_'+key+'" class="display-block-resp border-brows bg-white">\n' +
                                '                                            <div class="col-md-9 col-sm-12">\n' +
                                '                                                <div class="col-md-12">\n'+
                                '                                                    <div class="col-md-2">\n'+
                                '                                                       <img class="resp-img-avatar" src="'+img_url+'"/>\n'+
                                '                                                    </div>\n'+
                                '                                                    <div class="col-md-10">\n'+
                                '                                                       <div class="col-md-12 p-l-20">\n' +
                                '                                                           <p class="h4 color-title m-all-0 text-inverse">'+value['user_profile']["name"]+" "+value['user_profile']["family"]+'</p>\n' +
                                '                                                       </div>\n' +
                                '                                                       <div class="col-md-12 m-t-10 p-l-20">\n' +
                                '                                                           <label class="fa fa-map-marker m-r-5"></label>\n' +
                                '                                                           <strong>'+value['user_profile']["country"]["name"]+" "+value['user_profile']["country"]["timezone"]+'</strong>\n' +
                                '                                                       </div>\n' +
                                '                                                    </div>\n'+
                                '                                                </div>\n'+
                                '                                                <div class="col-md-12 p-l-20">\n' +
                                '                                                    <span class="text-describtion m-t-10">'+description+'</span>\n' +
                                '                                                </div>\n' +
                                '                                            </div>\n' +
                                '                                            <div class="col-md-3 col-sm-12">\n' +
                                '                                                <p class=" font-weight-bold h4">$'+wageLabel+' '+ perHour +'</p>\n' +
                                '                                                <div id="div_btn_edit" class="div_btn_'+key+'">\n'+
                                '                                                </div>\n'+
                                '                                            </div>\n' +
                                '                                        </div>');
                            if("{{\Illuminate\Support\Facades\Auth::id()}}" == value['user_profile']['userid']){
                                $('.div_btn_'+key).append('<a class="mt-2 btn btn-success w-100 font-weight-bold min-h-0" href="'+editUrl+'"><label class="fa fa-edit"></label> @lang($page_lang.'.Edit')</a>\n' +
                                    '<button id="btn_retract" class="mt-2 btn btn-success w-100 font-weight-bold min-h-0" data-key="'+value['bids_projectid']+'"><label class="fa fa-remove"></label>@lang($page_lang.'.Retract') </button>');
                            }

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
                        swal("Notice","@lang($page_lang.'.No results found!')", "warning");
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
