@extends('index')

@section('body')
    <!--=========== BEGIN SLIDER ================-->
    <section id="sliderArea" class="mt-0">
        <!-- Start slider wrapper -->
        <div class="top-slider">
        @foreach($slider as $ObjectSlider)
            <!-- Start First slide -->
                <div class="top-slide-inner">
                    <div class="slider-img">
                        @if(isset($ObjectSlider->attachment) && $ObjectSlider->attachment->path)
                            <img class="img-responsive" src="{{$ObjectSlider->attachment->path}}" alt="{{$ObjectSlider->title}}">
                        @else
                            <img class="img-responsive" src="{{asset('/images/slider/S1.jpeg')}}" alt="{{$ObjectSlider->title}}">
                        @endif
                    </div>
                    <div class="slider-text">
                        <h2 class="text-{{$ObjectSlider->color}}">@lang('slider.'.$ObjectSlider->title)</h2>
                        <p class="text-{{$ObjectSlider->color}}"><strong>@lang('slider.'.$ObjectSlider->description)</strong></p>
                        @if($ObjectSlider->url)
                            <div class="readmore_area">
                                <a data-hover="Read More" href="#"><span>{{$ObjectSlider->urllable}}</span></a>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- End First slide -->
            @endforeach
        </div><!-- /top-slider -->
    </section>
    <!--=========== END SLIDER ================-->


    <!--=========== BEGIN Some skills  ================-->
    <div id="service" class="background_floralwhite">
        <div class="section">
            <div class="container">
                <div class="clients-logo-wrapper text-center row">
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/1.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/2.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/3.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/4.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/5.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/6.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/7.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/8.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/9.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/10.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/11.png') }}" alt="Client Name"></a></div>
                    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-6"><a href="#"><img class="w-100" src="{{ asset('/images/logos/12.png') }}" alt="Client Name"></a></div>
                </div>
            </div>
        </div>
    </div>
    <!--=========== End Some skills  ================-->

    <!--=========== BEGIN 3Box ================-->
    <section id="topFeature">
        <div class="row">
            <!-- Start Single Top Feature -->
            <div class="col-lg-4 col-md-4">
                <div class="row">
                    <div class="single-top-feature">
                        <span class="fa fa-check-square-o"></span>
                        <h3>@lang('site.Post a job')</h3>
                        <p>@lang("site.It's easy. Simply post a job you need completed and receive competitive bids from freelancers within minutes.")</p>
                    </div>
                </div>
            </div>
            <!-- End Single Top Feature -->

            <!-- Start Single Top Feature -->
            <div class="col-lg-4 col-md-4">
                <div class="row">
                    <div class="single-top-feature opening-hours">
                        <span class="fa fa-user"></span>
                        <h3>@lang('site.Choose freelancers')</h3>
                        <p>@lang('site.Whatever your needs, there will be a freelancer to get it done: from web design, mobile app development, and graphic design.')</p>
                    </div>
                </div>
            </div>
            <!-- End Single Top Feature -->

            <!-- Start Single Top Feature -->
            <div class="col-lg-4 col-md-4">
                <div class="row">
                    <div class="single-top-feature">
                        <span class="fa fa-credit-card"></span>
                        <h3>@lang('site.Pay safely')</h3>
                        <p>@lang('site.With secure payments and thousands of reviewed professionals to choose from, Freelancer.com is the simplest and safest way to get work done online.')</p>
                    </div>
                </div>
            </div>
            <!-- End Single Top Feature -->
        </div>
    </section>
    <!--=========== END 3Box ================-->

    <!--=========== BEGIN Crowd favorites ================-->

    <section id="portfolio">
        <div class="row col-md-8 col-md-offset-2 mt-h2">
            <div class="col full">
                <h2 class="mt-h2">@lang('site.Most favorite')</h2>
                <p class="desc">@lang('site.Here are some of our most popular projects:') </p>
            </div>
        </div>
        <div class="row col-md-8 col-md-offset-2">
            <!-- Portfolio Wrapper -->
            <div id="portfolio-wrapper">
                @foreach($Crowd_favorites as $list)
                    <div class="col portfolio-item">
                        <div class="item-wrap">
                            @if($list->attachment)
                                <a href="{{url($list->link)}}" data-reveal-id="{{'modal-'.$list->lv1skillid}}"><img class="img_portfolio" src="{{ asset($list->attachment->path) }}" alt="category_lavel1"/></a>
                            @else
                                <a href="{{url($list->link)}}" data-reveal-id="{{'modal-'.$list->lv1skillid}}"><img class="img_portfolio" src="{{ asset('/images/portfolio/default.png') }}" alt="category_lavel1"/></a>
                            @endif
                            <div class="portfolio-item-meta">
                                <h5><a href="{{url($list->link)}}">{{$list->name}}</a></h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> <!-- Portfolio Wrapper End -->
        </div> <!-- End Row -->

        <!-- Modal Popup
         =========================================================== -->
    @foreach($Crowd_favorites as $list)
        <!-- modal-01 -->
            <div id="{{'modal-'.$list->lv1skillid}}" class="reveal-modal">
                @if($list->attachment)
                    <img class="scale-with-grid" src="{{$list->attachment->path}}" alt="category_lavel1" />
                @else
                    <img class="scale-with-grid" src="{{ asset('/images/portfolio/default.png') }}" alt="category_lavel1" />
                @endif
                <div class="description-box">
                    <h4>{{$list->name}}</h4>
                </div>

                <div class="link-box">
                    <a href="{{url($list->link)}}" target="_blank">@lang('site.Details')</a>
                    <a class="close-reveal-modal">@lang('site.Close')</a>
                </div>

            </div><!-- modal-01 End -->
        @endforeach

    </section>

    <!--=========== END Crowd favorites ================-->

    <!--=========== BEGIN All Category Skills ================-->
    <section id="bottom">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <!-- Start Service Title -->
                <div class="section-heading">
                    <h2 class="text-dark">@lang('site.Browse top job categories')</h2>
                    <div class="line"></div>
                </div>
                <!-- Start Service Content -->

                @if (count($skill) >= 4)
                    @for($x = 0 ; $x < floor((count($skill) / 4))+1 ; $x++)
                        <div class="col-md-3 col-sm-6">
                            <div class="widget">
                                <ul class="ul_language">
                                    @for($y=$x*4 ; $y < 4*($x+1) ; $y++)
                                        @if($y == count($skill))
                                            <li><a href="{{ url('/skills') }}"><i class="fa fa-arrow-circle-right"></i> @lang('site.See All')</a></li>
                                        @endif
                                        @break($y == count($skill))
                                        <li><img src="{{ asset('/images/tick.png') }}" alt="img">
                                            @if($lang != $def_lang) @lang('skill.' . $skill[$y]->name) @else {{ $skill[$y]->name }} @endif
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                        </div><!--/.col-md-3-->
                    @endfor
                @else
                    <div class="col-md-3 col-sm-6">
                        <div class="widget">
                            <ul class="ul_language">
                                @for($y=0; $y < count($skill) ; $y++)
                                    <li><img src="{{ asset('/images/tick.png') }}" alt="img">
                                        @if($lang != $def_lang) @lang('skill.' . $skill[$y]->name) @else {{ $skill[$y]->name }} @endif
                                    </li>
                                    @if($y == count($skill)-1)
                                        <li><img src="{{ asset('/images/tick.png') }}" alt="img"><a href="#">@lang('site.See All')</a></li>
                                    @endif
                                    @break($y == count($skill)-1)
                                @endfor
                            </ul>
                        </div>
                    </div><!--/.col-md-3-->
                @endif

            </div>
        </div>
    </section><!--/#bottom-->
    <!--=========== END All Category Skills ================-->

    <!--=========== BEGAIN Banner1 ================-->
    <section id="hero_section" class="top_cont_outer mt_5">
        <div class="hero_wrapper">
            <div class="container">
                <div class="hero_section">
                    <div class="row">
                        <div class="col-lg-5 col-sm-7">
                            <div class="top_left_cont zoomIn wow animated">
                                <h2>@lang('site.Download the TWINT app now')</h2>
                                <h4 class="color_h5"> @lang('site.Online payments made easier') </h4>
                                <p>@lang('site.With TWINT, you can, for example, make online payments when shopping on the Internet – quickly and securely.') </p>
                                <a href="https://www.twint.ch/en/private-customers/functions/#payments" class="read_more2">@lang('site.Find out more')</a> </div>
                        </div>
                        <div class="col-lg-7 col-sm-5 mt-h2">
                            <img src="{{ asset('/images/main_device_image.png') }}" class="zoomIn wow animated img-responsive" alt="baner" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========== END Banner1 ================-->

    <!--=========== BEGAIN Banner2 ================-->
    <section id="aboutUs">
        <div class="inner_wrapper mt_5">
            <div class="container">
                <h2>@lang('site.FREELANCER ENTERPRISE')</h2>
                <h4 class="color_h5">@lang('site.Company budget? Get more done for less') </h4>
                <div class="inner_section">
                    <div class="row">
                        <div class=" col-lg-4 col-md-4 col-sm-4 col-xs-12 pull-right"><img src="{{ asset('/images/about-img.jpg') }}" class="img-circle delay-03s animated wow zoomIn" alt=""></div>
                        <div class=" col-lg-7 col-md-7 col-sm-7 col-xs-12 pull-left">
                            <div class=" delay-01s animated fadeInDown wow animated">
                                <h3>@lang('site.Use our workforce of 39 million to help your business achieve more.')</h3><br/>
                                <p>@lang("site.Access a global workforce of over 39.8 million freelancers to turn your organization's ideas into reality at scale, faster and for a fraction of the price.")</p> <br/>
                                <h4> @lang('site.Freelancer Enterprise enables companies to get more done for less') </h4>
                                <p>@lang('site.Whether you need a team of virtual software engineers or a skilled tradesperson in your local area, choose from freelancers with over 1,000 different skill sets who have been pre-vetted and approved according to success criteria defined by you.')</p> <br/>
                            </div>
                            <a href="{{url('/contact')}}" class="read_more3">@lang('site.Contact us')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========== END Banner2 ================-->

@endsection

