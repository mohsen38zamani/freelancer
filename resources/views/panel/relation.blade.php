@extends('layouts.panel')
@section('panelContent')
    @php $page = \Request::segment(1); $record_id = \Request::segment(3); $relation = \Request::segment(4); @endphp
    @if($permission)
        <!-- Page-Title -->
        <div class="row m-b-20">
            <div class="col-md-12 d-right text-left">
                @if(isset($block_relation[$relation]['rel_type']))
                    @if($block_relation[$relation]['rel_type'] == 'ADD')
                        <a href="/{{ $relation }}/new" class="btn btn-success save"><i
                                class="fa fa-plus"></i> @lang($page . '.' . $relation) جدید</a>
                    @elseif($block_relation[$relation]['rel_type'] == 'SELECT')
                        <a href="" class="btn btn-success select" data-toggle="modal" data-target="#con-close-modal"><i
                                class="fa fa-list"></i><span> انتخاب @lang($page . '.' . $relation) </span></a>
                    @else
                        <a href="/{{ $relation }}/new" class="btn btn-success save"><i
                                class="fa fa-plus"></i> @lang($page . '.' . $relation) جدید</a>
                        <a href="" class="btn btn-success select" data-toggle="modal" data-target="#con-close-modal"><i
                                class="fa fa-list"></i><span> انتخاب @lang($page . '.' . $relation) </span></a>
                    @endif
                @endif
            </div>
        </div><!-- End row-->

        <!-- Start table -->
        <div class="row">
            <div class="col-md-2 dir-r">
                <div class="panel panel-primary">
                    <div class="panel-heading"> ارتباطات</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <ul>
                                @foreach($block_relation as $field_key => $field_value)
                                    <li class="p-all-5 rel_{{ $field_key }} li_rel"><a href="{{ $field_value['url'] }}"
                                                                                       class="cl2"> @lang($page.'.'.$field_key) @if($field_key != 'detail')
                                                ({{ $field_value['rel_count'] }}) @endif</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 dir-r">
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>@lang($page.'.'.\Session::get('success'))</li>
                        </ul>
                    </div>
                @endif
                @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>@lang($page.'.'.\Session::get('error'))</li>
                        </ul>
                    </div>
                @endif
                <div class="panel panel-primary">
                    <div class="panel-heading"> @lang($page.'.'.$relation) </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <table width="100%" class="table table-bordered" id="dataTables-example">
                                <thead>
                                <tr>
                                    @php
                                        $label = $block_relation[$relation]['value']['label'];
                                        $data = $block_relation[$relation]['value']['data'];
                                    @endphp
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
                                    @if(!$item->delete){{-- if is not deleted --}}
                                    @php $id = $label[0]; @endphp
                                    <tr>
                                        @foreach($label as $value)
                                            @if($value == 'active')
                                                <td>@if($item->$value == '1') @lang($page.'.Yes') @else @lang($page.'.No') @endif</td>
                                            @elseif($value == 'created_at' || $value == 'updated_at')
                                                <td>{{\Morilog\Jalali\CalendarUtils::strftime('H:i:s Y-m-d', strtotime($item->$value))}}</td>
                                            @else
                                                <td>{{$item->$value}}</td>
                                            @endif
                                        @endforeach
                                        @if($details)
                                            <td>
                                                <a href="/{{ $relation }}/details/{{ $item->$id }}"><i
                                                        class="fa fa-eye"></i></a>&nbsp;

                                                @if($block_relation[$relation]['rel_type'] == 'SELECT')
                                                    <a href="/{{$page}}/relation/{{ $record_id }}/{{ $item->$id }}"><i
                                                            class="fa fa-trash"></i></a>
                                                @endif
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
        </div><!-- End row-->
        <!-- ============================================================== -->
        <!-- Start Modal select table -->
        <!-- ============================================================== -->
        @if(isset($_rel))
            <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">فهرست @lang($page . '.' . $relation) ها</h4>
                        </div>
                        <table width="100%" class="table table-bordered" id="dataTables-example">
                            <thead>
                            <tr>
                                @php
                                    $label = $_rel['label'];
                                    $data = $_rel['data'];
                                @endphp
                                @foreach($label as $item)
                                    <th class="text-center">@lang($page.'.'.$item)</th>
                                @endforeach
                                <th class="text-center">@lang($page.'.details')</th>
                            </tr>
                            </thead>
                            <tbody id="t_body">
                            @foreach($data as $item)
                                @if(!$item->delete){{-- if is not deleted --}}
                                @php $id = $label[0]; @endphp
                                <tr style="cursor:pointer" onClick="myclick({{ $item->$id }})" id="{{ $item->$id }}">
                                    @foreach($label as $value)
                                        @if($value == 'active')
                                            <td>@if($item->$value == '1') @lang($page.'.Yes') @else @lang($page.'.No') @endif</td>
                                        @elseif($value == 'created_at' || $value == 'updated_at')
                                            <td>{{\Morilog\Jalali\CalendarUtils::strftime('H:i:s Y-m-d', strtotime($item->$value))}}</td>
                                        @else
                                            <td>{{$item->$value}}</td>
                                        @endif
                                    @endforeach
                                    <td><a href="/{{ $relation }}/details/{{ $item->$id }}"><i
                                                class="fa fa-eye"></i></a></td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <form id="frm_rel" action="{{ url("/$page/relation") }}" method="post">
                            <input type="hidden" name="{{ $page }}" value="{{ $record_id }}">
                            <input type="hidden" name="url"
                                   value="/{{ $page }}/details/{{ $record_id }}/{{ $relation }}">
                            <input id="in_{{ $relation }}" type="hidden" name="{{ $relation }}">
                        </form>
                        <div class="modal-footer">
                            <button type="button" id="btn_select" class="btn btn-info waves-effect waves-light"> تایید
                            </button>
                            <button type="button" id="btn_cancel" class="btn btn-default waves-effect"
                                    data-dismiss="modal"> لغو
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->
        @endif
        <!-- ============================================================== -->
        <!-- End Modal select table -->
        <!-- ============================================================== -->
    @else
        <div class="alert alert-danger">
            <span>شما اجازه دسترسی به این صفحه ندارید</span>
        </div>
    @endif
@endsection
@section('script-extend')
    <script>
        $(document).ready(function () {
            $('#btn_select').click(function () {
                $("#frm_rel").submit();
            });
        });

        var rowcode = 0;
        var rel_input = "in_{{ $relation }}";

        function myclick(_id) {
            if (rowcode != 0) {
                $('#' + rowcode).addClass('text-muted');
                $('#' + rowcode).addClass('white-bg');
                $('#' + rowcode).removeClass('bg-primary');
                $('#' + rowcode).removeClass('text-white');
            }
            rowcode = _id;
            $("#" + rel_input).val(_id);
            $('#' + _id).removeClass('text-muted');
            $('#' + _id).removeClass('white-bg');
            $('#' + _id).addClass('bg-primary');
            $('#' + _id).addClass('text-white');
        }
    </script>
@endsection
