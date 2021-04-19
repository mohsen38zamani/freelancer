@extends('layouts.panel')
@section('panelContent')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="pull-left page-title">Welcome !</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">MonoFreelancer</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </div>
    </div>
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                {{ session('success') }}
            </ul>
        </div>
    @endif
    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                {{ session('error') }}
            </ul>
        </div>
    @endif
<!-- Start Widget -->
    <div class="row">
        @foreach($block_info as $key => $item)
            @if(in_array(Auth::user()->roleid, $item['access']))
                <a href=@if($key == 'dashboard') "#" @else {{ url("/$key/list") }} @endif>
                    <div class="f-right col-md-6 col-sm-6 col-lg-3 {{ $key }}">
                        <div class="mini-stat clearfix bx-shadow">
                            <span class="mini-stat-icon bg-{{ $item['color'] }}"><i class="{{ $item['icon'] }}"></i></span>
                            <div class="mini-stat-info text-right text-muted">

                                <span class="counter" id="{{ $key }}">{{ (is_numeric($item['count'])) ? $item['count'] : '0' }}</span>
                                <b class="hidden">{{ $item['count'] }}</b>
                                <b>{{ $item['title'] }}</b>
                            </div>
                            <div class="tiles-progress">
                                <div class="m-t-20">
                                    {{--<h5 class="text-uppercase">مدیران(فعال)</h5>--}}
                                    <div class="progress progress-sm m-0">
                                        <div class="progress-bar progress-bar-{{ $item['color'] }}" role="progressbar"
                                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{ $item['percent'] }}%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endif
        @endforeach
    </div><!-- End row-->
    {{--<div class="row">
            <div class="col-lg-8">
                <div class="portlet"><!-- /portlet heading -->
                    <div class="portlet-heading">
                        <h3 class="portlet-title text-dark text-uppercase">
                            رزرو 3
                        </h3>
                        <div class="portlet-widgets">
                            <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                            <span class="divider"></span>
                            <a data-toggle="collapse" data-parent="#accordion1" href="#portlet3"><i
                                        class="ion-minus-round"></i></a>
                            <span class="divider"></span>
                            <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="portlet3" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="website-stats" style="position: relative;height: 320px;"></div>
                                    <div class="row text-center m-t-30">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /Portlet -->
            </div> <!-- end col -->
            <div class="col-lg-4">
                <div class="portlet"><!-- /portlet heading -->
                    <div class="portlet-heading">
                        <h3 class="portlet-title text-dark text-uppercase">
                            رزرو 2
                        </h3>
                        <div class="portlet-widgets">
                            <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                            <span class="divider"></span>
                            <a data-toggle="collapse" data-parent="#accordion1" href="#portlet1"><i
                                        class="ion-minus-round"></i></a>
                            <span class="divider"></span>
                            <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="portlet1" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="website-stats" style="position: relative;height: 320px;"></div>
                                    <div class="row text-center m-t-30">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /Portlet -->
            </div> <!-- end col -->
        </div>--}} <!-- End row -->
@endsection
@section('script-extend')
    <script>
        $(document).ready(function () {
            window.setTimeout( box_checker, 3000 ); // 2 seconds
        });

        function box_checker(){
            $('.counter').each(function() {
                $_id = '#' + this.id;
                if($($_id).text()){
                    var data = $('.' + this.id + ' b.hidden').text();
                    $($_id).text(data);
                }
            });
        }
    </script>
@endsection
