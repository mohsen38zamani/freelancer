@extends('site.mainpage')
@section('page_content')
    @php
        $page_address = \Request::segment(1);
        $page = 'user_profile';

    @endphp
    @if($current_page_user->name || $current_page_user->family)
        @section('page-title'){{ $current_page_user->name . ' ' . $current_page_user->family }} @endsection
    @else
        @section('page-title') {{ ucfirst($page_address)}} @endsection
    @endif
    <div class="container-profile">
        <div class="image-back-profile">
            <img class="img-responsive" src="@if(isset($current_page_user->banner_img->path) && $current_page_user->banner_img->path){{ asset($current_page_user->banner_img->path) }}@else{{ asset('images/3156482.jpg') }} @endif" alt="user banner">
            <div class="opasity-back"></div>
        </div>
    </div>

    <!-- main profile -->
    <div class="container">
        <section id="main-container-profile">
            <div class="row">
                <div class="top-profile">
                    <!-- section left -->
                    <div class="col-12 col-md-4 col-sm-4">
                        <div class="left-profile">
                            <!-- circle img -->
                            <div class="img-person">
                                <img src="@if(isset($current_page_user->profile_img->path) && $current_page_user->profile_img->path){{ asset($current_page_user->profile_img->path) }}@else{{ asset('/images/50x50.jpg') }} @endif"
                                     alt="orginal user profile picture" title="orginal user profile picture">
                                <div class="color-person"></div>
                            </div>
                            <!-- content -->
                            <div class="content-left-profile">
                                <span>
                                    @if($current_page_user->name || $current_page_user->family)
                                        <strong>{{ $current_page_user->name . ' ' . $current_page_user->family }}</strong>
                                    @else
                                        <strong>{{ $current_page_user->user->email }}</strong>
                                    @endif
                                </span>
                                <div class="social-media">
                                    <span class="Icon">
                                        <span class="fa fa-facebook @if($current_page_user->user_verification_items->facebook)Icon-image-verified @else Icon-image @endif"></span>
                                    </span>
                                    <span class="Icon">
                                        <span class="fa fa-envelope @if($current_page_user->user_verification_items->email)Icon-image-verified @else Icon-image @endif"></span>
                                    </span>
                                    <span class="Icon">
                                        <span class="fa fa-user @if($current_page_user->user_verification_items->identity)Icon-image-verified @else Icon-image @endif"></span>
                                    </span>
                                    <span class="Icon">
                                        <span class="fa fa-phone @if($current_page_user->user_verification_items->phone)Icon-image-verified @else Icon-image @endif"></span>
                                    </span>
                                    <span class="Icon">
                                        <span class="fa fa-credit-card @if($current_page_user->user_verification_items->payment)Icon-image-verified @else Icon-image @endif"></span>
                                    </span>
                                </div>
                                <!-- flag & country -->
                                <div class="flag">
                                    @if (isset($current_page_user->country->attachment))
                                        <div class="m-b-10">
                                            <img alt="Flag of country" src="{{ asset($current_page_user->country->attachment->path) }}" title="{{ $current_page_user->country->name }}" class="flag-country img-responsive" aria-label="{{ $current_page_user->country->name }}">
                                        </div>
                                    @endif
                                    <span class="locality" itemprop="addressLocality">{{ $current_page_user->country->mainland->name }} / {{ $current_page_user->country->name }}({{ $current_page_user->country->timezone }})</span>
                                </div>
                                <!-- membership -->
                                <div class="profile-membership-length m-t-20">
                                    <p>Member since {{ date('l jS \of F Y h:i:s A', strtotime($current_page_user->created_at)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- section right -->
                    <div class="col-12 col-md-8 col-sm-8">
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
                        <div class="right-profile">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="name-profile">
                                        <div class="text-name">
                                            @if($current_page_user->username)
                                                <h1>{{ '@'. $current_page_user->username }}</h1>
                                            @else
                                                <h1>{{ $current_page_user->user->email }}</h1>
                                            @endif
                                        </div>

                                        <!-- light online -->
                                            <div class="main-online">
                                                @if($current_page_user_isOnline)
                                                    <div class="text-online">
                                                        <strong>ONLINE</strong>
                                                    </div>
                                                    <div class="light-online"></div>
                                                @else
                                                    <div class="text-online">
                                                        <strong>OFFLINE</strong>
                                                    </div>
                                                    <div class="light-offline"></div>
                                                @endif
                                            </div>
                                        <div class="text-about-user">
                                            <p>@if($current_page_user->description) {{ $current_page_user->description }} @endif</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="edit-profile">
                                        <div class="top-edit">
                                            @if($authenticatied)
                                            <div class="m-b-10">
                                                <a class="btn btn-success saveSetting-profile line-height2-5" href="{{ url("/profile/$current_page_user->username/edit") }}">@lang($page . '.Edit Profile')</a>
                                            </div>
                                            @elseif ($current_user)
                                                <div class="m-b-10">
                                                    <a class="btn btn-success saveSetting-profile line-height2-5" href="{{ url("/chats?id=$current_page_user->userid") }}">@lang($page . '.message to') {{ $current_page_user->name . ' ' . $current_page_user->family }}</a>
                                                </div>
                                            @endif
                                            <div>
                                                <strong class="">${{ $current_page_user->hourly_rate_value }}</strong>
                                                <span> USD/hr</span>
                                            </div>
                                            <div>
                                                <span class="number">0.0 </span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                                <span><span>0</span> reviews</span>
                                            </div>
                                            <div>
                                                <span class="number">0.0 </span>
                                                <span class="fas fa-square-full"></span>
                                                <span class="fas fa-square-full"></span>
                                                <span class="fas fa-square-full"></span>
                                                <span class="fas fa-square-full"></span>
                                                <span class="fas fa-square-full"></span>
                                                <span><span>0</span> reviews</span>
                                            </div>
                                        </div>
                                        <div>
                                            <ul class="item-stats">
                                                <li>
                                                    <span class="item-stats-value">N/A</span><span
                                                        class="item-stats-name">Jobs
                                                        Completed</span>
                                                </li>
                                                <li>
                                                    <span class="item-stats-value">N/A</span><span
                                                        class="item-stats-name">On
                                                        Budget</span>
                                                </li>
                                                <li>
                                                    <span class="item-stats-value">N/A</span><span
                                                        class="item-stats-name">On
                                                        Time</span>
                                                </li>
                                                <li>
                                                    <span class="item-stats-value">N/A</span><span
                                                        class="item-stats-name">Repeat Hire Rate</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- profile -->
                <div class="col-12 col-md-12">
                    <div class="profile">
                        <div class="top-div-profile">
                            <h2 class="title-profile line-height2-5">@lang($page . '.Portfolios')</h2>
                            @if($authenticatied)
                                <button type="button" class="btn btn-success saveSetting" onclick="window.location.href = '{{ url("/portfolio/new") }}';">+ @lang($page . '.Add item')</button>
                            @endif
                        </div>
                        <div class="contact-profile">
                            @if (count($portfolio))
                                <div class="row">
                                    <div class="col-md-12">
                                    @foreach($portfolio as $key => $item)
                                        @if ($key < 3)
                                        <div class="col-md-3 portfolio-box">
                                            <a href="@if($authenticatied){{ url("/portfolio/edit/") }}@else{{ url("/portfolio/view/") }}@endif/{{ $item->portfolioid }}" class="">{{--display-inline-block user_profile_img--}}
                                                <img src="@if(isset($item->attachment) && $item->attachment->path){{ asset($item->attachment->path) }}@else{{ asset('/images/question.jpg') }} @endif"
                                                     class="img-responsive portfolio-image" alt="portfolio picture" title="{{ $item->name }}">
                                                <div class="">
                                                    <span class="portfolio-image-text">{{ $item->name }}</span>
                                                </div>
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-md-3 portfolio-box">
                                            <a href="{{ url("/portfolio/$current_page_user->username/list") }}" class="">
                                                <img src="{{ asset('/images/002A-500x500.png') }}" class="img-responsive portfolio-image" alt="Portfolio list" title="Portfolio list">
                                            </a>
                                        </div>
                                        @endif
                                    @endforeach
                                        @if (count($portfolio) < 3)
                                            <div class="col-md-3 portfolio-box">
                                                <a href="{{ url("/portfolio/new") }}" class="">
                                                    <img src="{{ asset('/images/002B-500x500.png') }}" class="img-responsive portfolio-image" alt="add portfolio" title="Add portfolio">
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="text-center">
                                    <div class="display-inline-block user_profile_img">
                                        <img src="{{ asset('/images/portfolio.png') }}" class="img-responsive display-inline-block" alt="portfolio picture" title="portfolio">
                                    </div>
                                    @if($authenticatied)
                                        <span>@lang($page . '.You dont have any portfolio.') <a href="{{ url("/portfolio/new") }}">@lang($page . '.Click to add a new portfolio!')</a></span>
                                    @else
                                        <span>@lang($page . '.Nothing to display')</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="col-12 col-md-8">
                    <div class="col-md12">
                        <!-- Recent -->
{{--                        <div class="recent">
                            <div class="top-div-profile">
                                @php $panel = 'Recent Reviews'; @endphp
                                <h2 class="title-profile">@lang($page . '.' . $panel)</h2>
                            </div>
                            <div>
                                <p>@lang($page . ".No $panel Added")</p>
                            </div>
                        </div>--}}
                        <!-- Experience -->
                        @if(count($current_page_user->job_experience) || $authenticatied)
                        <div class="recent">
                            <div class="top-div-profile">
                                @php $panel = 'Job Experience'; @endphp
                                <h2 class="title-profile">@lang($page . '.' . $panel)</h2>
                                @if($authenticatied)<a href="{{ url("/job_experience/new") }}" class="btn btn-success line-height2-5">+ @lang($page . '.' . $panel)</a>@endif
                            </div>
                            <div>
                                @if(!$current_page_user->job_experience)
                                <p>@lang($page . ".No $panel Added")</p>
                                @else
                                    @foreach($current_page_user->job_experience as $item)
                                        <div class="profile-block-items">
                                            @if($authenticatied)
                                                <p class="pull-right"><a href="{{ url("/job_experience/edit/$item->job_experienceid") }}" class="fa fa-pencil"></a> &nbsp; <a href="/job_experience/delete/{{ $item->job_experienceid }}" class="fa fa-trash"></a></p>
                                            @endif
                                            <strong>{{ $item->title }}</strong>
                                            <br>
                                            <span>{{ $item->company }}</span>
                                            @if($item->currently_working_here == 'on')
                                                <span>{{ date('Y-m-d', strtotime($item->startdate)) }}</span> <span>to Now</span>
                                            @else
                                                <span>{{ date('Y-m-d', strtotime($item->startdate)) }}</span> - <span>{{ date('Y-m-d', strtotime($item->enddate)) }}</span>
                                            @endif
                                            <br>
                                            <p class="p-t-10">{{ $item->description }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        @endif
                        <!-- Education -->
                        @if(count($current_page_user->education) || $authenticatied)
                        <div class="recent">
                            <div class="top-div-profile">
                                @php $panel = 'Education'; @endphp
                                <h2 class="title-profile">@lang($page . '.' . $panel)</h2>
                                @if($authenticatied)<a href="{{ url("/education/new") }}" class="btn btn-success line-height2-5">+ @lang($page . '.' . $panel)</a>@endif
                            </div>
                            <div>
                                @if(!$current_page_user->education)
                                    <p>@lang($page . ".No $panel Added")</p>
                                @else
                                    @foreach($current_page_user->education as $item)
                                        <div class="profile-block-items">
                                            @if($authenticatied)
                                            <p class="pull-right"><a href="{{ url("/education/edit/$item->educationid") }}" class="fa fa-pencil"></a> &nbsp; <a href="{{ url("/education/delete/$item->educationid") }}" class="fa fa-trash"></a></p>
                                            @endif
                                                <strong>{{ $item->degree }}</strong>
                                            <br>
                                            <span>{{ $item->university }}</span> <span>@if(isset($item->country->name)){{ $item->country->name }}@endif</span>
                                                <span>{{ $item->startyear }}</span> - <span>{{ $item->endyear }}</span>
                                            <br>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @endif
                        <!-- Qualifications -->
                        @if(count($current_page_user->qualification) || $authenticatied)
                        <div class="recent">
                            <div class="top-div-profile">
                                @php $panel = 'Qualifications'; @endphp
                                <h2 class="title-profile">@lang($page . '.' . $panel)</h2>
                                @if($authenticatied)<a href="{{ url("/qualification/new") }}" class="btn btn-success line-height2-5">+ @lang($page . '.' . $panel)</a>@endif
                            </div>
                            <div>
                                @if(!$current_page_user->qualification)
                                    <p>@lang($page . ".No $panel Added")</p>
                                @else
                                    @foreach($current_page_user->qualification as $item)
                                        <div class="profile-block-items">
                                            @if($authenticatied)
                                                <p class="pull-right"><a href="{{ url("/qualification/edit/$item->qualificationid") }}" class="fa fa-pencil"></a> &nbsp; <a href="{{ url("/qualification/delete/$item->qualificationid") }}" class="fa fa-trash"></a></p>
                                            @endif
                                            <strong>{{ $item->name }} ({{ $item->year }})</strong>
                                            <br>
                                            <span>{{ $item->organization }}</span>
                                            <br>
                                            <p class="p-t-10">{{ $item->description }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @endif
                        <!-- Publications -->
                        @if(count($current_page_user->publication) || $authenticatied)
                        <div class="recent">
                            <div class="top-div-profile">
                                @php $panel = 'Publications'; @endphp
                                <h2 class="title-profile">@lang($page . '.' . $panel)</h2>
                                @if($authenticatied)<a href="{{ url("/publication/new") }}" class="btn btn-success line-height2-5">+ @lang($page . '.' . $panel)</a>@endif
                            </div>
                            <div>
                                @if(!$current_page_user->publication)
                                    <p>@lang($page . ".No $panel Added")</p>
                                @else
                                    @foreach($current_page_user->publication as $item)
                                        <div class="profile-block-items">
                                            @if($authenticatied)
                                                <p class="pull-right"><a href="{{ url("/publication/edit/$item->publicationid") }}" class="fa fa-pencil"></a> &nbsp; <a href="{{ url("/publication/delete/$item->publicationid") }}" class="fa fa-trash"></a></p>
                                            @endif
                                            <strong>{{ $item->title }}</strong>
                                            <br>
                                            <span>{{ $item->publisher }}</span>
                                            <br>
                                            <p class="p-t-10">{{ $item->description }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>



                <div class="col-12 col-md-4">
                    <!-- certification -->
{{--                    <div class="certification">
                        <div class="top-div-profile">
                            <h2 class="title-profile">Certification</h2>
                            <button type="button" class="btn btn-success saveSetting">Get Certified</button>
                        </div>
                        <p>You do not any certification</p>
                    </div>--}}

                    <!-- Verifi -->
                    <div class="Verifi">
                        <h2 class="title-profile">@lang($page . '.Verifications')</h2>
                        <ul class="list-group">
                            <li class="list-group-item"><i class="fa fa-facebook @if($current_page_user->user_verification_items->facebook)Icon-image-verified @endif"></i> @lang($page . ".Facebook Connected") @if(!$current_page_user->user_verification_items->facebook)<span>@if($authenticatied)<a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">verify</a> @endif</span> @endif</li>
                            <li class="list-group-item"><i class="fa fa-credit-card @if($current_page_user->user_verification_items->payment)Icon-image-verified @endif"></i> @lang($page . ".Payment Verified") @if(!$current_page_user->user_verification_items->payment)<span>@if($authenticatied)<a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">verify</a> @endif</span> @endif</li>
                            <li class="list-group-item"><i class="fa fa-phone @if($current_page_user->user_verification_items->phone)Icon-image-verified @endif"></i> @lang($page . ".Phone Verified") @if(!$current_page_user->user_verification_items->phone)<span>@if($authenticatied)<a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">verify</a> @endif</span> @endif</li>
                            <li class="list-group-item"><i class="fa fa-user @if($current_page_user->user_verification_items->identity)Icon-image-verified @endif"></i> @lang($page . ".Identity Verified") @if(!$current_page_user->user_verification_items->identity)<span>@if($authenticatied)<a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">verify</a> @endif</span> @endif</li>
                            <li class="list-group-item"><i class="fa fa-envelope @if($current_page_user->user_verification_items->email)Icon-image-verified @endif"></i> @lang($page . ".Email Verified") @if(!$current_page_user->user_verification_items->email)<span>@if($authenticatied) <a href="{{url('/profile/'.$current_page_user->username.'/edit?Trust')}}" class="btn-list">verify</a> @endif</span> @endif</li>
                        </ul>
                    </div>
                    <!-- Browse -->
                    <div class="browse">
                        <div class="top-div-profile">
                            <h2 class="title-profile">@lang($page . '.My Top Skills')</h2>
                        </div>
                        <div>
                            @if(isset($current_page_user->freelancerinfo->skill_freelancer))
                                @foreach($current_page_user->freelancerinfo->skill_freelancer as $item)
                                    @if(isset($item->skill))
                                        <a href="#" class="btn-list">@lang($page . '.' . $item->skill->name)</a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
@section('script-extend')
<script>
    $(document).ready(function () {
        $('.saveSetting-profile').click(function () {

        });
    });
</script>
@endsection
