@extends('layouts.panel')
@section('panelContent')
    @php
        $page = \Request::segment(1);
        $page_action = \Request::segment(2);
         if(\Request::segment(3)){
             $item_id = \Request::segment(3);
         }
    @endphp
    @if($permission && $permission[$page_action])
        <!-- Page-Title -->
        <div class="row m-b-20 btn_panel">
            <div class="col-md-12 d-right text-left">
                <div class="col-md-8">
                    @if($page_action == 'edit')
                        <h4 class="page-title @php if(isset($menu['main_menu'][$page]['color'])) echo 'text-' . $menu['main_menu'][$page]['color']; @endphp">Edit @lang($page.'.'.$page) </h4>
                    @else
                        <h4 class="page-title @php if(isset($menu['main_menu'][$page]['color'])) echo 'text-' . $menu['main_menu'][$page]['color']; @endphp">Insert new @lang($page.'.'.$page) </h4>
                    @endif
                </div>
                <div class="col-md-4 text-right">
                    <button class="btn btn-success save" type="button"><i class="fa fa-save"></i> Save</button>
                    <a href="{{ url("/dashboard") }}" class="btn btn-danger"><i class="fa fa-times"></i> Return to dashboard</a>
                </div>
            </div>
        </div><!-- End row-->
        <!-- Start table -->
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" name="form-{{ $page }}" id="form-{{ $page }}" action="{{ url($action) }}"
                      method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
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
                    @foreach($block_field as $block_key => $block_value)
                        <div class="panel panel-primary {{ $block_key }}">
                            <div class="panel-heading"> @lang($page.'.'.$block_key) </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    @foreach($block_value as $field_key => $field_value)
                                        {{--------    hidden    --------}}
                                        @if($field_value['type'] == 'hidden')
                                            <input type="{{ $field_value['type'] }}" name="{{ $field_key }}"
                                                   id="{{ $field_key }}"
                                                   value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                   class="form-control @if($field_value['type'] == 'date') date-picker @endif"
                                                   @if($field_value['required']) required @endif
                                                   @if($field_value['type'] == 'tel') maxlength="11"
                                                   placeholder="091xxx" @endif
                                                   @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                   @endif
                                                   @if($field_value['readonly']) readonly @endif
                                            >
                                            @continue
                                        @endif
                                        <div class="col-md-6 div-{{ $field_key }}">
                                            <div class="form-group{{ $errors->has($field_key) ? ' has-error' : '' }} height56">
                                                @if($field_value['type'] != 'button')
                                                    <div class="col-md-4 text-left">
                                                        <label
                                                            for="{{ $field_key }}"> @lang($page.'.'.$field_key) @if($field_value['required'])
                                                                <b class="text-danger">*</b> @endif</label>
                                                    </div>
                                                @endif
                                                <div class="col-md-8">

                                                    {{--------    text    --------}}
                                                    @if(!in_array($field_value['type'], array('select', 'textarea', 'file', 'checkbox', 'date', 'time', 'number', 'hidden', 'button', 'currency', 'tags')))
                                                        <input
                                                            type="{{ ($field_value['type'] == "date")? "text" : $field_value['type'] }}"
                                                            name="{{ $field_key }}" id="{{ $field_key }}"
                                                            value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                            class="form-control"
                                                            @if($field_value['required']) required @endif
                                                            @if($field_value['type'] == 'tel') maxlength="11"
                                                            placeholder="091xxx" @endif
                                                            @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                            @endif
                                                            @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                                            @endif
                                                            @if($field_value['readonly']) readonly @endif
                                                        >

                                                        {{--------    button    --------}}
                                                    @elseif($field_value['type'] == 'button')
                                                        <input type="{{ $field_value['type'] }}" name="{{ $field_key }}"
                                                               id="{{ $field_key }}"
                                                               value="@if($field_value['translate']) @lang($page.'.'.$field_value['value']) @else {{ $field_value['value'] }} @endif"
                                                               class="{{ $field_value['class'] }}"
                                                               @if($field_value['readonly']) readonly @endif
                                                        >

                                                        {{--------    number    --------}}
                                                    @elseif($field_value['type'] == 'number')
                                                        <div class='input-group date'>
                                                            <div class="spinner-number">
                                                                <div class="input-group" style="width:150px;">
                                                                    <div class="spinner-buttons input-group-btn">
                                                                        <button type="button"
                                                                                class="btn spinner-up btn-purple waves-effect waves-light">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                    <input
                                                                        type="{{ ($field_value['type'] == "number")? "text" : $field_value['type'] }}"
                                                                        name="{{ $field_key }}" id="{{ $field_key }}"
                                                                        value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                                        class="form-control spinner-input"
                                                                        autocomplete="off"
                                                                        @if($field_value['required']) required @endif
                                                                        @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                                        @endif
                                                                        @if($field_value['readonly']) readonly @endif
                                                                    >
                                                                    <div class="spinner-buttons input-group-btn">
                                                                        <button type="button"
                                                                                class="btn spinner-down btn-pink waves-effect waves-light">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{--------    tags    --------}}
                                                    @elseif($field_value['type'] == 'tags')
                                                        <div class='input-group col-md-12'>
                                                            <input name="{{ $field_key }}" id="{{ $field_key }}"
                                                                   value="@if(empty(old($field_key))){{ ($field_value['value']) }}@else{{ (old($field_key)) }}@endif"
                                                                   class="form-control tags"
                                                                   @if($field_value['required']) required @endif
                                                                   @if($field_value['readonly']) readonly @endif
                                                            >
                                                        </div>

                                                        {{--------    currency    --------}}
                                                    @elseif($field_value['type'] == 'currency')
                                                        <div class='input-group'>
                                                            <input type="text" name="{{ $field_key }}"
                                                                   id="{{ $field_key }}"
                                                                   value="@if(empty(old($field_key))){{ floatval($field_value['value']) }}@else{{ floatval(old($field_key)) }}@endif"
                                                                   autocomplete="off"
                                                                   class="form-control currency"
                                                                   @if($field_value['required']) required @endif
                                                                   @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                                   @endif
                                                                   @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                                                   @endif
                                                                   @if($field_value['readonly']) readonly @endif
                                                            >
                                                            <span class="input-group-addon">$</span>
                                                        </div>

                                                        {{--------    date    --------}}
                                                    @elseif($field_value['type'] == 'date')
                                                        <div class='input-group date'>
                                                            <input type="{{ ($field_value['type'] == "date")? "text" : $field_value['type'] }}"
                                                                   value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                                   name="{{ $field_key }}" id="{{ $field_key }}"
                                                                   class="form-control datepicker @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                                                   autocomplete="off"
                                                                   @if($field_value['required']) required @endif
                                                                   @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                                   @endif
                                                                   @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                                                   @endif
                                                                   @if($field_value['readonly']) readonly @endif
                                                                   @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                                                                   placeholder="yyyy-mm-dd">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                        </div>

                                                        {{--------    time    --------}}
                                                    @elseif($field_value['type'] == 'time')
                                                        <div class="input-group m-b-15">
                                                            <div class="bootstrap-timepicker">
                                                                <input name="{{ $field_key }}" id="{{ $field_key }}"
                                                                       type="text"
                                                                       value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                                       class="form-control time-control"
                                                                       autocomplete="off"
                                                                       @if($field_value['required']) required @endif
                                                                       @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                                       @endif
                                                                       @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                                                       @endif
                                                                       @if($field_value['readonly']) readonly @endif
                                                                />
                                                            </div>
                                                            <span class="input-group-addon"><i
                                                                    class="glyphicon glyphicon-time"></i></span>
                                                        </div><!-- input-group -->

                                                        {{------    file    ------}}
                                                    @elseif($field_value['type'] == 'file')
                                                        <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <span class="btn btn-default btn-file">
                                                                @lang($page.'.Browse')…
                                                                <input type="{{ $field_value['type'] }}"
                                                                       name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                                                       id="{{ $field_key }}"
                                                                       accept="{{ $field_value['upload_type'] }}/*"
                                                                       class="imgInp"
                                                                       @if($field_value['readonly']) readonly @endif
                                                                       @if($field_value['required']) required @endif
                                                                       @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                                                       @endif
                                                                       @if(isset($field_value['multiple']) && $field_value['multiple']) multiple @endif
                                                                >
                                                            </span>
                                                        </span>
                                                            <input class="form-control url" readonly="readonly"
                                                                   type="text">
                                                        </div>
                                                        @if(isset($field_value['multiple']) && $field_value['multiple'])
                                                            <input type="hidden" id="multiple_file">
                                                            @if(!empty($field_value['value']))
                                                                @foreach($field_value['value'] as $file_id => $file_name)
                                                                    <div class="img-box img-box-id{{ $file_id }}">
                                                                        <img class="multi-img-uploaded{{ $file_id }}"
                                                                             src="@if(!empty($file_name)) {{ asset($file_name) }} @endif">
                                                                        <div class="overlay">
                                                                            <div class="img-trush" id="{{ $file_id }}"
                                                                                 data-url="{{ $field_value['multiple_delete_url'] }}">
                                                                                <i class="fa fa-trash text-danger trush-multi"></i>
                                                                            </div>
                                                                            <div class="">
                                                                                <a href="{{ url($file_name) }}"
                                                                                   target="_blank">
                                                                                    <i class="fa fa-eye text-danger eye-multi"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        @else
                                                            <div class="img-box">
                                                                <img class="img-upload" id="img-{{ $field_key }}"
                                                                     src="@if(!empty($field_value['value'])) {{ asset($field_value['value']) }} @endif">
                                                                <div class="overlay">
                                                                    <a href="{{ url($field_value['value']) }}"
                                                                       target="_blank">
                                                                        <i class="fa fa-eye text-danger eye"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        {{------    checkbox    ------}}
                                                    @elseif($field_value['type'] == 'checkbox')
                                                        <div class="checkbox checkbox-primary">
                                                            <input type="{{ $field_value['type'] }}"
                                                                   name="{{ $field_key }}" id="{{ $field_key }}"
                                                                   class="checkbox"
                                                                   @if($field_value['readonly']) readonly @endif
                                                                   @if($field_value['required']) required @endif
                                                                   @if($field_value['value']) checked @endif>
                                                            <label for="{{ $field_key }}"> </label>
                                                        </div>

                                                        {{------    select    ------}}
                                                    @elseif($field_value['type'] == 'select')
                                                        <select
                                                            name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                                            id="{{ $field_key }}"
                                                            class="@if(!isset($field_value['select2'])) select2 @else form-control @endif"
                                                            @if(isset($field_value['multiple']) && $field_value['multiple']) multiple
                                                            @endif
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

                                                        {{------    textarea    ------}}
                                                    @elseif($field_value['type'] == 'textarea')
                                                        <textarea name="{{ $field_key }}" id="{{ $field_key }}"
                                                                  class="form-control" cols="10" rows="1"
                                                                  @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                                                  @endif
                                                                  @if($field_value['readonly']) readonly @endif>@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif</textarea>
                                                    @endif

                                                    @if ($errors->has($field_key))
                                                        <span class="help-block">
                                                        <strong>
                                                            @php
                                                                $msg = str_replace('_', ' ', $field_key);
                                                                echo str_replace($msg, __($page.'.'.$field_key), $errors->first($field_key));
                                                            @endphp
                                                        </strong>
                                                    </span>
                                                    @endif
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
            {{--<div class="col-md-1"></div>--}}
        </div><!-- End row-->
    @else
        <div class="alert alert-danger">
            <span>شما اجازه دسترسی به این صفحه ندارید</span>
        </div>
    @endif
