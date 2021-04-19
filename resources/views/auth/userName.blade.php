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
                            <img class="" src="images/favicon.png" alt="logo monofreelancer">
                        </div>

                        <div class="mt-3 mb-2">
                            <span class="h5 font-weight-bold font_tunga_signup">@lang($page.'.Choose a username')</span>
                        </div>

                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('validateUsername') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <p><strong class="font_tunga text-dark_ali">@lang($page.'.Please note that a username cannot be changed, once chosen.')</strong></p>
                                    <input id="username" type="text" class="font_tunga  form-control @error('username') is-invalid @enderror @error('userid') is-invalid @enderror" placeholder=" @lang($page.'.Username') " name="username" value="{{ old('username') }}" required autocomplete="username">


                                    @if($errors->has('userid'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>@lang($page.'.'.$errors->first('userid'))</strong>
                                            </span>
                                    @elseif($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                                 <strong>@lang($page.'.'.$errors->first('username'))</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary form-control font_tunga ">
                                    @lang($page.'.Next')
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

