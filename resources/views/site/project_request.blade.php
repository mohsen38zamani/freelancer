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
                        <div class="Recent-project-dashbord">
                            <div class="project-title display-flex">
                                <div class="col-md-9 p-all-20">
                                    <p class="h4 color-title m-all-0">@if(isset($project['name'])) {{$project['name']}} @endif</p>
                                </div>
                                <div class="col-md-3 p-all-20">
                                    <p>@if(isset($project['wage']['name'])) {{$project['wage']['currency']['symbol'].$project['wage']['minbudget'].' - '.$project['wage']['maxbudget'].'('.$project['wage']['currency']['name'].')'}} @endif</p>
                                </div>

                            </div>
                        @php
                            $field_value = $block_field['information']['skill'];
                            $field_key = "skill";
                        @endphp
                        <!-- content project detail -->

                            <div class="content-Recent-project-dashbord">
                                <div class="project-detail">
                                    <div class="row">

                                            <p>@lang($page_lang.'.Description'): @if(isset($project['description'])) {{$project['description']}} @endif</p>
                                    </div>
                                    <div class="row mt-5">
                                        <h4>@lang($page_lang.'.Skills Required') </h4>
                                        <select
                                            name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                            id="selectSkill" data-placeholder="@lang($page.'.What skills are required?')"
                                            class="m-t-5  mt-3 @if(!isset($field_value['select2'])) select2 @else form-control @endif @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
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
                                </div>
                            </div>


                        </div>

                        <!--//////////////// Start condition request ///////////////////-->
                        <div id="div_main_request" class="Recent-project-dashbord mb-10">
                            <div class="project-title display-flex">
                                <div class="col-md-12 p-all-20">
                                    <p class="h4 color-title m-all-0">@lang($page_lang.'.Complete your information')  </p>
                                </div>
                            </div>
                            <div class="content-Recent-project-dashbord">
                                <div id="div_Condition" >
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!--//////////////// END advance option ///////////////////-->
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
                                <li class="list-group-item"><i class="fa fa-facebook @if($userProject->user_verification_items->facebook)Icon-image-verified @endif"></i> @lang($page_lang.'.Facebook Connected') @if(!$userProject->user_verification_items->facebook)<span>@if($authenticatied)<a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-credit-card @if($userProject->user_verification_items->payment)Icon-image-verified @endif"></i>@lang($page_lang.'.Payment Verified')  @if(!$userProject->user_verification_items->payment)<span>@if($authenticatied)<a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-phone @if($userProject->user_verification_items->phone)Icon-image-verified @endif"></i> @lang($page_lang.'.Phone Verified') @if(!$userProject->user_verification_items->phone)<span>@if($authenticatied)<a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-user @if($userProject->user_verification_items->identity)Icon-image-verified @endif"></i> @lang($page_lang.'.Identity Verified') @if(!$userProject->user_verification_items->identity)<span>@if($authenticatied)<a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li>
                                <li class="list-group-item"><i class="fa fa-envelope @if($userProject->user_verification_items->email)Icon-image-verified @endif"></i>@lang($page_lang.'.Email Verified')  @if(!$userProject->user_verification_items->email)<span>@if($authenticatied) <a href="{{url('/profile/'.$userProject->username.'/edit?Trust')}}" class="btn-list">@lang($page_lang.'.verify')</a> @endif</span> @endif</li></ul>
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

            //----select skill in ---> $('#selectSkill');
            var array_id_skill = @json($project['skill_requirment']);
            var array_skill = Array();
            array_id_skill.forEach(function (val, index) {
                array_skill[index] = val['skillid'];
            });

            $('#selectSkill').val(array_skill);
            $('#selectSkill').trigger('change');
            $('#selectSkill').select2("enable", false)
            $('#selectSkill').attr("background-color", "#fff")


            exists_skill_project = "{{$exists_skill_project}}";
            //----- if not skill freelancer for project -> create div select skill.
            if (!exists_skill_project){
                $('#div_Condition').empty();
                $('#div_Condition').append('<p class="h5">@lang($page_lang.'.You must add at least one of these skills to bid on this project.') </p>\n' +
                    '                                        <div id="div_checkbox" class="div_checkbox">\n' +
                    '                                        </div>\n' +
                    '                                        <div class="btn-postProject">\n' +
                    '                                            <button id="btn_GoNextLavel" type="button" class="btn btn-outline-success border-success min-h-0">@lang($page_lang.'.Save Skills')</button>\n' +
                    '                                        </div>');

                arraySkillProject = [];
                arraySkillProject = @json($project['skill_requirment']);
                $.each(arraySkillProject, function (key, val) {
                    $('#div_checkbox').append('<div class="pretty p-icon p-curve p-tada m-t-20" >\n' +
                        '                <input type="checkbox" id="' + val["skillid"] + '" class="chk_Project"/>\n' +
                        '                <div class="state p-success">\n' +
                        '                <i class="icon fa fa-check"></i>\n' +
                        '                <label>' + val["skill"]["name"] + '</label>\n' +
                        '                </div>\n' +
                        '                </div>');

                });
            }
            //----- if exists skill freelancer for project -> check email verify.
            else{
                $('#div_Condition').empty();
                //----create div resend email.
                user_verification_items = "{{$current_user['user_verification_items']['email']}}";
                url = "/mail_verification/{{$current_user['username']}}";
                if(user_verification_items == '0'){
                    message_note = "@lang($page_lang.'.We have sent you an email to verify your email address,please check your inbox.if you have not recived the email,resend to verify.')";
                    $('#div_Condition').append('<p class="h5">'+message_note+'</p>\n' +
                        '                                        <div class="div_checkbox">\n' +
                        '                                            <a onclick="clickEmailResend()" href="'+url+'" class="btn btn-primary min-h-0">@lang($page_lang.".Resend")</a>\n' +
                        '                                            <button onclick="btn_checkEmail();" type="button" class="btn btn-outline-success border-success min-h-0 pull-right">@lang($page_lang.".Check")</button>\n' +
                        '                                        </div>');
                }
                //-----if email is verify -> continue to div information profile.
                else{
                    //------check fill field user profile.
                    check_userProfile();
                }
            }

            //----- condition checkbox.
            $(".chk_Project:checkbox").change(function () {
                eventid = this.id; // get id item click.
                if(this.checked){
                    // check -> if not in array insert in array.
                    if( $.inArray( eventid, array_skillFreelancer ) < 0 ){
                        array_skillFreelancer.push(eventid);
                    }
                    else{
                        array_skillFreelancer.splice( $.inArray(eventid, array_skillFreelancer), 1 );
                    }
                }else{
                    //remove in array
                    if( $.inArray( eventid, array_skillFreelancer ) > -1 ){
                        array_skillFreelancer.splice( $.inArray(eventid, array_skillFreelancer), 1 );
                    }
                }
            });

            $('#btn_GoNextLavel').click(function () {
                if(!exists_skill_project){
                    if(array_skillFreelancer.length > 0)
                    {
                        var formData = new FormData();
                        var _val = "{{csrf_token()}}";
                        formData.append('_token', _val);
                        formData.append('array_skillFreelancer', array_skillFreelancer);

                        $.ajax({
                            url: "{{url('/saveSkillFreelancer')}}",
                            type: 'POST',
                            data: formData,
                            processData: false,  // tell jQuery not to process the data
                            contentType: false,  // tell jQuery not to set contentType
                            success: function (result) {
                                if (Boolean(result)) {
                                    swal("Notice","@lang($page_lang.'.skills is save.')", "success");
                                    $('#div_Condition').empty();
                                    //----create div resend email.
                                    user_verification_items = "{{$current_user['user_verification_items']['email']}}";
                                    url_email = "/mail_verification/{{$current_user['username']}}";
                                    if(user_verification_items == '0'){
                                        $('#div_Condition').append('<p class="h5">@lang($page_lang.".We have sent you an email to verify your email address,please check your inbox.if you have not recived the email,resend to verify.")</p>\n' +
                                            '                                        <div class="div_checkbox">\n' +
                                            '                                            <a onclick="clickEmailResend()" href="'+url_email+'" class="btn btn-primary min-h-0">@lang($page_lang.".Resend")</a>\n' +
                                            '                                            <button onclick="btn_checkEmail();" type="button" class="btn btn-outline-success border-success min-h-0 pull-right">@lang($page_lang.".Check")</button>\n' +
                                            '                                        </div>');
                                    }
                                    //-----if email is verify -> continue to div information profile.
                                    else{
                                        //------check fill field user profile.
                                        check_userProfile();
                                    }
                                } else {
                                    swal("Notice","@lang($page_lang.'.Wrong in save skills.')", "error");
                                }
                            }
                        });
                    }else{
                        swal("Notice","@lang($page_lang.'.Please selecte skill for project.')", "info");
                    }
                }



            });

        });

        function clickEmailResend() {
            swal("Send email", "@lang($page_lang.'We have sent you an email to verify your email address,please check your inbox.')", "success");
        }

        function btn_checkEmail() {
            var formData = new FormData();
            var _val = "{{csrf_token()}}";
            formData.append('_token', _val);
            $.ajax({
                url: "{{url('/checkEmailVerify')}}",
                type: 'POST',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (result) {
                    if (result == 1) {
                        swal("Notice","@lang($page_lang.'.email is verify.')", "success");
                        //------check fill field user profile.
                        check_userProfile();
                    } else {
                        swal("Notice","@lang($page_lang.'.Your email not verify.')", "error");
                    }
                }
            });
        }

        function check_userProfile() {
            name_user = "{{$current_user['name']}}";
            family_user = "{{$current_user['family']}}";
            description_user = "{{$current_user['description']}}";
            hourly_rate_value_user = "{{$current_user['hourly_rate_value']}}";

            if(!name_user || !family_user || !description_user || !hourly_rate_value_user)
            {
                html_name = "";
                html_family = "";
                html_description = "";
                html_hourlyRate = "";

                if(!name_user){
                    html_name = '<div class="col-md-6">\n' +
                        '    <input id="name_user" type="text" class="form-control m-t-20" value="" placeholder="@lang($page_lang.'.Name')">\n' +
                        '</div>';
                }
                if(!family_user){
                    html_family ='<div class="col-md-6">\n' +
                        '   <input id="family_user" type="text" class="form-control m-t-20" value="" placeholder="@lang($page_lang.'.Family')">\n' +
                        '</div>';
                }
                if(!hourly_rate_value_user){
                    html_hourlyRate = '<div class="col-md-6">\n' +
                        '                    <input id="hourly_rate_value_user" type="number" class="form-control m-t-20" value="" placeholder="@lang($page_lang.'.Hourly rate (USD/Hr)')">\n' +
                        '              </div>';
                }
                if(!description_user){
                    html_description ='<div class="col-md-12">\n' +
                        '                    <textarea id="description_user" class="form-control m-t-20" value="" placeholder="@lang($page_lang.'.Description')"></textarea>\n' +
                        '              </div>';
                }

                $('#div_Condition').empty();
                $('#div_Condition').append('<div class="row"><p class="h5">@lang($page_lang.'.Completing the information below will help you identify better in the evaluations.')</p>'+html_name+html_family+html_description+html_hourlyRate+'' +
                    '<div class="col-md-12  m-t-20"><button onclick="btn_saveProfile()" type="button" class="pull-right btn btn-outline-success border-success min-h-0">@lang($page_lang.'.Save')</button>' +
                    '</div></div>');
            }
            else{
                //------send request to project.
                requestProject();
            }
        }

        function btn_saveProfile() {
            arrayData = "";
            filldata = "";
            if($('#name_user').length){
                if($('#name_user').val().length > 0){
                    arrayData += 'name:' + $('#name_user').val() + ",";
                }
                else{
                    filldata = " Name";
                }
            }
            if($('#family_user').length ){
                if($('#family_user').val().length > 0){
                    arrayData += 'family:' + $('#family_user').val() + ",";
                }
                else{
                    filldata = " Family";
                }
            }
            if($('#hourly_rate_value_user').length){
                if($('#hourly_rate_value_user').val().length > 0){
                    arrayData += 'hourly_rate_value:' + $('#hourly_rate_value_user').val() + ",";
                }
                else{
                    filldata = " Hourly_rate_value";
                }
            }
            if($('#description_user').length ){
                if($('#description_user').val().length > 0){
                    arrayData += 'description:' + $('#description_user').val().replace(/\s+/g," ") + ",";
                }
                else{
                    filldata = " Description";
                }
            }

            if(arrayData.length > 0 && filldata.length == 0) {
                var formData = new FormData();
                var _val = "{{csrf_token()}}";
                formData.append('_token', _val);
                formData.append('data', arrayData);
                $.ajax({
                    url: "{{url('/updateUserProfile')}}",
                    type: 'POST',
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success: function (result) {
                        if (result == 1) {
                            swal("Notice","@lang($page_lang.'.data is save.')", "success");
                            //------send request to project.
                            requestProject();
                        } else {
                            swal("Notice","@lang($page_lang.'.Wrong to update data')", "error");
                        }
                    }
                });
            }
            else{
                swal("Notice","@lang($page_lang.'.Please enter ')"+filldata, "error");
            }
        }

        function requestProject() {
            $('#div_Condition').empty();
            typeProject =  "{{$project['wage']['type']}}";
            stateProject = "{{$project['state']}}";

            //-----check project state -> opened.
            if(stateProject == "opened"){
                min = parseFloat("{{$project['wage']['minbudget']}}");
                max = parseFloat("{{$project['wage']['maxbudget']}}");
                avg = min + ((max - min) / 2);
                //------typeProject => hour.
                if(typeProject == 'hour'){
                    $('#div_Condition').append('<p class="h5 border-bottom p-b-20">@lang($page_lang.'.Place a Bid on this Project')</p>\n' +
                        '                                    <p class="h5 font-weight-bold m-t-20">Bid Details</p>\n' +
                        '                                    <div class="row" >\n' +
                        '                                        <div class="col-md-4 offset-md-2r">\n' +
                        '                                            <label class="h6 font-weight-bold">@lang($page_lang.'.Hourly Rate')</label>\n' +
                        '                                            <input id="Hourly_Rate" type="number" class="form-control min-h-0" onchange="Computing()" value="'+avg+'"/>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="col-md-4 offset-md-2r">\n' +
                        '                                            <label class="h6 font-weight-bold">@lang($page_lang.'.Weekly Limit')</label>\n' +
                        '                                            <input id="Weekly_Limit" type="number" class="form-control min-h-0" value="40"/>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="col-md-12 display-inline">\n' +
                        '                                            <small id="sumPrice" class="text-muted font-size-9"></small>\n' +
                        '                                            <small id="sumforPrice" class="text-muted font-size-8 m-t-5"></small>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="col-md-12 m-t-10">\n' +
                        '                                            <label class="h6 font-weight-bold">@lang($page_lang.'.Describe your proposal')</label>\n' +
                        '                                            <textarea id="Describe_your_proposal" class="form-control font-size-12" placeholder="What makes you the best candidate for this project?"></textarea>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="col-md-12 btn-postProject m-t-20">\n' +
                        '                                            <button onclick="btn_saveRequest()" type="button" class="btn btn-success min-h-0">@lang($page_lang.'.Place Bid')</button>\n' +
                        '                                        </div>\n' +
                        '                                    </div>');
                }
                else{
                    //------typeProject => project.
                    symbol = "{{$project['wage']['currency']['symbol']}}";
                    $('#div_Condition').append('<p class="h5 border-bottom p-b-20">@lang($page_lang.'.Place a Bid on this Project')</p>\n' +
                        '                                    <p class="h5 font-weight-bold m-t-20">@lang($page_lang.'.Bid Details')</p>\n' +
                        '                                    <div class="row" >\n' +
                        '                                        <div class="col-md-4 offset-md-2r">\n' +
                        '                                            <label class="h6 font-weight-bold">@lang($page_lang.'.Bid Amount ')('+symbol+')</label>\n' +
                        '                                            <input id="Bid_Amount" type="number" class="form-control min-h-0" onchange="ComputingProject()" value="'+avg+'"/>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="col-md-4 offset-md-2r">\n' +
                        '                                            <label class="h6 font-weight-bold">@lang($page_lang.'.This project will be delivered in (Day)')</label>\n' +
                        '                                            <input id="Day_Limit" type="number" class="form-control min-h-0" value="7"/>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="col-md-12 display-inline">\n' +
                        '                                            <small id="sumPriceProject" class="text-muted font-size-9"></small>\n' +
                        '                                            <small id="sumforPriceProject" class="text-muted font-size-8 m-t-5"></small>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="col-md-12 m-t-10 border-bottom p-b-20">\n' +
                        '                                            <label class="h6 font-weight-bold">@lang($page_lang.'.Describe your proposal')</label>\n' +
                        '                                            <textarea id="Describe_your_proposal" class="form-control font-size-12" placeholder="@lang($page_lang.'.What makes you the best candidate for this project?')"></textarea>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="col-md-12">\n' +
                        '                                            <p class="h5 font-weight-bold">@lang($page_lang.'.Suggest a milestone')</p>\n' +
                        '                                            <p class="h5 m-t-20">@lang($page_lang.'.Define the tasks that you will complete for this')</p>\n' +
                        '                                            <div id="div_mileston" class="col-md-12">\n' +
                        '                                            <div class="col-md-12 m-t-5">\n' +
                        '                                                 <input id="ms" class="form-control font-size-12 col-md-7 m-r-5 min-h-0" type="text" placeholder="@lang($page_lang.'.Describe your proposal')">\n' +
                        '                                                 <input id="ms_p" class="form-control font-size-12 col-md-2 text-center m-r-5 min-h-0" type="number" placeholder="$0">\n' +
                        '                                            </div>\n' +
                        '                                                 <button id="btn_addMileston" onclick="createMilestone()" type="button" class="btn btn-secondary m-t-20 min-h-0">@lang($page_lang.'.Add another milestone')</button>\n' +
                        '                                            </div>\n' +
                        '                                        <div class="col-md-12 btn-postProject m-t-20">\n' +
                        '                                            <button onclick="btn_saveRequest()" type="button" class="btn btn-success min-h-0">@lang($page_lang.'.Place Bid')</button>\n' +
                        '                                        </div>\n' +
                        '                                    </div>');
                }
            }
            else{
                $('#div_main_request').remove();
            }
        }

        function Computing() {
            Hourly_Rate = parseFloat($('#Hourly_Rate').val());
            symbol = "{{$project['wage']['currency']['symbol']}}";
            Percentage = (10 * Hourly_Rate) / 100 ;

            sum = Hourly_Rate - Percentage;
            valueString ='Paid to you: '+symbol+Hourly_Rate+' - '+symbol+Percentage+' fee = '+symbol+sum+'.';

            document.getElementById('sumPrice').innerText = valueString;
            document.getElementById('sumforPrice').innerText = "@lang($page_lang.'.(Excludes 10% Freelancer fee)')";
        }

        function ComputingProject() {
            Bid_Amount = parseFloat($('#Bid_Amount').val());
            symbol = "{{$project['wage']['currency']['symbol']}}";
            Percentage = (20 * Bid_Amount) / 100 ;

            sum = Bid_Amount - Percentage;
            valueString ='Paid to you: '+symbol+Bid_Amount+' - '+symbol+Percentage+' fee = '+symbol+sum+'.';

            document.getElementById('sumPriceProject').innerText = valueString;
            document.getElementById('sumforPriceProject').innerText = "@lang($page_lang.'.(Excludes 20% Freelancer fee)')";
        }
        //------ save request bids.
        function btn_saveRequest() {
            //---- whats type project?
            //---type -> hour
            if(typeProject == 'hour') {
                Hourly_Rate = parseFloat($('#Hourly_Rate').val());
                Weekly_Limit = parseFloat($('#Weekly_Limit').val());
                Describe_your_proposal = $('#Describe_your_proposal').val().replace(/\s+/g," ");
                //----- check not empty field.
                if(Hourly_Rate > 0 && Weekly_Limit > 0 && Describe_your_proposal.length > 0){
                    var formData = new FormData();
                    var _val = "{{csrf_token()}}";
                    formData.append('_token', _val);
                    formData.append('type', "hour");
                    formData.append('projectid', "{{$project['projectid']}}");
                    formData.append('Hourly_Rate', Hourly_Rate);
                    formData.append('Weekly_Limit', Weekly_Limit);
                    formData.append('Describe_your_proposal', Describe_your_proposal);
                    $.ajax({
                        url: "{{url('/saveBidProject')}}",
                        type: 'POST',
                        data: formData,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        success: function (result) {
                            if (result == 1) {
                                $('#div_Condition').empty();
                                swal("Notice","@lang($page_lang.'.Bid send for this project.')", "success");
                                window.location.href = "{{url('/project-proposal/'.$project['projectid'])}}";
                            } else {
                                swal("Notice","@lang($page_lang.'.Error to send bid for this project!')", "error");
                            }
                        }
                    });
                }
                else{
                    swal("Notice","@lang($page_lang.'.Please enter the requested information (enter the correct values ​​for each field).')", "info");
                }
            }
            else{
                //---type -> project
                symbol = "{{$project['wage']['currency']['symbol']}}";
                Bid_Amount = parseFloat( $('#Bid_Amount').val() );
                Day_Limit = parseInt( $('#Day_Limit').val() );
                Describe_your_proposal = $('#Describe_your_proposal').val().replace(/\s+/g," ");
                min = parseFloat("{{$project['wage']['minbudget']}}");
                max = parseFloat("{{$project['wage']['maxbudget']}}");
                if(Bid_Amount > 0 ){
                    if(Bid_Amount >= min){
                        if(Day_Limit > 0){
                            if(Describe_your_proposal.length > 0){
                                sumMailston = 0;
                                dataPriceMilestone = [];
                                dataTitleMilestone = [];
                                dataPriceMilestone.push(parseFloat($('#ms_p').val()));
                                dataTitleMilestone.push($('#ms').val());
                                //---- milestone is define.
                                if(arrayMilestonDiv.length > 0){
                                    $.each(arrayMilestonDiv,function (index,item) {
                                        sumMailston = sumMailston + parseFloat($('#ms_p_'+item).val());
                                        dataPriceMilestone.push(parseFloat($('#ms_p_'+item).val()));
                                        dataTitleMilestone.push($('#ms_'+item).val());
                                    });
                                    sumMailston = sumMailston + parseFloat($('#ms_p').val());
                                }
                                else{
                                    sumMailston = parseFloat($('#ms_p').val());
                                }

                                if(sumMailston == Bid_Amount){
                                    if(!dataTitleMilestone.includes(undefined) && !dataTitleMilestone.includes(null) && !dataTitleMilestone.includes("")){
                                        //if condition all value is true enter -> go to save request.
                                        var formData = new FormData();
                                        var _val = "{{csrf_token()}}";
                                        formData.append('_token', _val);
                                        formData.append('type', "project");
                                        formData.append('projectid', "{{$project['projectid']}}");
                                        formData.append('Hourly_Rate', Bid_Amount);
                                        formData.append('Weekly_Limit', Day_Limit);
                                        formData.append('Describe_your_proposal', Describe_your_proposal);
                                        formData.append('dataPriceMilestone', dataPriceMilestone);
                                        formData.append('dataTitleMilestone', dataTitleMilestone);
                                        $.ajax({
                                            url: "{{url('/saveBidProject')}}",
                                            type: 'POST',
                                            data: formData,
                                            processData: false,  // tell jQuery not to process the data
                                            contentType: false,  // tell jQuery not to set contentType
                                            success: function (result) {
                                                if (result == 1) {
                                                    swal("Notice","@lang($page_lang.'.Bid send for this project.')", "success");
                                                    $('#div_Condition').empty();
                                                    window.location.href = "{{url('/project-proposal/'.$project['projectid'])}}";
                                                } else {
                                                    swal("Notice","@lang($page_lang.'.Error to send bid for this project!')", "error");
                                                }
                                            }
                                        });
                                    }else{
                                        swal("Notice","@lang($page_lang.'.Please enter describe in milestone!')", "error");
                                    }
                                }else{
                                    swal("Notice","@lang($page_lang.'.Please enter the correct price in milestone!')", "error");
                                }
                            }
                            else{
                                swal("Notice","@lang($page_lang.'.Please enter Describe your proposal!')", "error");
                            }
                        }
                        else{
                            swal("Notice","@lang($page_lang.'.Please enter correct value delivered in (Day)!')", "error");
                        }
                    }
                    else{
                        swal("Notice","@lang($page_lang.'.Please enter value Bid Amount Larger or equal from ')"+symbol+min+" !" , "error");
                    }
                }
                else{
                    swal("Notice","@lang($page_lang.'.Please enter correct value Bid Amount!')", "error");
                }
            }
        }

        function createMilestone() {
            $('#btn_addMileston').remove();
            $('#div_mileston').append('<div id="div_m_'+counter+'" class="col-md-12 m-t-5">\n' +
                '    <input id="ms_'+counter+'" class="form-control font-size-12 col-md-7  m-r-5  min-h-0" type="text" placeholder="@lang($page_lang.'.Describe your proposal')">\n' +
                '    <input id="ms_p_'+counter+'" class="form-control font-size-12 col-md-2 text-center  m-r-5  min-h-0" type="number" placeholder="$0">\n' +
                '    <button id="btn_remove_'+counter+'" onclick="removeMilestone('+counter+')" type="button" class="col-md-2 btn btn-outline-danger min-h-0">@lang($page_lang.'.Remove')</button>\n'+
                '</div>\n' +
                '<button id="btn_addMileston" onclick="createMilestone()" type="button" class="btn btn-secondary m-t-20 min-h-0">@lang($page_lang.'.Add another milestone')</button>');
            arrayMilestonDiv.push(counter);
            counter = counter + 1;

        }

        function removeMilestone(id) {
            val = arrayMilestonDiv.indexOf(id);
            arrayMilestonDiv.splice(val,1);
            $("#div_m_"+id).remove();
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