@endsection
@section('script-extend')
    <script src="{{ asset('assets/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/spinner/spinner.min.js') }}"></script>
    <script src="{{ asset('assets/timepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/tagsinput/jquery.tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            <!-- WYSIWYG Editor -->
            $('.summernote').summernote({
                height: 200,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true                 // set focus to editable area after initializing summernote
            });
            // Tags Input
            jQuery('.tags').tagsInput({width: '100%'});

            /* page scrolling */
            $(document).on('scroll', function () {
                if ($(window).scrollTop() > 100) {
                    $('.btn_panel').addClass('btn_panel_scroll');
                } else {
                    $('.btn_panel').removeClass('btn_panel_scroll');
                }
            });

            /* datepicker */
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });

            /* number input */
            $('.spinner-number').spinner({value: 0, step: 1, min: 0, max: '999999999999999'});

            /* time input */
            jQuery('.time-control').timepicker({showMeridian: false});

            /* submit form */
            $(".save").click(function () {
                $("#form-{{ $page }}").submit();
            });

            /* start currency */
            $('.currency').val(formatCurrency($('.currency').val()));
            $(document).on('keyup', '.currency', function () {
                var input = $(this).val();
                $(this).val(formatCurrency(input));
            });

            function formatCurrency(price) {
                if (price) {
                    var nStr = price.replace(new RegExp(',', 'g'), "")
                    nStr += '';
                    var x = nStr.split('.');
                    var x1 = x[0];
                    var x2 = x.length > 1 ? '.' + x[1] : '';
                    var rgx = /(\d+)(\d{3})/;
                    while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                    }
                    var response = x1 + x2;
                    return response;
                }
            }

            /* end currency */

            /* start input upload */
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {
                var input = $(this).parents('.input-group').find(':text'),
                    log = label;
                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }
            });

            $(".imgInp").change(function () {
                var inputElement = this;
                if (this.multiple) {
                    $(this.files).each(function (key, value) {
                        var input_name = 'multi-img-upload' + key;
//                        console.log(input_name, document.querySelectorAll("." + input_name).length);
                        /* check exist input_name element and create*/
                        if (document.querySelectorAll("." + input_name).length == 0) {
                            $("#multiple_file").after('<img class="img-upload ' + input_name + '" src="">');
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $('.' + input_name).attr('src', e.target.result);
                            }
                            reader.readAsDataURL(value);
                        }
                    });
                } else {
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var _id = '#img-' + inputElement.id;
                            $(_id).attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                }
            });
            /* end input upload */


            /* delete img */
            $(".img-trush").click(function () {
                var img_id = this.id;
                var url = $(".img-trush").data("url");
                swal({
                    title: "آیا از حذف داده ها اطمینان دارید؟",
                    text: "در صورت تمایل به حذف دکمه بلی را فشار دهید",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#4edd06",
                    confirmButtonText: "بلی",
                    closeOnConfirm: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        delete_mg(img_id, url);
                    }
                });
            });

            function delete_mg(img_id, url) {
                var formData = new FormData();
                var _val = "{{csrf_token()}}";
                formData.append('_token', _val);
                formData.append('id', img_id);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success: function (result) {
                        if (result == 'true') {
                            $(".img-box-id" + img_id).remove();
                        } else {
                            console.log(result);
                            swal("اخطار", 'عکس مورد نظر یافت نشد.', "error");
                        }
                    }
                });
            }
        });
    </script>
@endsection
