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
                    <li><a href="{{url('/all-project')}}"><p class="text-inverse-me"><span class="fa fa-desktop pr-2"></span>@lang($page.'.My Projects') </p></a></li>
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

        <!-- second menu -->
        <div class="SecondHeader-dashborad">
            <div class="topnav">
                <div class="container">
                    <a href="{{url('/project-detail/')}}@if(isset($project['projectid'])){{'/'.$project['projectid']}} @endif" class=" @if($checkEdit != 'proposal')active @endif ">@lang($page.'.Details')</a>
                    <a href="{{url('/project-detail/proposal/')}}@if(isset($project['projectid'])){{'/'.$project['projectid']}} @endif" class=" @if($checkEdit == 'proposal')active @endif ">@lang($page.'.Proposal')</a>
                    <a href="{{url('/project-detail/file/')}}@if(isset($project['projectid'])){{'/'.$project['projectid']}} @endif" class=" @if($checkEdit == 'file')active @endif ">@lang($page.'.File')</a>
                    <a href="{{url('/project-detail/edit/')}}@if(isset($project['projectid'])){{'/'.$project['projectid']}} @endif" class=" @if($checkEdit == 'edit')active @endif ">@lang($page.'.Edit Project')</a>
                    <a href="#" onclick="delete_project()" id="del_tag">@lang($page.'.Delete Project')</a>
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
                            <h1 class="title-profile">@lang($page.'.About the employer')</h1>
                            <hr>
                            <div class="list-emplayer">
                                <ul>
                                    <li><i class="fa fa-map-marker font-initial"> {{$current_user['country']['name'].' '.$current_user['country']['timezone']}}</i></li>
                                    <li><i class="fa fa-desktop font-initial"> 0 projects completed</i></li>
                                    <li><i class="fa fa-clock-o font-initial"> Member since {{ date('jS \of F Y', strtotime($current_user->created_at)) }}</i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="Verifi">
                            <h2 class="title-profile">Employer Verification</h2>
                            <ul class="list-group">
                                <li class="list-group-item"><i class="fa fa-facebook @if($current_page_user->user_verification_items->facebook)Icon-image-verified @endif"></i> @lang($page.'.Facebook Connected') @if(!$current_page_user->user_verification_items->facebook)<span>@if($authenticatied)<a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">@lang($page.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-credit-card @if($current_page_user->user_verification_items->payment)Icon-image-verified @endif"></i> @lang($page.'.Payment Verified') @if(!$current_page_user->user_verification_items->payment)<span>@if($authenticatied)<a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">@lang($page.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-phone @if($current_page_user->user_verification_items->phone)Icon-image-verified @endif"></i> @lang($page.'.Phone Verified') @if(!$current_page_user->user_verification_items->phone)<span>@if($authenticatied)<a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">@lang($page.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-user @if($current_page_user->user_verification_items->identity)Icon-image-verified @endif"></i> @lang($page.'.Identity Verified') @if(!$current_page_user->user_verification_items->identity)<span>@if($authenticatied)<a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">@lang($page.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-envelope @if($current_page_user->user_verification_items->email)Icon-image-verified @endif"></i> @lang($page.'.Email Verified') @if(!$current_page_user->user_verification_items->email)<span>@if($authenticatied) <a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">@lang($page.'.verify')</a> @endif</span> @endif</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--END content -->

    {{--PopUp Page detail freelancer--}}
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-me">
            <div class="modal-content">
                <div class="modal-header dir-r">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">@lang($page.'.Detail Bid Freelancer')</h4>
                </div>
                <div class="modal-body">
                    {{--  about freelancer--}}
                    <div class="row border-me_bottom p-b-20">
                        <div class="col-md-12">
                            <div id="div_img_profile" class="col-md-2">
                            </div>
                            <div id="detail_freelancer" class="col-md-10">
                            </div>
                        </div>
                        <div class="col-md-12 m-t-20">
                            <strong class="h4 display-block">@lang($page.'.About Me')</strong>
                            <span id="span_about_me" class="display-block justify-content-md-between"></span>
                        </div>
                        <div class="col-md-12 m-t-20">
                            <strong class="h4 m-b-20 display-block">@lang($page.'.Skills')</strong>
                            <ul id="ul_skill_freelancer" class="border-me_skill">
                            </ul>
                        </div>
                    </div>
                    {{--  detail bid--}}
                    <div class="row m-t-20">
                        <div class="col-md-12">
                            <label class="h4">@lang($page.'.Bid')</label>
                            <div class="col-md-12 m-t-10">
                                <strong id="strong_bid" class="h3 text-dark_ali font-weight-bold"></strong>
                            </div>
                            <div class="col-md-12 m-t-20">
                                <strong class="h4 display-block">@lang($page.'.Describe')</strong>
                                <span id="span_describe_bid" class="display-block justify-content-md-between bg-muted p-all-10"></span>
                            </div>
                        </div>
                    </div>
                    <div id="div_milestone" class="row m-t-20">
                        <label class="h4">@lang($page.'.Mailstone')</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang($page.'.Close')</button>
                    <form action="{{ url("/payment") }}" method="post" id="frm-award" name="frm-award">
                        {{ csrf_field() }}
                        <input type="hidden" name="bid_id" id="bid_id">
                        <input type="hidden" name="milestonid" id="milestonid">
                        <input type="hidden" name="currency" id="currency">
                        <button id="btn_payment_award" type="button" class="btn btn-success waves-effect waves-light">@lang($page.'.Award')</button>
                    </form>
                </div>
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
    <script src="{{ asset('/assets/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/sweet-alert/sweet-alert.min.js') }}"></script>
    {{--    pagination--}}
    <script src="{{ asset('/js/jquery.twbsPagination.js') }}"></script>

    <!-- Modal-Effect -->
    <script src="{{ asset('/assets/modal-effect/js/classie.js') }}"></script>
    <script src="{{ asset('/assets/modal-effect/js/modalEffects.js') }}"></script>


    <script type="text/javascript">
        var array_key_checkbox = new Array();
        var array_milestone = new Array();
        var array_bid_select = new Array();
        var bid_id = null;
        var currency = null;
        var symbol = null;


        // Select2
        jQuery(".select2").select2({
            width: '100%',
            allowClear: true
        });

        var resizefunc = [];

        $(document).ready(function () {
            $('.py-4').removeClass('py-4');
            load_list_freelancer();

            //----load data in popup page detail freelancer.
            $(document).on('click','.award_btn',function () {
                array_key_checkbox = new Array();
                array_milestone = new Array();
                array_bid_select = new Array();
                bid_id = null;
                currency = null;
                symbol = null;

                bid_id = $(this).attr('data-key');
                var formData = new FormData();
                var _val = "{{csrf_token()}}";
                formData.append('_token', _val);
                formData.append('bid_id', bid_id);
                $.ajax({
                    url: "{{url('/detail_bid/freelancer')}}",
                    type: 'POST',
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success: function (result) {
                        if (result == 0) {
                            swal("Notice","@lang('site.No results found!')", "error");
                        } else {
                            bid_id = result['bids_projectid'];
                            //--------- set image profile
                            img_url="{{asset('images/50x50.jpg')}}";
                            if(result['user_profile']["attachment"] !== null)
                            {
                                img_url = "{{asset('/')}}"+result['user_profile']["attachment"]["path"];
                            }
                            $('#div_img_profile').empty();
                            $('#div_img_profile').append('<img class="resp-img-avatar" src="'+img_url+'"/>');

                            //--------- set name,family,location,member since.
                            $('#detail_freelancer').empty();
                            $('#detail_freelancer').append('<label for="field-1" class="control-label display-block m-0">'+result['user_profile']['name']+' '+ result['user_profile']['family']+'</label>\n' +
                                '          <label for="field-1" class="control-label display-block m-0 text-secondary"> Member sinc : '+result['user_profile']['created_at']+'</label>\n' +
                                '          <label for="field-1" class="control-label display-block m-0 text-secondary"><label class="fa fa-map-marker"></label> '+result['user_profile']["country"]["name"]+" "+result['user_profile']["country"]["timezone"]+'</label>');

                            //--------- set description freelancer.
                            $('#span_about_me').text('');
                            $('#span_about_me').text(result['user_profile']['description']);

                            //-------- set skills.
                            $('#ul_skill_freelancer').empty();
                            $.each(result['user_profile']['freelancerinfo']['skill_freelancer'],function(key,value){
                                $('#ul_skill_freelancer').append('<li class="m-t-3 m-r-1">'+value['skill']['name']+'</li>');
                            });

                            //------- bid.
                            currency = result['project'][0]['wage']['currency']['name'];
                            symbol = result['project'][0]['wage']['currency']['symbol'];
                            if(result['type'] == "project"){
                                label_price = symbol+result['bid']+" in "+ result['period_time'] +' day';
                                $('#strong_bid').text('');
                                $('#strong_bid').text(label_price);
                                $('#span_describe_bid').text('');
                                $('#span_describe_bid').html(result['describe']);
                                //------ set milestone.
                                $('#div_milestone').empty();
                                $('#div_milestone').append('<div id="div_sub_milestone" class="col-md-12">\n' +
                                    '                           <strong class="col-md-12 h4 display-block">@lang('site.Milestone')</strong>\n' +
                                    '                        </div>');
                                $.each(result['mile_stone'],function (key,value) {

                                    array_key_checkbox[value['mile_stoneid']] = '';
                                    $('#div_sub_milestone').append('<div class="col-md-12 m-t-10">\n' +
                                        '                                    <div class="form-group">\n' +
                                        '                                    <div class="col-m-12">\n' +
                                        '                                        <div class="pretty p-icon p-curve p-tada m-t-20" >\n' +
                                        '                                            <input type="checkbox" id="'+value['mile_stoneid']+'" data-value="'+value['price']+'" class="chk_mile_stone"/>\n' +
                                        '                                            <div class="state p-success">\n' +
                                        '                                                <i class="icon fa fa-check"></i>\n' +
                                        '                                                <label>'+value['title']+'</label>\n' +
                                        '                                            </div>\n' +
                                        '                                        </div>\n' +
                                        '                                    </div>\n' +
                                        '                                    <input type="text" class="form-control bg-white" disabled value="'+value['price']+'">\n' +
                                        '                                </div>\n' +
                                        '                            </div>');
                                });
                            }
                            else{
                                label_price = symbol+result['bid']+" Per/Hour ";
                                array_key_checkbox[result['mile_stone'][0]['mile_stoneid']] = result['mile_stone'][0]['price'];
                                $('#strong_bid').text('');
                                $('#strong_bid').text(label_price);
                                $('#span_describe_bid').text('');
                                $('#span_describe_bid').html(result['describe']);
                                //------ set milestone.
                                $('#div_milestone').empty();
                                $('#div_milestone').append('<div class="col-md-12">\n' +
                                    '                            <div class="col-md-6">\n' +
                                    '                                <div class="form-group">\n' +
                                    '                                    <label for="field-4" class="control-label">@lang('site.Hourly Rate')</label>\n' +
                                    '                                    <input id="hourly_price" type="text" class="form-control bg-white" disabled value="' + result['bid']+'">\n' +
                                    '                                </div>\n' +
                                    '                            </div>\n' +
                                    '                            <div class="col-md-6">\n' +
                                    '                                <div class="form-group">\n' +
                                    '                                    <label for="field-4" class="control-label">Weekly (hrs/week)</label>\n' +
                                    '                                    <input id="weekly_time" type="text" class="form-control bg-white" disabled value="'+result['period_time']+'">\n' +
                                    '                                </div>\n' +
                                    '                            </div>\n' +
                                    '                            <div class="col-md-8">\n' +
                                    '                                <div class="form-group">\n' +
                                    '                                    <label for="field-4" class="control-label">Weekly Bill</label>\n' +
                                    '                                    <input id="sum_price" type="text" class="form-control bg-white" disabled value="'+result['mile_stone'][0]['price']+'">\n' +
                                    '                                </div>\n' +
                                    '                            </div>\n' +
                                    '                        </div>');

                                //------ set milestone.
                                $('#div_milestone').append('<div id="div_sub_milestone" class="col-md-12">\n' +
                                    '                           <strong class="col-md-12 h4 display-block">@lang('site.Milestone')</strong>\n' +
                                    '                        </div>');

                                $.each(result['mile_stone'],function (key,value) {
                                    array_key_checkbox[value['mile_stoneid']] = '';
                                    $('#div_sub_milestone').append('<div class="col-md-12 m-t-10">\n' +
                                        '                                    <div class="form-group">\n' +
                                        '                                    <div class="col-m-12">\n' +
                                        '                                        <div class="pretty p-icon p-curve p-tada m-t-20" >\n' +
                                        '                                            <input type="checkbox" id="'+value['mile_stoneid']+'" data-value="'+value['price']+'" class="chk_mile_stone"/>\n' +
                                        '                                            <div class="state p-success">\n' +
                                        '                                                <i class="icon fa fa-check"></i>\n' +
                                        '                                                <label>'+value['title']+'</label>\n' +
                                        '                                            </div>\n' +
                                        '                                        </div>\n' +
                                        '                                    </div>\n' +
                                        '                                    <input type="text" class="form-control bg-white" disabled value="'+value['price']+'">\n' +
                                        '                                </div>\n' +
                                        '                            </div>');
                                });
                            }
                        }
                    }
                });
            });

            //----chk_mile_stone condition.
            $(document).on('change','.chk_mile_stone:checkbox',function () {
                key_value = $(this).attr('data-value');
                key = this.id;
                if(this.checked)
                {
                    array_key_checkbox[key] = key_value;
                    array_bid_select.push(key);
                }else{
                    array_key_checkbox[key] = '';
                    if(array_bid_select.includes(key))
                    {
                        array_bid_select.splice( array_bid_select.indexOf(key), 1 );
                    }
                }
                //----- remove null value.
                array_milestone = array_key_checkbox.filter(function (el) {
                    return el != null;
                });
            });

            //----- retract bid freelancer.
            $(document).on('click','.retract_btn',function () {
                bid_id = $(this).attr('data-key');
                key_val = $(this).attr('data-div');
                swal({
                    title:"@lang('site.Are you sure you want to Reject the bid?')",
                    text:"@lang('site.If you wish to Reject and press the Yes button')",
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
                        formData.append('bid_id', bid_id);
                        formData.append('roll', 2);
                        $.ajax({
                            url: "{{url('/request-freelancer/delete')}}",
                            type: 'POST',
                            data: formData,
                            processData: false,  // tell jQuery not to process the data
                            contentType: false,  // tell jQuery not to set contentType
                            success: function (result) {
                                if (result != 0) {
                                    swal("Notice","@lang('site.Bid is Reject.')", "success");
                                    // $(document).getElementById('#div_list_'+key_val).remove();
                                    document.getElementById('div_list_'+key_val).remove();
                                } else {
                                    swal("Notice","@lang('site.Wrong in Reject bid.')", "error");
                                }
                            }
                        });
                    }
                });
            });

            //------- btn award.
            $('#btn_payment_award').click(function () {
                //------check select queue milestone.
                counter = 0;
                flag = 0;
                sumPrice = 0;
                first_key = null;
                last_key = null;
                $.each(array_milestone,function (key,value) {
                    if(value != ""){
                        last_key = key;
                        sumPrice = sumPrice + parseFloat(value);
                    }
                    if(flag == 0){
                        first_key = key;
                        flag = 1;
                    }

                });
                if(first_key != last_key){
                    $.each(array_milestone,function (key,value) {
                        if(key <= last_key && value == ""){
                            counter = counter +1;
                            return false;
                        }
                    });
                }
                //-----condition top it's ok.
                if(counter == 0)
                {
                    if(sumPrice != 0){
                        swal({
                            title:"@lang('site.The total is ')" +symbol+sumPrice,
                            text:"@lang('site.are you willing to pay?')",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#4edd06",
                            confirmButtonText: "Yes",
                            closeOnConfirm: true
                        }, function (isConfirm) {
                            if (Boolean(isConfirm)) {
                                var formData = $("#frm-award");
                                $('#milestonid').val(array_bid_select);
                                $('#bid_id').val(bid_id);
                                $('#currency').val(currency);
                                formData.submit();
                                {{--$.ajax({--}}
                                {{--    url: "{{url('/request-freelancer/payment')}}",--}}
                                {{--    type: 'POST',--}}
                                {{--    data: formData,--}}
                                {{--    processData: false,  // tell jQuery not to process the data--}}
                                {{--    contentType: false,  // tell jQuery not to set contentType--}}
                                {{--    success: function (result) {--}}
                                {{--        if (result != 0) {--}}
                                {{--            swal("Notice", 'success payment', "success");--}}
                                {{--        } else {--}}
                                {{--            swal("Notice", 'Wrong in payment.', "error");--}}
                                {{--        }--}}
                                {{--    }--}}
                                {{--});--}}
                            }
                        });
                    }else{
                        //----please select milestone
                        swal("Notice","@lang('site.Please select milestone!')", "warning");
                    }
                }
                else{
                    if(array_bid_select.length <= 0){
                        swal("Notice","@lang('site.Please select milestone!')", "warning");
                    }
                    else{
                        swal("Notice","@lang('site.Please select the milestone in order,for payment!')", "warning");
                    }
                }
            });
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

                            img_url="{{asset('images/50x50.jpg')}}";
                            if(value['user_profile']["attachment"] !== null)
                            {
                                img_url = "{{asset('/')}}"+value['user_profile']["attachment"]["path"];
                            }
                            symbol_price = value['project'][0]['wage']['currency']['symbol'];
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
                                '                                                <p class=" font-weight-bold h4">'+symbol_price+wageLabel+' '+ perHour +'</p>\n' +
                                '                                                <div id="div_btn_edit" class="div_btn_'+key+'">\n'+
                                '                                                   <button class="award_btn mt-2 btn btn-primary w-100 font-weight-bold min-h-0 font-size-10" data-key="'+value['bids_projectid']+'" data-toggle="modal" data-target="#con-close-modal"><label class="fa fa-credit-card"></label>@lang('site.Detaile & Award')</button>\n' +
                                '                                                   <button class="retract_btn mt-2 btn btn-danger w-100 font-weight-bold min-h-0 font-size-10" data-key="'+value['bids_projectid']+'" data-div="'+key+'"><label class="fa fa-remove"></label>@lang('site.Reject')</button>\n' +
                                '                                                </div>\n'+
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
