@extends('layouts.app')

{{--section header--}}
@section('header')
    {{-- css include--}}
@endsection

@section('content')
    @php
        $page = "site";
    @endphp

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">

                        <div>
                            <img class="" src="{{asset('/images/favicon.png')}}" alt="logo freelancer">
                        </div>

                        <div class="mt-3 mb-2">
                            <span class="h5 font-weight-bold font_tunga_signup">@lang($page.'.Select account type')</span>
                        </div>

                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">

                                <p><strong class="font_tunga text-dark_ali">@lang($page.'.Don’t worry, this can be changed later.')</strong></p>
                                <a href="{{route('developer')}}" class="text-decoration-none text-dark">
                                    <div class="col-md-12 display-flex align-items-center shadow-me h-50 mt-3">
                                        <div class="col-md-4"><img class="w-100" src="{{asset('/images/user_work.png')}}"></div>
                                        <div class="col-md-6"><strong class="display-5">@lang($page.'.I want to work')</strong></div>
                                        <div class="col-md-2"><strong class="fa fa-arrow-right"></strong></div>
                                    </div>
                                </a>

                                <a href="{{route('employer')}}" class="text-decoration-none text-dark">
                                    <div class="col-md-12 display-flex align-items-center shadow-me mt-2 h-50">
                                        <div class="col-md-4"><img class="w-100" src="{{asset('/images/user_hire.png')}}"></div>
                                        <div class="col-md-6"><strong class="display-5 note-color">@lang($page.'.I want to hire')</strong></div>
                                        <div class="col-md-2"><strong class="fa fa-arrow-right"></strong></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <br/>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

