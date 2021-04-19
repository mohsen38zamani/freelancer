@extends('layouts.panel')
@section('panelContent')
    @php $page = \Request::segment(1); $customfields = \Request::segment(3); @endphp
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
        <div class="row m-b-20">
            <div class="col-md-12 d-right text-left">
                <h4 class="pull-right page-title @php if(isset($menu['main_menu'][$page]['color'])) echo 'text-' . $menu['main_menu'][$page]['color']; @endphp">
                    فهرست @lang($page.'.'.$page) ها </h4>
                @if($permission['new'] && $customfields)
                    <a href="{{ url("/$page/new") }}" class="btn btn-default btn-add"><i class="fa fa-plus"></i> افزودن</a>
                @endif
                @if($permission['edit'])
                    <a class="btn btn-default" id="btn_edit" disabled><i class="fa fa-pencil"></i> ویرایش</a>
                @endif
                @if($permission['delete'])
                    <button type="button" class="btn btn-default" id="btn_del" disabled><i class="fa fa-trash"></i> حذف
                    </button>
                @endif
            </div>
        </div><!-- End row-->

        <!-- Start table -->
        <div class="row">
            <div class="col-md-12 d-right text-right bg0 panel-shadow p-t-10">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    @foreach($block_field as $field_key => $field_value)
                        <div class="col-md-10">
                            {{------    select    ------}}
                            @if($field_value['type'] == 'select')
                                <select
                                    name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                    id="{{ $field_key }}"
                                    class="@if(!isset($field_value['select2'])) select2 @else form-control @endif"
                                    @if(isset($field_value['multiple']) && $field_value['multiple']) multiple @endif
                                    @if($field_value['readonly']) readonly @endif
                                >
                                    @foreach($field_value['option'] as $option_value => $option_label)
                                        @if(isset($field_value['multiple']) && $field_value['multiple'])
                                            <option value="{{ $option_value }}"
                                                    @if(in_array($option_value, $field_value['value'])) selected @endif>
                                                @if($field_value['translate']) @lang($page.'.'.$option_label) @else {{ $option_label }} @endif
                                            </option>
                                        @else
                                            <option value="{{ $option_value }}"
                                                    @if($field_value['value'] == $option_value) selected @endif>
                                                @if($field_value['translate']) @lang($page.'.'.$option_label) @else {{ $option_label }} @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-md-2 text-left">
                            <label for="{{ $field_key }}"> @lang($page.'.'.$field_key) @if($field_value['required'])
                                    <b class="text-danger">*</b> @endif
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <br>
            <div class="col-md-12 d-right text-right bg0 panel-shadow p-t-10">
                <table width="100%" class="table table-bordered" id="dataTables-example">
                    <thead>
                    <tr>
                        @foreach($label as $item)
                            <th class="text-center">@lang($page.'.'.$item)</th>
                        @endforeach
                        @if($details)
                            <th class="text-center">@lang($page.'.details')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody id="t_body">
                    @foreach($data as $item)
                        @php $id = $label[0]; @endphp
                        <tr style="cursor:pointer" onClick="myclick({{ $item->$id }})" id="{{ $item->$id }}">
                            @foreach($label as $value)
                                @if($value == 'active')
                                    <td>@if($item->$value == '1') @lang($page.'.Yes') @else @lang($page.'.No') @endif</td>
                                @elseif($value == 'created_at' || $value == 'updated_at' || $value == 'attendance_date')
                                    <td>{{\Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($item->$value))}}</td>
                                @elseif($value == 'date')
                                    <td>{{\Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($item->$value))}}</td>
                                @else
                                    <td>{{$item->$value}}</td>
                                @endif
                            @endforeach
                            @if($details)
                                <td><a href="{{ url("/$page/details/$item->$id") }}"><i class="fa fa-eye cl11"></i></a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- End row-->
    @else
        <div class="alert alert-danger">
            <span>شما اجازه دسترسی به این صفحه ندارید</span>
        </div>
    @endif

@endsection
@section('script-extend')
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true,
                order: [[0, "desc"]]
            });
        });

        $('.btn-add').click(function () {
            var id = $('#tabid').val();
            $('.btn-add').attr('href', $('.btn-add').attr('href') + '/' + id)
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
                $('#btn_edit').removeAttr('disabled');
                var tabid = $('#tabid').val();
                $('#btn_edit').attr("href", "/{{ $page }}/edit/" + id + '/' + tabid);
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

        $('#tabid').on('change', function () {
            window.location.replace('{{ url("/$page/list/") }}' + $('#tabid').val());
        });

        $('#btn_del').click(function () {
            swal({
                title: "آیا از حذف داده ها اطمینان دارید؟",
                text: "!با حذف داده ها امکان بازگرداندن آن ها وجود ندارد",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4edd06",
                confirmButtonText: "بلی",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    var tabid = $('#tabid').val();
                    window.location.replace('{{ url("/$page/delete/") }}' + arr_action + '/' + tabid);
                }
            });
        });
    </script>
@endsection
