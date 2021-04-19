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
                            <a href="{{ url('/') }}"><img class="" src="images/logo.png" alt="logo monofreelancer"></a>
                        </div>

                        <div class="mt-3 mb-2">
                            <span class="h5 font-weight-bold font_tunga">@lang($page.'.Sign Up')</span>
                        </div>

                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="email" type="email" class="font_tunga  form-control @error('email') is-invalid @enderror" placeholder=" @lang($page.'.E-Mail Address') " name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password" type="password" class="font_tunga  form-control @error('password') is-invalid @enderror" placeholder=" @lang($page.'.Password')" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control font_tunga " placeholder=" @lang($page.'.Confirm Password')" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-success form-control font_tunga ">
                                    @lang($page.'.Register')
                                </button>
                            </div>
                        </form>

                        <div class="form-group row mt-4">
                            <div class="col-md-12 text-center">

                                <small class="align-content-md-center font_tunga ">@lang($page.'.Already have an account?') <a href="{{ route('login') }}" class="">@lang($page.'.Log In')</a></small>

                            </div>
                        </div>

                        <div class="or-seperator"><i> @lang($page.'.or') </i></div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-fb form-control font_tunga"><i class="fa fa-facebook-f pr-1"></i> <b>@lang($page.'.Continue with Facebook')</b></a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <a href="{{ url('/auth/redirect/google') }}" class="btn btn-danger form-control font_tunga"><i class="fa fa-google pr-1 h5"></i> <b>@lang($page.'.Continue with Google')</b></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
