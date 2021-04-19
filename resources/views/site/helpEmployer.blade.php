<!--=========== BEGIN BanerTop ================-->
<div class="container ">
    <div class="how-works-area">
        <div class="how-works">
            <!-- Tab panes -->
            <div class="m-t-20 top_cont_outer_work">
                <div class="row">
                    <div class="col-lg-5 col-sm-7">
                        <div class="top_left_cont_work zoomIn wow animated">
                            <h2 class="h2_work">@lang($page.'.What kind of work can I get done?')  </h2>
                            <p class="h2_work">@lang($page.'.How does "anything you want" sound? We have experts representing every technical, professional, and creative field.')  </p>
                            <a href="{{route('postProject_New')}}" class="read_more3 m-t-30">@lang($page.'.Post a Project')</a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-5">
                        <img src="{{asset('/images/map-72359494.png')}}" class="zoomIn wow animated img-responsive" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=========== END BanerTop ================-->


<!--=========== BEGIN OUR JOB ================-->
<section id="service">
    <div class="container mt_5">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="service-area">
                    <!-- Start Service Title -->
                    <div class="section-heading">
                        <h4 class="text-dark">@lang($page.'.Just give us the details about the work you need completed, and our freelancers will get it done faster, better, and cheaper than you could possibly imagine. This includes:') </h4>
                        <div class="line"></div>
                    </div>
                    <!-- Start Service Content -->
                    <div class="service-content">
                        <div class="row">
                            <!-- Start Single Service -->
                            <div class="col-lg-4 col-md-4">
                                <div class="single-service">
                                    <div class="service-icon">
                                        <span class="fa fa-laptop service-icon-effect"></span>
                                    </div>
                                    <h4 class="display-inline-block w-75">@lang($page.'.Small jobs, large jobs, anything in between') </h4>
                                </div>
                            </div>
                            <!-- Start Single Service -->
                            <div class="col-lg-4 col-md-4">
                                <div class="single-service">
                                    <div class="service-icon">
                                        <span class="fa fa-clock-o service-icon-effect"></span>
                                    </div>
                                    <h4 class="display-inline-block w-75"> @lang($page.'.Jobs that are on fixed price, or hourly terms')  </h4>
                                </div>
                            </div>
                            <!-- Start Single Service -->
                            <div class="col-lg-4 col-md-4">
                                <div class="single-service">
                                    <div class="service-icon">
                                        <span class="fa fa-tasks service-icon-effect"></span>
                                    </div>
                                    <h4 class="display-inline-block w-75">@lang($page.'.Work that requires specific skill sets, costs, or scheduling requirements.')</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=========== END OUR JOB ================-->


<!--=========== BEGAIN UL SECTION ================-->
<section id="whychooseSection_work">
    <div class="top_cont_outer">
        <div class="hero_wrapper">
            <div class="container">
                <div class="Section">
                    <div class="row">
                        <div class="col-lg-6 col-sm-8">
                            <div class="top_left_cont_work zoomIn wow animated">
                                <h2 class="m-b-20 text-light">@lang($page.'.How does it work?')</h2>
                                <h3 class="PageHowItWorks-howTo-title">@lang($page.".1. Post a project")</h3>
                                <ul class="ml_36 font_family">
                                    <li >@lang($page.".It's always free to post your project. You'll automatically")</li>
                                    <li>@lang($page.'.begin to receive bids from our freelancers. Alternatively, you') </li>
                                    <li>@lang($page.'.can browse through the talent available on our site, and') </li>
                                    <li>@lang($page.'.make a direct offer to a freelancer instead.')</li>
                                </ul>

                                <h3 class="PageHowItWorks-howTo-title">@lang($page.'.2.Choose the perfect freelancer')</h3>
                                <ul class="disc_li ml_36 font_family">
                                    <li>@lang($page.'.Browse freelancer profiles')</li>
                                    <li>@lang($page.'.Chat in real-time')</li>
                                    <li>@lang($page.'.Compare proposals and select the best one')</li>
                                    <li>@lang($page.'.Award your project and your freelancer goes to work')</li>
                                </ul>

                                <h3 class="PageHowItWorks-howTo-title">@lang($page.'.3.Pay when you are satisfied!')</h3>
                                <ul class="ml_36 font_family">
                                    <li>@lang($page.'.Pay safely using our Milestone Payment system -')</li>
                                    <li>@lang($page.'.release payments according to a schedule of goals')</li>
                                    <li>@lang($page.'.you set, or pay only upon completion. You are in')</li>
                                    <li>@lang($page.'.control, so you get to make decisions.')</li>
                                </ul>
                                <a href="{{route('postProject_New')}}" class="read_moreBaner m-t-30">@lang($page.'.Post a Project')</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-4 mt_5">
                            <img src="{{asset('/images/how-to-cf7641ca.png')}}" class="zoomIn wow animated img-responsive" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=========== END UL SECTION ================-->


<!--=========== BEGAIN START PROJECT ================-->
<section id="start-post-project">
    <div class="text-center p-all-15">
        <h3>@lang($page.'.So what are you waiting for?')</h3>
        <h4 class="m-t-20">@lang($page.'.Post a project today and get bids from talented freelancers.')</h4>
        <div class="display-inline-block"><a href="{{route('postProject_New')}}" class="read_more3 m-t-30">@lang($page.'.Post a Project')</a></div>
    </div>
</section>
<!--=========== END START PROJECT ================-->
