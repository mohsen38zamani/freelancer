@extends('index')

@section('header')
    <link rel="stylesheet" href="{{asset('/css/orginalGamaweb.css')}}">
@endsection

@section('body')

    @if($permission)
        @php
            $page = "site";
            $page_action = \Request::segment(2);
             if(\Request::segment(3)){
                 $item_id = \Request::segment(3);
             }
        @endphp


        <section id="blogArchive" class="mt-0">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="blog-breadcrumbs-area">
                        <div class="container">
                            <div class="blog-breadcrumbs-left">
                                <h2>@lang($page.'.How it works')</h2>
                            </div>
                            <div class="blog-breadcrumbs-right">
                                <ol class="breadcrumb">
                                    <li>@lang($page.'.You are here')</li>
                                    <li><a href="#">@lang($page.'.')</a></li>
                                    <li class="active">@lang($page.'.How it works')</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="container">
            <div class="how-works-area">
                <div class="section-heading">
                    <h2 class="text-dark  m-t-30">@lang($page.'.How it work')</h2>
                    <div class="line"></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="how-works-area">
                <div class="how-works">
                    <ul class="nav nav-tabs display-block load-css" id="myTab">
                        <li class="active"><a href="#iwanttohire" data-toggle="tab" onclick="tab(1)">@lang($page.'.I want to hire')</a></li>
                        <li><a href="#iwanttowork" data-toggle="tab" onclick="tab(2)">@lang($page.'.I want to work')</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--=========== BEGIN TAB ================-->
        <div id="FormLoad1" >
            @include('site.helpEmployer')
        </div>

        <div id="FormLoad2" class="hidden">
            @include('site.helpFreelancer')
        </div>

        <!--=========== End TAB ================-->

    @else
        <div class="alert alert-danger m-t-150">
            <span>@lang($page.'.You do not have permission to view this page')</span>
        </div>
    @endif

@endsection



@section('script')
    <!-- Page Specific JS Libraries -->
    <script src="{{ asset('/assets/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('/assets/sweet-alert/sweet-alert.min.js') }}"></script>
    <script src="{{ asset('/assets/sweet-alert/sweet-alert.init.js') }}"></script>

    <script type="text/javascript">

        function tab(id) {
            if(parseInt(id) == 1){
                $('#FormLoad2').addClass('hidden');
                $('#FormLoad1').removeClass('hidden');
            }

            if(parseInt(id) == 2){
                $('#FormLoad1').addClass('hidden');
                $('#FormLoad2').removeClass('hidden');
            }
        }
    </script>


    @if(isset($_REQUEST['result']) && $_REQUEST['result'] == '200')
        <script>
            swal("Notice", "@lang($page.'.Your message was sent.')", "success");
        </script>
    @endif
@endsection
