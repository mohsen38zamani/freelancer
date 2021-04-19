@extends('site.mainpage')
@section('page_content')
    @php
        //$page = \Request::segment(1);
        $page = 'user_profile';
        $tab = 'Profile';
        if(isset($_REQUEST['Profile']))
            $tab = 'Profile';
        elseif(isset($_REQUEST['Email']))
            $tab = 'Email';
        elseif(isset($_REQUEST['Membership']))
            $tab = 'Membership';
        elseif(isset($_REQUEST['Password']))
            $tab = 'Password';
        elseif(isset($_REQUEST['Payment']))
            $tab = 'Payment';
        elseif(isset($_REQUEST['Trust']))
            $tab = 'Trust';
        elseif(isset($_REQUEST['Secourity']))
            $tab = 'Secourity';
        elseif(isset($_REQUEST['Account']))
            $tab = 'Account';
    @endphp
    @if($current_page_user->name || $current_page_user->family)
        @section('page-title'){{ $current_page_user->name . ' ' . $current_page_user->family }} @endsection
    @else
        @section('page-title') {{ ucfirst($page)}} @endsection
    @endif
@section('css-extend')
    <link href="{{ asset('assets/timepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endsection
<!-- main profile -->
<div class="container clearfix">
    <section id="main-container">
        <!-- tabs -->
        <div class="row p-t-50">
            <div class="col-md-3">
                <ul class="nav nav-tabs tabs-left" role="tablist">
                    <!--=========== Profile ================-->
                    <li role="presentation" @if($tab == 'Profile') class="active" @endif><a href="#Profile" aria-controls="Profile" role="tab" data-toggle="tab">@lang($page . '.Profile')</a></li>
                    <!--=========== Email & Notification ================-->
                {{--<li role="presentation" @if($tab == 'Email') class="active" @endif><a href="#Email" aria-controls="Email" role="tab" data-toggle="tab">@lang($page . '.Email & Notification')</a></li>--}}
                <!--=========== Membership ================-->
{{--                    <li role="presentation" @if($tab == 'Membership') class="active" @endif><a href="#Membership" aria-controls="Membership" role="tab" data-toggle="tab">@lang($page . '.Membership')</a></li>--}}
                    <!--=========== Password ================-->
                    <li role="presentation" @if($tab == 'Password') class="active" @endif><a href="#PasswordTab" aria-controls="PasswordTab" role="tab" data-toggle="tab">@lang($page . '.Password')</a></li>
                    <!--=========== Payment & Financials ================-->
                    <li role="presentation" @if($tab == 'Payment') class="active" @endif><a href="#Payment" aria-controls="Payment" role="tab" data-toggle="tab">@lang($page . '.Payment & Financials')</a></li>
                    <!--=========== Account Secourity ================-->
                    <li role="presentation" @if($tab == 'Secourity') class="active" @endif><a href="#Secourity" aria-controls="Secourity" role="tab" data-toggle="tab">@lang($page . '.Account Secourity')</a></li>
                    <!--=========== Trust & Verification ================-->
                    <li role="presentation" @if($tab == 'Trust') class="active" @endif><a href="#Trust" aria-controls="Trust" role="tab" data-toggle="tab">@lang($page . '.Trust & Verification')</a></li>
                    <!--=========== Account ================-->
                    <li role="presentation"><a href="#Account" aria-controls="Account" role="tab" data-toggle="tab">@lang($page . '.Account')</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-content edit-profile">
                    <div class="clear"></div>
                    @if (\Session::has('success'))
                        <div class="alert alert-success m-t-10">
                            <ul>
                                <li>@lang($page.'.'.\Session::get('success'))</li>
                            </ul>
                        </div>
                    @endif
                    @if (\Session::has('error'))
                        <div class="alert alert-danger m-t-10">
                            <ul>
                                <li>@lang($page.'.'.\Session::get('error'))</li>
                            </ul>
                        </div>
                @endif
                    <!--=========== Start Profile content ================-->
                    <div role="tabpanel" class="tab-pane @if($tab == 'Profile') active @endif" id="Profile">
                        <div class="title-content">
                            <h4>@lang($page . '.Profile Details')</h4>
                        </div>
                        <form action="{{ url("/profile/edit/") }}" method="post" id="frm-Profile">
                            {{ csrf_field() }}
                            <!-- name -->
                            <div class="line-form">
                                <span>@lang($page . '.Name')</span>
                                <div class="name user_profile-Name">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <label for="name" class="">@lang($page . '.name')</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="name" name="name" class="form-control" placeholder="first name" value="{{ $current_page_user['name'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <label for="family" class="">@lang($page . '.family')</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="family" name="family" class="form-control" placeholder="last name" value="@if(empty(old('family'))){{ $current_page_user['family'] }}@else{{ old('family') }}@endif">
                                            @if ($errors->has('family'))
                                                <span class="help-block">
                                                        <strong>
                                                            @php
                                                                $msg = str_replace('_', ' ', 'family');
                                                                echo str_replace($msg, __($page.'.family'), $errors->first('family'));
                                                            @endphp
                                                        </strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- address -->
                            <div class="line-form">
                                <span>@lang($page . '.information')</span>
                                <div class="">
                                    <div class="row p-t-10">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <label for="description">@lang($page . '.description')</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <textarea id="description" name="description" class="form-control" rows="2" placeholder="description">{{ $current_page_user['description'] }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row p-t-10">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <label for="tel">@lang($page . '.tel')</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="tel" id="tel" class="form-control" placeholder="" value="{{ $current_page_user['tel'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <label for="mobile">@lang($page . '.mobile')</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="" value="{{ $current_page_user['mobile'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <label for="birthday">@lang($page . '.birthday')</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="birthday" id="birthday" class="form-control datepicker" value="{{ date('Y-m-d', strtotime($current_page_user['birthday'])) }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <label for="mobile">@lang($page . '.gender')</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="1" @if($current_page_user['gender'] == 1) selected @endif>@lang($page . '.male')</option>
                                                        <option value="2" @if($current_page_user['gender'] == 2) selected @endif>@lang($page . '.female')</option>
                                                        <option value="3" @if($current_page_user['gender'] == 3) selected @endif>@lang($page . '.other')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <label for="companyname">@lang($page . '.Company')</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" id="companyname" name="companyname" class="form-control" placeholder="company" value="{{ $current_page_user['companyname'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="address">@lang($page . '.Address')</label>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea id="address" name="address" class="form-control" rows="2" placeholder="address">{{ $current_page_user['address'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-t-10">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="city">@lang($page . '.City')</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="city" id="city" class="form-control" placeholder="city" value="{{ $current_page_user['city'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="postcode">@lang($page . '.Zip/PostCode')</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="postcode" id="postcode" class="form-control" placeholder="post code" value="{{ $current_page_user['postcode'] }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="province">@lang($page . '.State/Province')</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="province" id="province" class="form-control" placeholder="province" value="{{ $current_page_user['province'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="country">@lang($page . '.country')</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" id="country" class="form-control" placeholder="country" disabled value="{{ $current_page_user['country']['name'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-right p-all-10 p-r-30">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success saveSetting">@lang($page . '.Save Setting')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- language -->
                            {{--<div class="line-form">
                                <span>Language Setting</span>
                                <div class="address">
                                    <div class="form-group">
                                        <div class="col-md-5">
                                            <label for="Address">I want to browser the website in:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="form-control">
                                                <option value="english">English</option>
                                                <option value="persian">Persian</option>
                                                <option value="italy">Italy</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-5">
                                            <label for="Address">I want to browser project in the language:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select name="" id="" class="form-control">
                                                <option value="add language">Add Language</option>
                                            </select>
                                            <!-- tag manager -->
                                            <div class="mainTag">
                                                <input name="tags" placeholder="Tags"
                                                       class="tagManager" />
                                                <input name="tags" placeholder="Tags"
                                                       class="tagManager" />
                                                <input name="tags" placeholder="Tags"
                                                       class="tagManager" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                            <!-- button save setting -->

                            <!-- security phone number -->
                        </form>
{{--                        <div class="line-form">
                            <span>@lang($page . '.Security Phone Number')</span>
                            <div class="form-group">
                                <p class="parag-phone">@lang($page . '.Provide a phone number and country to use as verification of your account')</p>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success saveSetting">@lang($page . '.Set up Security Number')</button>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                    <!--=========== Start Email content ================-->
                    <div role="tabpanel" class="tab-pane @if($tab == 'Email') active @endif" id="Email">
                        <div class="title-content">
                            <h4>@lang($page . '.Email & Notification')</h4>
                        </div>
                        <form class="form-row" action="">
                            <!-- email -->
                            <div class="line-form">
                                <span>Email</span>
                                <div class="name">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <label for="Email-Address">Email Address</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="Email-Address" class="form-control"
                                                   placeholder="email address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <label for="Password">Enter Correct Password</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="Password" class="form-control"
                                                   placeholder="enter correct password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- button save setting -->
                            <div class="row">
                                <div class="col-md-12 text-right p-all-10 p-r-30">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success saveSetting">@lang($page . '.Save Setting')</button>
                                    </div>
                                </div>
                            </div>
                            <!-- email format -->
                            <div class="line-form">
                                <span>Email Format</span>
                                <div class="name">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="Address">Email Format</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control">
                                                <option value="html">Html</option>
                                                <option value="css">Css</option>
                                                <option value="js">js</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- digest email-->
                            <div class="line-form">
                                <span>Digest Email For Your Posted Projects</span>
                                <div class="other-section">
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>When a bide is placed / update / retacted on your
                                                project.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="Frequency">Email Frequency for project related
                                                activity</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control">
                                                <option value="Default">Default</option>
                                                <option value="Default">Default</option>
                                                <option value="Default">Default</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-12">
                                            <p class="parag-phone">Lorem ipsum dolor sit amet consectetur adipisicing
                                                elit. Minima minus magnam voluptatem facilis nostrum maiores? Ab,
                                                reiciendis? Nobis natus cum, tenetur assumenda officia quisquam, sit
                                                sapiente suscipit soluta rerum ratione?</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- notification-->
                            <div class="line-form row">
                                <span>Notification of lasted local jobs</span>
                                <div class="name">
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>When a project gets posted that matches any selected
                                                skills.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="Frequency">Email Frequency</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control">
                                                <option value="Daily">Daily</option>
                                                <option value="Daily">Daily</option>
                                                <option value="Daily">Daily</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Notification of lasted local jobs-->
                            <div class="line-form row">
                                <span>Notification of lasted local jobs</span>
                                <div class="name">
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>SMS notification when an employer is interested in hiring
                                                me</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>When a local hob in my area gets posted</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Digest Emails For Messages-->
                            <div class="line-form row">
                                <span>Digest Emails For Messages</span>
                                <div class="name">
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>When you receive a privat message from a contact</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>When you receive a message about a project or contest</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>When you receive a message about a project or contest</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- individual notification-->
                            <div class="line-form">
                                <span>Individual Notification</span>
                                <div class="name">
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>News and announcements from freelancer</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>You are awarled a project</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>A freelancer request you to release a milertone</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>We notify you of the top bidder for your projects</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>We notify you of the lastest activity regarding services</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>We notify you of the lastest activity regarding free
                                                market</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>A freelancer requests you as a contact</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- other notification-->
                            <div class="line-form">
                                <span>Other Notification</span>
                                <div class="name">
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>Marketing emails</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>freelancer.com deals</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>Monthly newsletter</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>Weehly Community digest</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>Referral program notification</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--=========== Start Membership content ================-->
                    <div role="tabpanel" class="tab-pane @if($tab == 'Membership') active @endif" id="Membership">
                        <form action="">
                            <div class="title-content">
                                <h4>@lang($page . '.Membership')</h4>
                            </div>
                            <div class="line-form px-2">
                                <h3>Current plans</h3>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="billing-main">
                                            <span>Free</span>
                                            <p><span>$</span> per month</p>
                                            <a class="btn-a" href="#">Manage</a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="billing-main">
                                            <h4>Billing Information</h4>
                                            <p>Wirv Transaction History / <a href="#">Manage Peyment Methods</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="link">
                                    <p class="btn-a">You are cligible for free plus membership to clime for free 1 month
                                        free <a href="#">Click here</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--=========== Start Password content ================-->
                    <div role="tabpanel" class="tab-pane @if($tab == 'Password') active @endif" id="PasswordTab">
                        <div class="title-content">
                            <h4>@lang($page . '.Password')</h4>
                        </div>
                        <form action="{{ url("/profile/edit/change_password") }}" method="post" id="frm-Password">
                            {{ csrf_field() }}
                            <!-- Change Password -->
                            <div class="line-form">
                                <span>@lang($page . '.Change Password')</span>
                                <div class="address">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label for="current_password">@lang($page . '.Current Password')</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Current Password">
                                            @if ($errors->has('current_password'))
                                                <span class="help-block">
                                                    <strong>
                                                        @php
                                                            $msg = str_replace('_', ' ', 'current_password');
                                                            echo str_replace($msg, __($page.'.current_password'), $errors->first('current_password'));
                                                        @endphp
                                                    </strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label for="new_password">@lang($page . '.New Password')</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" id="new_password" name="new_password" class="form-control " placeholder="New Password">
                                            @if ($errors->has('new_password'))
                                                <span class="help-block">
                                                    <strong>
                                                        @php
                                                            $msg = str_replace('_', ' ', 'new_password');
                                                            echo str_replace($msg, __($page.'.new_password'), $errors->first('new_password'));
                                                        @endphp
                                                    </strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label for="new_password_confirmation">@lang($page . '.Confirm Password')</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="Confirm Password">
                                            @if ($errors->has('new_password_confirmation'))
                                                <span class="help-block">
                                                    <strong>
                                                        @php
                                                            $msg = str_replace('_', ' ', 'new_password_confirmation');
                                                            echo str_replace($msg, __($page.'.new_password_confirmation'), $errors->first('new_password_confirmation'));
                                                        @endphp
                                                    </strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right p-all-10 p-r-16">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success saveSetting">@lang($page . '.Save Setting')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--=========== Start Payment content ================-->
                    <div role="tabpanel" class="tab-pane @if($tab == 'Payment') active @endif" id="Payment">
                        <div class="title-content">
                            <h4>@lang($page . '.Payment & Financials')</h4>
                        </div>
                        <!-- payment & financials -->
                        <form action="{{ url("/") }}" method="post" id="frm-Payment">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label class="my-2">@lang($page . '.Payment Methods')</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="m-b-15">
                                        <!-- button save setting -->
                                        <a href="{{ url('/user_creditcard/new') }}"><button type="button" class="btn btn-success saveSetting my-2">+ @lang($page . '.add Card')</button></a>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    @if(!$current_page_user->user_creditcard)
                                        <p>@lang($page . ".No $panel Added")</p>
                                    @else
                                        @foreach($current_page_user->user_creditcard as $item)
                                            <div class="profile-block-items">
                                                <p class="pull-right"><a href="{{ url("/user_creditcard/edit/$item->user_creditcardid") }}" class="fa fa-pencil"></a> &nbsp; <a href="{{ url("/user_creditcard/delete/$item->user_creditcardid") }}" class="fa fa-trash"></a></p>
                                                <strong>{{ $item->card_number }}</strong>
                                                <br>
                                                <span>{{ date('Y-m', strtotime($item->exp)) }}</span>
                                                <span> CVV: {{ $item->cvv }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="col-md-12 bor18 m-t-40">
                                    <label class="my-2 m-t-5">@lang($page . '.transactions')</label>
                                    @if(!$current_page_user->transaction)
                                        <p>@lang($page . ".No $panel Added")</p>
                                    @else
                                        <table width="100%" class="table table-bordered m-t-10">
                                            <thead>
                                                <tr>
                                                    <th>@lang($page . '.row')</th>
                                                    <th>@lang($page . '.paypal_transactionid')</th>
                                                    <th>@lang($page . '.price')</th>
                                                    <th>@lang($page . '.status')</th>
                                                    <th>@lang($page . '.orderid')</th>
                                                    <th>@lang($page . '.created_at')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach($current_page_user->transaction as $key => $item)
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $item->paypal_transactionid }}</td>
                                                        <td>{{ $item->price }}</td>
                                                        <td>{{ $item->status }}</td>
                                                        <td>{{ $item->orderid }}</td>
                                                        <td>{{ $item->created_at }}</td>
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>

                                    @endif
                                </div>
                            </div>
                        </div>
                        </form>
                        <!-- tax information -->
                        {{--<form class="form-row" action="">
                            <div class="line-form">
                                <span>Tax Information</span>
                                <div class="address">
                                    <form class="form-row" action="">
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label for="vatCountry">VAT Country</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control">
                                                    <option value="germany">Germany</option>
                                                    <option value="usa">USA</option>
                                                    <option value="iran">Iran</option>
                                                    <option value="england">England</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label for="vatNumber">VAT Number</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="margin-input">
                                                    <div class="form-group">
                                                        <div class="input-group" style="margin:15px -15px 0 15px">
                                                            <div class="input-group-addon">DE</div>
                                                            <input type="number" class="form-control" placeholder="VAT number" style="margin: 0;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- add vat number -->
                                            <div>
                                                <input type="file" id="upload" />
                                                <label for="upload"
                                                       class="button lineHeightBtn btn btn-success saveSetting">+
                                                    Another Box</label>
                                            </div>
                                            <div class="link">
                                                <p class="tax-link"><a href="">Are you empt from VAT?</a></p>
                                            </div>
                                        </div>
                                        <!-- Finance setting -->
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="Currency">My Currency</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" id="Currency" class="form-control"
                                                       placeholder="My Currency">
                                            </div>
                                        </div>
                                        <!-- taxesl -->
                                        <h2 class="title-h1">Taxesl (use when you create an invoice for an employer)
                                        </h2>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <input type="text" id="Currency" class="form-control "
                                                       placeholder="My Currency">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group" style="margin: 15px -15px 0 15px;">
                                                    <input type="number" class="form-control"
                                                           placeholder="VAT number" style="margin: 0;">
                                                    <div class="input-group-addon">%</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" id="Currency" class="form-control "
                                                       placeholder="My Currency">
                                            </div>
                                        </div>
                                        <!-- button save setting -->
                                        <button type="button" class="btn btn-success saveSetting my-2">Save
                                            Setting</button>
                                    </form>
                                </div>
                            </div>
                        </form>--}}
                    </div>
                    <!--=========== Start Secourity content ================-->
                    <div role="tabpanel" class="tab-pane @if($tab == 'Secourity') active @endif" id="Secourity">
                        <div class="title-content">
                            <h4>@lang($page . '.Account Secourity')</h4>
                        </div>
                        <div class="line-form">
                            <div class="twoFactor">
                                @if(!$current_page_user->user_verification_items->email)
                                    <div class="alert alert-warning">
                                        <ul>
                                            <li>@lang($page.'.You must verify your email before you can enable two factor authentication.')</li>
                                        </ul>
                                    </div>
                                @endif
                                <h2 class="title-h1">@lang($page . '.Two - Factor Authentication')</h2>
                                <div>
                                    @lang($page.'.Your account does not have two-factor authentication turned on.')
                                    <p class="parag-phone">
                                        @lang($page.'.Two-factor authentication ensures that only devices you trust are able to access your Freelancer.com account. Whenever a new device attempts to login to your account, you will be required to confirm the login by using a code sent to your email address or phone number.')
                                    </p>
                                    @if($current_page_user->user_verification_items->email)
                                    <div class="div-right">
                                        <!-- button Get Started -->
                                        @if(!$current_page_user->user->two_step_verify)
                                            <a href="{{ url('/twostepenabled/' . $current_page_user->username) }}"><button type="button" class="btn btn-success saveSetting my-2">@lang($page . '.enable')</button></a>
                                        @else
                                            <a href="{{ url('/twostepdisabled/' . $current_page_user->username) }}"><button type="button" class="btn btn-danger saveSetting my-2">@lang($page . '.disable')</button></a>
                                        @endif
                                    </div>
                                    @else
                                        <div class="div-right">
                                            <button type="button" class="btn btn-success saveSetting my-2 disabled">@lang($page . '.enable')</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Login Devices -->
                        <div class="line-form-not-line">
                            <h2 class="title-h1">Login Devices</h2>
                            <div class="parag-phone">
                                <p>
                                    @php
                                    if($user_device['isDesktop'])
                                        $lng_device = '.You use desktop computer.';
                                    elseif($user_device['isTablet'])
                                        $lng_device = '.You use tablet device.';
                                    elseif($user_device['isMobile'])
                                    $lng_device = '.You use mobile device.';
                                    @endphp
                                    @lang($page . $lng_device)
                                </p>
                                @if($user_device['deviceFamily'] != 'Unknown') <p>@lang($page . '.device') {{ $user_device['deviceFamily'] }}</p> @endif
                                @if($user_device['deviceModel'] != 'Unknown') <p>@lang($page . '.device model') {{ $user_device['deviceModel'] }}</p> @endif
                                @if($user_device['platformName'] != 'Unknown') <p>@lang($page . '.operating system') {{ $user_device['platformName'] }}</p> @endif
                                @if($user_device['browserName'] != 'Unknown') <p>@lang($page . '.browser') {{ $user_device['browserName'] }}</p> @endif
                                @if($user_device['ip'] != 'Unknown') <p>@lang($page . '.your ip address:') {{ $user_device['ip'] }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <!--=========== Start Trust content ================-->
                    <div role="tabpanel" class="tab-pane @if($tab == 'Trust') active @endif" id="Trust">
                        <form action="">
                            <div class="title-content">
                                <h4>@lang($page . '.Trust & Verification')</h4>
                            </div>
                            <!-- score -->
                            <div class="line-form">
                                <h2 class="title-h1">@lang($page . '.What is Trust Score ?')</h2>
                                <p class="parag-phone">@lang($page . '.The Freelancer Trust Score is at the core of how we handle verification, trust, and payments. The Trust Score is a value that indicates to what extent we have been able to verify who a user says they are. Employers and freelancers who are the safest to work with are those who put in more effort to verify themselves to become highly trusted users.')</p>
                            </div>
                            <!-- Progress bar -->
{{--                            <div class="line-form">
                                <div class="progressBar">
                                    <ul class="list-unstyled multi-steps">
                                        <li>@lang($page . '.Start')</li>
                                        <li class="is-active">@lang($page . '.Low')</li>
                                        <li>@lang($page . '.Good')</li>
                                        <li>@lang($page . '.Exelent')</li>
                                    </ul>
                                </div>
                            </div>--}}
                            <!-- email address -->
                            <div class="line-form">
                                @if($current_page_user->user_verification_items->email)
                                <div class="m-5">
                                    <span>@lang($page . '.Email Address')</span>
                                    <span class="f-right betP">@lang($page . '.Verified')</span>
                                </div>
                                @else
                                    <div class="m-5 line-height-25">
                                        <span>@lang($page . '.Email Address')</span>
{{--                                    <span class="f-right point">5 point</span>--}}
                                        <span class="f-right"><a class="btn-trust" href="{{ url("/mail_verification/$current_page_user->username") }}">@lang($page . '.Conect with email')</a></span>
                                    </div>
                                @endif
                            </div>
                            <!-- phone number -->
                            <div class="line-form">
                                @if($current_page_user->user_verification_items->phone)
                                    <div class="m-5">
                                        <span>@lang($page . '.Phone Number')</span>
                                        <span class="f-right betP">@lang($page . '.Verified')</span>
                                    </div>
                                @else
                                <div class="m-5 line-height-25">
                                    <span>@lang($page . '.Phone Number')</span>
{{--                                    <span class="f-right point">5 point</span>--}}
                                    <span class="f-right"><a class="btn-trust" href="#">@lang($page . '.Add phone number')</a></span>
                                </div>
                                @endif
                            </div>
                            <!-- facebook -->
                            <div class="line-form">@if($current_page_user->user_verification_items->facebook)
                                    <div class="m-5">
                                        <span>@lang($page . '.Facebook')</span>
                                        <span class="f-right betP">@lang($page . '.Verified')</span>
                                    </div>
                                @else
                                <div class="m-5 line-height-25">
                                    <span>@lang($page . '.Facebook')</span>
{{--                                    <span class="f-right point">10 point</span>--}}
                                    <span class="f-right"><a class="btn-trust" href="#">@lang($page . '.Conect with facebook')</a></span>
                                </div>
                                @endif
                            </div>
                            <!-- verify -->
                            <div class="line-form">
                                @if($current_page_user->user_verification_items->identity)
                                    <div class="m-5">
                                        <span>@lang($page . '.Identity')</span>
                                        <span class="f-right betP">@lang($page . '.Verified')</span>
                                    </div>
                                @else
                                <div class="m-5 line-height-25">
                                    <span>@lang($page . '.Identity')</span>
{{--                                    <span class="f-right point">35 point</span>--}}
                                    <span class="f-right"><a class="btn-trust" href="#">@lang($page . '.verify me')</a></span>
                                </div>
                                @endif
                            </div>
                            <!-- Authentication -->
                            <div class="line-form m-b-20 clearfix">
                                @if($current_page_user->user_verification_items->payment)
                                    <div class="m-5">
                                        <span>@lang($page . '.Payment')</span>
                                        <span class="f-right betP">@lang($page . '.Verified')</span>
                                    </div>
                                @else
                                <div class="m-5 line-height-25">
                                    <span>@lang($page . '.Payment')</span>
{{--                                    <span class="f-right point">45 point</span>--}}
                                    <span class="f-right"><a class="btn-trust" href="#">@lang($page . '.verify me')</a></span>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <!--=========== Start Account content ================-->
                    <div role="tabpanel" class="tab-pane @if($tab == 'Account') active @endif" id="Account">
                        <form action="{{ url("/profile/edit/account") }}" method="post">
                            {{ csrf_field() }}
                            <div class="title-content">
                                <h4>@lang($page . '.Account')</h4>
                            </div>
    {{--                        <div class="line-form row">
                                <span>Directory and follow setting</span>
                                <div class="name">
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>@lang($page . '.List me on the Freelancer directory, allowing Employers to hire me directly for projects')</label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group no-gutter">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-3">
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-9">
                                            <label>Allow freelancer to allow me, notifying them of projects and contest the project</label>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                            <!-- acount type -->
                            <div class="line-form">
                                <b>@lang($page . '.Account Type')</b>
                                <div class="col-md-12 m-b-30">
                                    <!-- button toggle -->
                                    <div class="f-right">
                                        <div class="switcher">
                                            <input type="radio" name="account_type" id="tab_employer"
                                                   class="switcher__input switcher__input--yin" value="2" data-name="employer" @if($current_page_user->user->roleid == 2)checked @endif>
                                            <label for="tab_employer" class="switcher__label">@lang('faq.employer')</label>

                                            <input type="radio" name="account_type" id="tab_freelancer"
                                                   class="switcher__input switcher__input--yang" value="3" data-name="freelancer" @if($current_page_user->user->roleid == 3)checked @endif>
                                            <label for="tab_freelancer" class="switcher__label">@lang('faq.freelancer')</label>

                                            <span class="switcher__toggle"></span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success saveSetting">@lang($page . '.save setting')</button>
                                </div>
                            </div>
                        </form>
                        <div class="line-form display-block clearfix">
                            <div class="form-group">
                                <form action="{{ url("/profile/avatar/") }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <b>@lang($page.'.avatar')</b>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                                @lang($page.'.Browse')
                                                <input type="file" name="avatar" id="avatar" accept="image/*" class="imgInp">
                                            </span>
                                        </span>
                                        <input class="form-control url" readonly="readonly" type="text" value="@if($current_page_user->profile_img){{ $current_page_user->profile_img->path }}@endif">
                                    </div>
                                    @if($current_page_user->profile_img)
                                        <div class="col-md-3 pull-right p-t-10">
                                            <a href="{{ asset($current_page_user->profile_img->path) }}"><img class="img-responsive" src="{{ asset($current_page_user->profile_img->path) }}" alt="avatar" title="avatar"></a>
                                        </div>
                                    @endif
                                    <div class="form-group m-t-15">
                                        <button type="submit" class="btn btn-success saveSetting">@lang($page . '.upload')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="line-form display-block clearfix">
                            <div class="form-group">
                                <form action="{{ url("/profile/cover/") }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <b>@lang($page.'.cover')</b>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                                @lang($page.'.Browse')
                                                <input type="file" name="cover" id="cover" accept="image/*" class="imgInp">
                                            </span>
                                        </span>
                                        <input class="form-control url" readonly="readonly" type="text" value="@if($current_page_user->banner_img){{ $current_page_user->profile_img->path }}@endif">
                                    </div>
                                    @if($current_page_user->banner_img)
                                        <div class="col-md-3 pull-right p-t-10">
                                            <a href="{{ asset($current_page_user->banner_img->path) }}"><img class="img-responsive" src="{{ asset($current_page_user->banner_img->path) }}" alt="cover" title="cover"></a>
                                        </div>
                                    @endif
                                    <div class="form-group m-t-15">
                                        <button type="submit" class="btn btn-success saveSetting">@lang($page . '.upload')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection
@section('script-extend')
    <script src="{{ asset('assets/timepicker/bootstrap-datepicker.js') }}"></script>
{{--    <script
        src="https://www.paypal.com/sdk/js?client-id=AXbcYhd-NThUW2FtTmCF-eGA_IWhIdvooxYaMRJZR1co6q80kQzsFdzqnHxU9x8A4qyfSGn5sozh6Sw8"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
    </script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '1.01'
                        }
                    }]
                });
            }
        }).render('#paypal-button-container');
    </script>--}}
    <script>
        /* datepicker */
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        /* start input upload */
        $(document).on('change', '.btn-file :file', function () {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function (event, label) {
            var input = $(this).parents('.input-group').find(':text'),
                log = label;
            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }
        });

        $(".imgInp").change(function () {
            var inputElement = this;
            if (this.multiple) {
                $(this.files).each(function (key, value) {
                    var input_name = 'multi-img-upload' + key;
//                        console.log(input_name, document.querySelectorAll("." + input_name).length);
                    /* check exist input_name element and create*/
                    if (document.querySelectorAll("." + input_name).length == 0) {
                        $("#multiple_file").after('<img class="img-upload ' + input_name + '" src="">');
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('.' + input_name).attr('src', e.target.result);
                        }
                        reader.readAsDataURL(value);
                    }
                });
            } else {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var _id = '#img-' + inputElement.id;
                        $(_id).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            }
        });
        /* end input upload */

        $(document).ready(function () {
            $('.switcher__input').click(function () {
                $(this).attr('checked', 'true');
                if($(this).attr('data-name') == "employer")
                    $('#tab_freelancer').removeAttr('checked');
                else
                    $('#tab_employer').removeAttr('checked');
            });
        });
    </script>
@endsection
