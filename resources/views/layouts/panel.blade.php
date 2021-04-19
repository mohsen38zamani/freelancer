@php $page = \Request::segment(1); $action = \Request::segment(2); $current_user = Auth::user()->id; @endphp
    <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <link href="{{ asset('images/favicon.png') }}" rel="icon">

    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('assets/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet"/>
    <!-- Styles -->
    <!-- Base Css Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Icons -->
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/ionicon/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/material-design-iconic-font.min.css') }}" rel="stylesheet">
    <!-- animate css -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">

    <!-- Waves-effect -->
    <link href="{{ asset('css/waves-effect.css') }}" rel="stylesheet"/>
    <!-- sweet alerts -->
    <link href="{{ asset('assets/sweet-alert/sweet-alert.min.css') }}" type="text/css" rel="stylesheet"/>
    <!-- Custom Files -->
    <link href="{{ asset('css/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/panel.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]> <![endif]-->
{{--    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>--}}
{{--    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>--}}

<!-- Dropzone css -->
    <link href="{{ asset('assets/dropzone/dropzone.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('assets/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/jquery-multi-select/multi-select.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/toggles/toggles.css') }}" rel="stylesheet">
    <!-- Custom Files -->
    <link href="{{ asset('css/orginalGamaweb.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gama.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/tagsinput/jquery.tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/timepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

    <!-- Responsive-table -->
    <link href="{{ asset('assets/responsive-table/rwd-table.min.css') }}" rel="stylesheet" />

    <!-- DataTablesCSS -->
    <link href="{{ asset('assets/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('assets/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">

    <!-- WYSIWYG Editor -->
    <link href="{{ asset('assets/summernote/summernote.css') }}" rel="stylesheet" />

    <script src="{{ asset('js/modernizr.min.js') }}"></script>

</head>


<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">
        <!-- LOGO -->
        <div class="topbar-left">
            <div class="text-center">
                <a href={{ url("/dashboard") }} class="logo">
                    <strong class="text-bluedark">
                        <img class="width20percent" src="{{ asset("images/logo-panel.png") }}" alt="{{ config('app.name') }}">
                    </strong>
                </a>
            </div>
        </div>
        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="">
                    <div class="pull-left">
                        <button class="button-menu-mobile open-left">
                            <i class="fa fa-bars"></i>
                        </button>
                        <span class="clearfix"></span>
                    </div>
                    <form class="navbar-form pull-left" role="search">
                        <div class="form-group">
{{--                            <input type="text" class="form-control search-bar" placeholder="Type here for search...">--}}
                        </div>
{{--                        <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>--}}
                    </form>

                    <ul class="nav navbar-nav navbar-right pull-right">
                        <li class="hidden-xs">
                            <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i
                                    class="md md-crop-free"></i></a>
                        </li>
                        <li class="hidden-xs">
                            <a href="#" class="right-bar-toggle waves-effect waves-light"><i class="md md-chat"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src={{ asset("/images/avatar.png") }} alt="user-img" class="img-circle"> </a>
                            <ul class="dropdown-menu">
                                <li><a href="" data-toggle="modal" data-target="#con-close-modal"><i class="md md-vpn-key"></i> Change Password</a></li>
                                <!--/ <li><a href={{ url("/company_info/edit") }}><i class="md md-settings"></i> Settings</a></li> -->
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="md md-settings-power"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none"> {{ csrf_field() }} </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div>

    <!-- Top Bar End -->
    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">
            <!--- Divider -->
            <div id="sidebar-menu">
                <ul>
                    @foreach($menu['main_menu'] as $key => $value)
                        @if($value['tabid'])
                            <li class="">
                                <a href="{{ url($value['href']) }}"
                                   class="waves-effect @if($page == $value['name']) active @endif text-white">
                                    @if($value['icon-type'] == 'icon')
                                        <i class="{{ $value['icon-name'] }} text-{{ $value['color'] }}"></i>
                                    @else
                                        @php $image_name = $value['icon-name']; @endphp
                                        <img src="{{ asset("images/$image_name") }}" alt="{{ $value['name'] }}">
                                    @endif
                                    <span> @lang('panel.'.$value['name']) </span>
                                </a>
                            </li>
                        @else
                            <li class="has_sub {{ $value['name'] }}">
                                <a href="#" class="waves-effect text-white">
                                    <div class="col-md-2 p-all-0 m-all-0"><span class="pull-right"><i class="md md-add"></i></span></div>
                                    <div class="col-md-10 p-all-0 m-all-0">
                                        @if($value['icon-type'] == 'icon')
                                            <i class="{{ $value['icon-name'] }} text-{{ $value['color'] }}"></i>
                                        @else
                                            @php $image_name = $value['icon-name']; @endphp
                                            <img src="{{ asset("images/$image_name") }}" alt="{{ $value['name'] }}">
                                        @endif
                                        <span> @lang('panel.'.$value['name']) </span>
                                    </div>
                                </a>
                                <ul class="list-unstyled">
                                    @foreach($value['item_menu'] as $sub_key => $sub_value)
                                        @if($sub_value['tabid'])
                                            <li class="{{ $sub_value['name'] }} @if($page == $sub_value['name']) active @endif">
                                                <a href="{{ url($sub_value['href']) }}"
                                                   class="waves-effect @if($page == $sub_value['name']) active @endif text-white">
                                                    @if($sub_value['icon-type'] == 'icon')
                                                        <i class="{{ $sub_value['icon-name'] }} text-{{ $sub_value['color'] }}"></i>
                                                    @else
                                                        @php $image_name = $sub_value['icon-name']; @endphp
                                                        <img src="{{ asset("images/$image_name") }}"
                                                             alt="{{ $value['name']  }}">
                                                    @endif
                                                    <span> @lang('panel.'.$sub_value['name']) </span>
                                                </a>
                                            </li>
                                        @else
                                            {{--<a class="waves-effect"><i class="md ion-android-storage"></i><span>آرشیو</span><span class="pull-left"><i class="md md-add"></i></span></a>--}}
                                            <a href="#" class="waves-effect text-white">
                                                <div class="col-md-2 p-all-0 m-all-0"><span class="pull-right"><i
                                                            class="md md-add"></i></span></div>
                                                <div class="col-md-10 p-all-0 m-all-0">
                                                    @if($sub_value['icon-type'] == 'icon')
                                                        <i class="{{ $sub_value['icon-name'] }} text-{{ $sub_value['color'] }}"></i>
                                                    @else
                                                        @php $image_name = $sub_value['icon-name']; @endphp
                                                        <img src="{{ asset("images/$image_name") }}"
                                                             alt="{{ $value['name'] }}">
                                                    @endif
                                                    <span> @lang('panel.'.$sub_value['name']) </span>
                                                </div>
                                            </a>
                                            <ul class="">
                                                @foreach($sub_value['item_menu'] as $sub_key2 => $sub_value2)
                                                    <li class="@if($page == $sub_value2['name']) active @endif">
                                                        <a href="{{ url($sub_value2['href']) }}"
                                                           class="waves-effect @if($page == $sub_value2['name']) active @endif text-white">
                                                            @if($sub_value2['icon-type'] == 'icon')
                                                                <i class="{{ $sub_value2['icon-name'] }} text-{{ $sub_value2['color'] }}"></i>
                                                            @else
                                                                @php $image_name = $sub_value2['icon-name']; @endphp
                                                                <img src="{{ asset("images/$image_name") }}"
                                                                     alt="{{ $value['name']  }}">
                                                            @endif
                                                            <span> @lang('panel.'.$sub_value2['name']) </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Left Sidebar End -->


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
            @yield('panelContent')
            <!-- ============================================================== -->
                <!-- Start Modal change password -->
                <!-- ============================================================== -->
                <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Change Password</h4>
                            </div>
                            <form name="frm_change_password" id="frm_change_password">
                                <input type="hidden" name="current_user" value="{{ $current_user }}">
                                <div class="modal-body">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="current_password" class="control-label">Current password</label>
                                                <input type="password" class="form-control" name="current_password" id="current_password">
                                            </div>
                                            <span class="help-block text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="new_password" class="control-label">New password</label>
                                                <input type="password" class="form-control" name="new_password" id="new_password">
                                            </div>
                                            <span class="help-block-2 text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="new_password_confirmation" class="control-label">Confirm Password</label>
                                                <input type="password" class="form-control"
                                                       name="new_password_confirmation" id="new_password_confirmation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="btn_change_password"
                                            class="btn btn-info waves-effect waves-light"> Submit
                                    </button>
                                    <button type="button" id="btn_cancel" class="btn btn-default waves-effect"
                                            data-dismiss="modal"> Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal -->


            </div> <!-- container -->

        </div> <!-- content -->

        <footer class="footer text-right">
            2019 © {{ config('app.name') }}
        </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->


    <!-- Right Sidebar -->
    <div class="side-bar right-bar nicescroll">
        <h4 class="text-center">Chat</h4>
        <div class="contact-list nicescroll">
            <ul class="list-group contacts-list">
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Chadengle</span>
                        <i class="fa fa-circle online"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Tomaslau</span>
                        <i class="fa fa-circle online"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Stillnotdavid</span>
                        <i class="fa fa-circle online"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Kurafire</span>
                        <i class="fa fa-circle online"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Shahedk</span>
                        <i class="fa fa-circle away"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Adhamdannaway</span>
                        <i class="fa fa-circle away"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Ok</span>
                        <i class="fa fa-circle away"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Arashasghari</span>
                        <i class="fa fa-circle offline"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Joshaustin</span>
                        <i class="fa fa-circle offline"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
                <li class="list-group-item">
                    <a href="#">
                        <div class="avatar">
                            <img src="" alt="">
                        </div>
                        <span class="name">Sortino</span>
                        <i class="fa fa-circle offline"></i>
                    </a>
                    <span class="clearfix"></span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Right-bar -->

</div>
<!-- END wrapper -->


@php $address = 'setting'; @endphp
<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('js/wow.min.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('assets/chat/moment-2.2.1.js') }}"></script>
<script src="{{ asset('assets/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/jquery-detectmobile/detect.js') }}"></script>
<script src="{{ asset('assets/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('assets/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/jquery-blockui/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/select2/select2.min.js') }}"></script>
<!-- Counter-up -->
<script src="{{ asset('assets/counterup/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/counterup/jquery.counterup.min.js') }}"></script>
<!-- CUSTOM JS -->
<script src="{{ asset('js/jquery.app.js') }}"></script>
<!-- Dashboard -->
{{--<script src="{{ asset('js/jquery.dashboard.js') }}"></script>--}}

<!-- Chat -->
<script src="{{ asset('js/jquery.chat.js') }}"></script>

<!-- DataTables JavaScript -->
<script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>

<!-- Page Specific JS Libraries -->
<script src="{{ asset('assets/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/sweet-alert/sweet-alert.min.js') }}"></script>
<script src="{{ asset('assets/sweet-alert/sweet-alert.init.js') }}"></script>
<script type="text/javascript">
    // Select2
    jQuery(".select2").select2({
        width: '100%'
    });
    var resizefunc = [];
    /* ==============================================
    Counter Up
    =============================================== */
    jQuery(document).ready(function ($) {
        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });
        /* ==============================================
            change password
            =============================================== */
        $("#btn_change_password").click(function () {
            if ($("#current_password").val() == '') $(".help-block").html("Enter your current password");
            else if ($("#new_password").val() == '' || $("#new_password_confirmation").val() == '') {
                $(".help-block-2").html("Enter a new password");
                $(".help-block").html("");
            } else if ($("#new_password").val().length < 6 || $("#new_password_confirmation").val().length < 6) {
                $(".help-block-2").html("New password should be more than 6 characters.");
                $(".help-block").html("");
            } else if ($("#new_password").val() != $("#new_password_confirmation").val()) {
                $(".help-block-2").html("New password and confirm the new password is not equal");
                $(".help-block").html("");
            } else {
                $(".help-block").html("");
                $(".help-block-2").html("");
                $.ajax({
                    type: "POST",
                    url: '{{ "/" . $address . "/change_password" }}',
                    data: $('#frm_change_password').serialize(),
                    success: function (result) {
                        if (result.success) {
                            swal("Notice", "Password changed", "success");
                            $("#btn_cancel").click();
                        } else {
                            $(".help-block").html("Current password is incorrect");
                        }
                    }
                });
            }
        })
    });
</script>
@yield('script-extend')
</body>
</html>
