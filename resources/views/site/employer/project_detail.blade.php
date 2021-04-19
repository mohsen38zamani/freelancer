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

        <!-- second menu -->
        <div class="SecondHeader-dashborad">
            <div class="topnav">
                <div class="container">
                    <a href="{{url('/project-detail/')}}@if(isset($project['projectid'])){{'/'.$project['projectid']}} @endif" class=" @if($checkEdit != 'edit')active @endif ">@lang($page.'.Details')</a>
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
                                        @if($checkEdit == 'edit')
                                            <textarea name="describtion" id="descripProject" cols="10" rows="6" class="form-control">@if(isset($project['description'])){{$project['description']}}@endif</textarea>
                                        @else
                                            <p>Description: @if(isset($project['description'])) {{$project['description']}} @endif</p>
                                        @endif
                                    </div>
                                    <div class="row mt-5">
                                        <h4>@lang($page.'.Skills Required') </h4>
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
                                    @if($checkEdit != 'edit')
                                        @if(isset($project['attachment']))
                                            <div class="row mt-5 display-block">
                                                <h4>Attachments </h4>
                                                @foreach($project['attachment'] as $list)
                                                    <p class="display-6"><a href="{{url('/'.$list['path'])}}" target="_blank">{{'File ('.$list['attachmentid'].')'}}</a></p>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @if($checkEdit == 'edit')
                                <div class="btn-postProject">
                                    <button id="sendData"  type="button" class="btn btn-success saveEdit my-2">@lang($page.'.Upgrade')</button>
                                </div>
                            @endif

                        </div>

                        <!--//////////////// Start advance option ///////////////////-->
                        @php
                            $field_value = $block_field['information']['advanceoption'];
                            $field_key = "advanceoption";
                        @endphp

{{--                        @if($checkEdit == 'edit')--}}
{{--                            <div class="Recent-project-dashbord mb-10">--}}
{{--                                <div class="project-title display-flex">--}}
{{--                                    <div class="col-md-12 p-all-20">--}}
{{--                                        <p class="h4 color-title m-all-0"> Project Upgrades </p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="content-Recent-project-dashbord">--}}
{{--                                    <div id="advanceOption" >--}}
{{--                                        <ul id="ul_advancedOption" class="pl-5 pr-5">--}}
{{--                                            @foreach($field_value as $listAdvancedOption)--}}
{{--                                                --}}{{--                                            {{dd($listAdvancedOption,$project['project_advanceoption'])}}--}}
{{--                                                @php--}}
{{--                                                    $flag =false;--}}
{{--                                                        foreach($project['project_advanceoption'] as $list)--}}
{{--                                                        {--}}
{{--                                                            if($listAdvancedOption['advanceoptionid']== $list['advanceoptionid'])--}}
{{--                                                               {--}}
{{--                                                                    $flag = true;--}}
{{--                                                               }--}}
{{--                                                        }--}}
{{--                                                @endphp--}}

{{--                                                @if(!$flag)--}}
{{--                                                    <li class="shadow-box row mt-3">--}}
{{--                                                        <div class="col-md-1">--}}
{{--                                                            <div class="pretty p-icon p-smooth mt-4" >--}}
{{--                                                                <input id="{{'ao_'.$listAdvancedOption->advanceoptionid}}"  type="checkbox" onclick="advanceOption({{ $listAdvancedOption->advanceoptionid}})" />--}}
{{--                                                                <div class="state p-success">--}}
{{--                                                                    <i class="icon fa fa-check mt-2 ml-1"></i>--}}
{{--                                                                    <label></label>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-md-2 pt-3"><strong>{{$listAdvancedOption->name}}</strong></div>--}}
{{--                                                        <div class="col-md-7 pt-1"><p>{{$listAdvancedOption->description}}</p></div>--}}
{{--                                                        <div class="col-md-2  pt-1">--}}
{{--                                                            @if($listAdvancedOption->discount_percent != 0) <div class="display-block text-danger"><strong> {{'only '.$listAdvancedOption->discount_percent}}</strong></div> @endif--}}
{{--                                                            <div class="display-block @if($listAdvancedOption->discount_percent  != 0) line-through @endif">{{$listAdvancedOption->price .' '.$listAdvancedOption->currency->name}}</div>--}}
{{--                                                        </div>--}}
{{--                                                    </li>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}

{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="btn-postProject">--}}
{{--                                    <button id="btn_sendAO" type="button" class="btn btn-success saveEdit my-2">Upgrade</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
                    </div>
                </div>
                <!--//////////////// END advance option ///////////////////-->
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
            segmentUrl = '{{$checkEdit}}';
            if (segmentUrl != 'edit') {
                $('#selectSkill').select2("enable", false)
                $('#selectSkill').attr("background-color", "#fff")
            }

            $('#sendData').click(function () {
                projectid = "{{$project['projectid']}}";
                var formData = new FormData();
                var _val = "{{csrf_token()}}";
                formData.append('_token', _val);
                formData.append('projectid', projectid);
                formData.append('skill', $('#selectSkill').val());
                formData.append('description', $('#descripProject').val());
                formData.append('name', '{{$project['name']}}');

                $.ajax({
                    url: '/project-detail/save',
                    type: 'POST',
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success: function (result) {
                        if (Boolean(result)) {
                            swal("Notice", "@lang('site.Project is updated.')", "success");
                        } else {
                            swal("Notice", "@lang('site.Wrong in update data.')", "error");
                        }
                    }
                });

            });

            $('#btn_sendAO').click(function () {
                if(advanceOption_selected.length > 0){
                    projectid = "{{$project['projectid']}}";
                    var formData = new FormData();
                    var _val = "{{csrf_token()}}";
                    formData.append('_token', _val);
                    formData.append('projectid', projectid);
                    formData.append('advanceOption', advanceOption_selected );

                    $.ajax({
                        url: '/project-detail/save_advanceOption',
                        type: 'POST',
                        data: formData,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        success: function (result) {
                            if (Boolean(result)) {
                                swal("Notice","@lang('site.Project is updated.')", "success");
                                location.reload();
                            } else {
                                swal("Notice","@lang('site.Wrong in update data.')", "error");
                            }
                        }
                    });
                }
            });


        });

        function advanceOption(id) {
            if( document.querySelector('#ao_'+id+':checked') !== null ){
                if(advanceOption_selected.includes(id))
                {
                    advanceOption_selected.splice( advanceOption_selected.indexOf(id), 1 );
                }
                else{
                    advanceOption_selected.push(id);
                }
            }else{
                if(advanceOption_selected.includes(id))
                {
                    advanceOption_selected.splice( advanceOption_selected.indexOf(id), 1 );
                }
            }
        }

        function delete_project() {
            $('a').removeClass('active');
            $('#del_tag').addClass('active');

            swal({
                title: "@lang('site.Are you sure you want to delete the project?')",
                text: "@lang('site.If you wish to delete and press the Yes button')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4edd06",
                confirmButtonText: "Yes",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (Boolean(isConfirm)) {
                    projectid = "{{$project['projectid']}}";
                    var formData = new FormData();
                    var _val = "{{csrf_token()}}";
                    formData.append('_token', _val);
                    formData.append('id', projectid);

                    $.ajax({
                        url: "{{url('/project-detail/delete')}}",
                        type: 'POST',
                        data: formData,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        success: function (result) {
                            if (Boolean(result)) {
                                swal("Notice","@lang('site.Project is delete.')", "success");
                                window.location.href = "{{url('/profile')}}";
                            } else {
                                swal("Notice","@lang('site.Wrong in delete project.')", "error");
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
