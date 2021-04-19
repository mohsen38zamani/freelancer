@extends('layouts.panel')
@section('panelContent')
    @php $page = 'user_profile';//\Request::segment(1); @endphp
    @if (session('success'))
        <div class="alert alert-success">
            @lang($page . '.' . session('success'))
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            @lang($page . '.' . session('error'))
        </div>
    @endif
    @if($permission)
        <!-- Page-Title -->
{{--        <div class="row m-b-20">
            <div class="col-md-12">
                <div class="col-md-8 text-left">
                    <h4 class="page-title @php if(isset($menu['main_menu'][$page]['color'])) echo 'text-' . $menu['main_menu'][$page]['color']; @endphp">
                        @lang($page.'.'.$page) list</h4>
                </div>
                <div class="col-md-4 d-right text-right">
                    @if($permission['new'])
                        <a href="{{ url("/$page/new") }}" class="btn btn-default"><i class="fa fa-plus text-info"></i> Insert</a>
                    @endif
                    @if($permission['edit'])
                        <a class="btn btn-default" id="btn_edit" disabled><i class="fa fa-pencil text-warning"></i> Edit</a>
                    @endif
                    @if($permission['delete'])
                        <button type="button" class="btn btn-default" id="btn_del" disabled><i class="fa fa-trash text-danger"></i> Delete</button>
                    @endif
                </div>
            </div>
        </div>--}}<!-- End row-->

        <!-- Start table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-border panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body table-rep-plugin">
                        <div {{--class="table-responsive" data-pattern="priority-columns"--}}>
                            <table width="100%" id="tech-companies" class="table table-small-font table-bordered">
                                <thead>
                                <tr>
                                    @foreach($label as $key => $item)
                                        <th data-priority="{{ $key }}" class="text-center">@lang($page.'.'.$item)</th>
                                    @endforeach
                                    @if($details)
                                        <th class="text-center">details</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody id="t_body">
                                @foreach($data as $item)
                                    @if(!$item['delete']){{-- if is not deleted --}}
                                    @php $id = $label[0]; @endphp
                                    <tr style="cursor:pointer" onClick="myclick({{ $item->$id }})" id="{{ $item->$id }}">
                                        @foreach($label as $value)
                                            @if($value == 'active')
                                                <td>@if($item->$value == '1') @lang($page.'.Yes') @else @lang($page.'.No') @endif</td>
                                            @else
                                                <td>{{$item->$value}}</td>
                                            @endif
                                        @endforeach
                                        @if($details)
                                            <td><a href="{{ url("/$page/details/$item->$id") }}"><i class="fa fa-eye cl11"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    @else
        <div class="alert alert-danger">
            <span>You do not have permission to view this page</span>
        </div>
    @endif

@endsection
@section('script-extend')
    {{--<script src="{{ asset('assets/responsive-table/rwd-table.min.js') }}"></script>--}}

    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-detectmobile/detect.js') }}"></script>
    <script src="{{ asset('assets/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/fastclick/fastclick.js') }}"></script>
    <script src="{{ asset('assets/jquery-blockui/jquery.blockUI.js') }}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function () {
            $('#tech-companies').DataTable({
                responsive: true,
                order:[[0,"desc"]]
            });
        });
        //action Selected row in table
        var arr_action = '';

        function myclick(_id) {
            // check for add or remove class color td.
            if ($('#' + _id).hasClass('bg-primary')) {
                $('#' + _id).addClass('text-muted');
                $('#' + _id).addClass('white-bg');
                $('#' + _id).removeClass('bg-primary');
                $('#' + _id).removeClass('text-white');
                arr_action = arr_action.replace(_id + ',', "");
            } else {
                $('#' + _id).removeClass('text-muted');
                $('#' + _id).removeClass('white-bg');
                $('#' + _id).addClass('bg-primary');
                $('#' + _id).addClass('text-white');
                arr_action = _id + ',' + arr_action;
            }
            // check for enable and disable edit for "1" row select.
            var arr_length = arr_action.split(",");

            if (!arr_length[1] && arr_length != '') {
                var id = arr_action.replace(',', "");
                var _path = '{{ url("/$page/edit/") }}';
                $('#btn_edit').removeAttr('disabled');
                $('#btn_edit').attr("href", _path + "/" + id);
            } else {
                $('#btn_edit').attr("disabled", "disabled");
                $('#btn_edit').removeAttr('href');
            }

            // check for enable and disable button.
            if (arr_action.length > 0) {
                $('#btn_del').removeAttr('disabled');
            } else {
                arr_action = '';
                store_id = '';
                $('#btn_del').attr("disabled", "disabled");
                $('#btn_edit').attr("disabled", "disabled");
            }
        }

        $('#btn_del').click(function () {
            swal({
                title: "Are you sure you want to delete the data?",
                text: "With the deletion of data, there is no possibility to restore them",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4edd06",
                confirmButtonText: "OK",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    window.location.replace('/{{ $page }}/delete/' + arr_action);
                }
            });
        });
    </script>
@endsection
