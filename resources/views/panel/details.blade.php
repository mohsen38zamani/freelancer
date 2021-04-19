@extends('layouts.panel')
@section('panelContent')
    @php $page = \Request::segment(1); $record_id = \Request::segment(3); @endphp
    @if($permission)
        <!-- Page-Title -->
        <div class="row m-b-20">
            <div class="col-md-12 d-right text-left">
                @if($permission['edit'])
                    <a href="/{{ $page }}/edit/{{ $record_id }}" class="btn btn-success save"><i
                            class="fa fa-pencil"></i> ویرایش</a>
                @endif
                <a href="/{{ $page }}/list" class="btn btn-danger"><i class="fa fa-mail-reply"></i> بازگشت</a>
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
                <form class="form-horizontal" name="form-{{ $page }}" id="form-{{ $page }}" action="{{ url($action) }}"
                      method="post" enctype="multipart/form-data">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>@lang($page.'.'.\Session::get('success'))</li>
                            </ul>
                        </div>
                    @endif
                    @foreach($block_field as $block_key => $block_value)
                        <div class="panel panel-primary">
                            <div class="panel-heading"> @lang($page.'.'.$block_key) </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    @foreach($block_value as $field_key => $field_value)
                                        <div class="col-md-6 pull-right">
                                            <div
                                                class="form-group{{ $errors->has($field_key) ? ' has-error' : '' }} height56">
                                                <div class="col-md-8">

                                                    {{--------    text    --------}}
                                                    @if(!in_array($field_value['type'], array('select', 'file', 'checkbox')))
                                                        <span
                                                            class="cl4">@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif</span>
                                                        {{------    file    ------}}
                                                    @elseif($field_value['type'] == 'file')
                                                        <div class="img-box">
                                                            <img class="img-upload"
                                                                 src="@if(!empty($field_value['value'])) {{ asset($field_value['value']) }} @endif">
                                                            <div class="overlay">
                                                                <a href="{{ asset($field_value['value']) }}"
                                                                   target="_blank">
                                                                    <i class="fa fa-eye text-danger eye"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        {{------    checkbox    ------}}
                                                    @elseif($field_value['type'] == 'checkbox')
                                                        <span class="cl4">@if($field_value['value']) بله @else
                                                                خیر @endif</span>

                                                        {{------    select    ------}}
                                                    @elseif($field_value['type'] == 'select')
                                                        <span class="cl4">
                                                        {{ $field_value['value'] }}
                                                    </span>
                                                    @endif

                                                    @if ($errors->has($field_key))
                                                        <span class="help-block">
                                                        <strong>
                                                            @php
                                                                $msg = str_replace('_', ' ', $field_key);
                                                                echo str_replace($msg, __($page.'.'.$field_key), $errors->first($field_key));
                                                            @endphp
                                                        </strong>
                                                            {{--{{ dd($errors) }}--}}
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="col-md-4 text-left">
                                                    <label for="{{ $field_key }}"> @lang($page.'.'.$field_key)</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>
            </div>
        </div><!-- End row-->
    @else
        <div class="alert alert-danger">
            <span>شما اجازه دسترسی به این صفحه ندارید</span>
        </div>
    @endif
@endsection
@section('script-extend')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
