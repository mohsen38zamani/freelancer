@section('css-extend')
    <link href="{{ asset('assets/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/sweet-alert/sweet-alert.min.css') }}" type="text/css" rel="stylesheet"/>
@endsection
@extends('site.mainpage')
@section('page_content')
    @if($permission)
        @php
            $page = \Request::segment(1);
            $page_action = \Request::segment(2);
             if(\Request::segment(3)){
                 $item_id = \Request::segment(3);
             }

        @endphp
        @section('page-title') {{ ucfirst($page_action) . ' ' .$page }} @endsection
    <div class="container post-page">
        <div class="logo-des">
            <!-- title -->
            <div class="title-PostPage display-inline-block">
                <h1>
                    @lang($page . '.portfolio Upload')
                </h1>
            </div>
            @if ($page_action == 'edit' && isset($item_id))
            <a href="{{ url("/$page/delete/$item_id") }}" class="btn btn-danger pull-right line-height2-5">@lang($page . '.delete portfolio')</a>
            @endif
        </div>
        <div class="main-post-page">
            <form action="{{ url($action) }}" method="post" name="portfolio_form" enctype="multipart/form-data">
                {{ csrf_field() }}
                @if(isset($block_field['information']['portfolioid']))
                @php
                    $field_value = $block_field['information']['portfolioid'];
                    $field_key = "portfolioid";
                @endphp
                <input type="{{ $field_value['type'] }}" name="{{ $field_key }}"
                       id="{{ $field_key }}"
                       value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                >
                @endif
                <!-- section A  -->
                    @php
                        $field_value = $block_field['information']['name'];
                        $field_key = "name";
                     @endphp
                <div class="form-group">
                    <label for="nameOfProject">@lang($page.'.'.$field_key)</label>
                    {{------    text    ------}}
                    <input
                        type="{{ ($field_value['type'] == "date")? "text" : $field_value['type'] }}"
                        name="{{ $field_key }}" id="{{ $field_key }}"
                        value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                        class="form-control @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                        @if($field_value['required']) required @endif
                        @if($field_value['type'] == 'tel') maxlength="11"
                        placeholder="091xxx" @endif
                        @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                        @endif
                        @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                        @endif
                        @if($field_value['readonly']) readonly @endif
                        @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                    >
                </div>
                    @php

                        $field_value = $block_field['information']['description'];
                        $field_key = "description";
                    @endphp
                <div class="form-group">
                    <label for="AboutProject">@lang($page.'.'.$field_key)</label>
                    {{------    textarea    ------}}
                        <textarea name="{{ $field_key }}" id="{{ $field_key }}"
                        cols="10" rows="5"
                        class="form-control @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                        @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                        @endif
                        @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}"
                        @endif @if($field_value['readonly']) readonly @endif>@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif</textarea>
                </div>
                <!-- upload file -->
                @php
                    $field_value = $block_field['information']['attachment'];
                    $field_key = "attachment";
                @endphp
                <div class="upload-PostPage">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-success btn-file upload-portfolio">
                                @lang($page.'.Browse')
                                <input type="{{ $field_value['type'] }}"
                                       name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                       id="{{ $field_key }}"
                                       accept="{{ $field_value['upload_type'] }}/*"
                                       class="imgInp @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                       @if($field_value['readonly']) readonly @endif
                                       @if($field_value['required']) required @endif
                                       @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}"
                                       @endif
                                       @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                       @endif
                                       @if(isset($field_value['multiple']) && $field_value['multiple']) multiple @endif
                                >
                            </span>
                        </span>
                        <input class="form-control url" readonly="readonly" type="text">
                        <div class="text-upload-PstPage text-center">
                            <p class="p-lr-15 p-t-10">@lang($page . '.Select any images or documents that might be helpful in explaining your project brief here.')</p>
                        </div>
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
                            @if(!empty($field_value['value']))
                                <img class="img-upload" id="img-{{ $field_key }}"
                                     src=" {{ asset($field_value['value']) }}">
                                <div class="overlay">
                                    <a href="{{ url($field_value['value']) }}"
                                       target="_blank">
                                        <i class="fa fa-eye text-danger eye"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @php
                    $field_value = $block_field['information']['skill'];
                    $field_key = "skill";
                @endphp
                <!-- what skills -->
                <div class="skill-PostPage m-t-20">
                    <h3>Skills</h3>
                    <select
                        name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                        id="{{ $field_key }}"
                        class="m-t-5 @if(!isset($field_value['select2'])) select2 @else form-control @endif @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                        @if(isset($field_value['multiple']) && $field_value['multiple']) multiple
                        @endif
                        @if($field_value['readonly']) readonly @endif
                        @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
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
                </div>

                <!-- button -->
                <div class="btn-postProject m-t-20">
                    <button type="submit" class="btn btn-success saveSetting my-2">Save</button>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger m-t-90">
                    <span>You do not have permission to view this page</span>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('script-extend')
    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/sweet-alert/sweet-alert.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            jQuery(".select2").select2({
                width: '100%'
            });

            /* delete img */
            $(".img-trush").click(function () {
                var img_id = this.id;
                var url = $(".img-trush").data("url");
                swal({
                    title: "Are you sure you want to delete the data?",
                    text: "If you wish to delete and press the Yes button",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#4edd06",
                    confirmButtonText: "Yes",
                    closeOnConfirm: true
                }, function (isConfirm) {
                    if (Boolean(isConfirm)) {
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
                        if (Boolean(result)) {
                            $(".img-box-id" + img_id).remove();
                        } else {
                            console.log(result);
                            swal("Notice", 'Photos could not be found.', "error");
                        }
                    }
                });
            }

            /* start input upload */
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this), label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
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
        });

    </script>
@endsection
