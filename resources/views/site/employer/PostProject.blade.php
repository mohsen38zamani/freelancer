@extends('layouts.app')

{{--section header--}}
@section('header')

    {{-- css include--}}
    <link href="{{ asset('/assets/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/jquery-multi-select/multi-select.css') }}" rel="stylesheet">

    <!-- Bootstrap css file-->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/default-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/my-style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/gama.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/orginalGamaweb.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/pretty-checkbox.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @php
        $page = "site";
    @endphp

    <!-- logo & title -->
    <div class="container post-page">
        <div class="color-top-page"></div>
        <div class="logo-des">
            <!-- logo -->
            <div class="logo-postPage mb-5">
                <!-- IMG BASED LOGO  -->
                <a href="{{url('/')}}"><img src="{{ asset('/images/logo_index.png')}}"></a>
            </div>
            <!-- title -->
            <div class="title-PostPage">
                <strong class="display-4 mt-0">
                    @lang($page.'.Project information registration')
                </strong>
            </div>
            <!-- description -->
            <div class="des-PostPage mt-4">
                <p class="display-1">
                    @lang($page.'.By completing the information in each section, you will be able to get what you need to accomplish your project: programmers, skills, portfolio and more.')
                </p>
            </div>
        </div>
        <div class="main-post-page">
            <form action="{{url($action)}}" method="post" name="postProject_form" enctype="multipart/form-data">
            {{csrf_field()}}
            <!--//////////////// Start Name Project ///////////////////-->
                <!-- section A  -->
                @php
                    $field_value = $block_field['information']['name'];
                    $field_key = "name";
                @endphp
                <div id="nameProject">
                    <div class="form-group">
                        <label for="nameOfProject">@lang($page.'.'.$field_key)</label>
                        <input
                            type="{{ ($field_value['type'] == "date")? "text" : $field_value['type'] }}"
                            name="{{ $field_key }}" id="{{ $field_key.'OfProject' }}"
                            value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                            class="form-control @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                            @if($field_value['required']) required @endif
                            @if($field_value['type'] == 'tel') maxlength="11"
                            placeholder="091xxx" @endif
                            @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                            @endif
                            @if(isset($field_value['placeholder'])) placeholder="@lang($page.'.'.$field_value['placeholder'])"
                            @endif
                            @if($field_value['readonly']) readonly @endif
                            @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                        >
                    </div>

                    @php
                        $field_value = $block_field['information']['description'];
                        $field_key = "description";
                    @endphp
                    <div class="form-group" id="textAreaDescrbProject">
                        <label for="AboutProject">@lang($page.'.General description of the project')</label>
                        <p>@lang($page.'.A brief explanation of what you need in the project and what they need to know about how the project will be implemented.')</p>

                        <textarea name="{{ $field_key }}" id="describProject"
                                  cols="10" rows="6"
                                  class="form-control @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                  @if(isset($field_value['placeholder'])) placeholder="@lang($page.'.'.$field_value['placeholder'])"
                                  @endif
                                  @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}"
                                  @endif @if($field_value['readonly']) readonly @endif>@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif</textarea>

                        <span class="invalid-feedback display-none" id="alert_divdescribProject" role="alert">
                            <strong>@lang($page.'.Please enter at least 30 characters.')</strong>
                        </span>
                    </div>

                    <!-- upload file -->
                    @php
                        $field_value = $block_field['information']['attachment'];
                        $field_key = "attachment";
                    @endphp
                    <div class="upload-PostPage">
                        <div class="input-group dispay-me">
                        <span class="input-group-btn">
                            <span class="btn btn-success btn-file upload-portfolio">
                                @lang($page.'.+ upload file')
                                <input type="{{ $field_value['type'] }}"
                                       name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                       id="{{ $field_key }}"
                                       accept="{{ $field_value['upload_type'] }}/*"
                                       class="imgInp @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                       @if($field_value['readonly']) readonly @endif
                                       @if($field_value['required']) required @endif
                                       @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}"
                                       @endif
                                       @if(isset($field_value['placeholder'])) placeholder="@lang($page.'.'. $field_value['placeholder'])"
                                       @endif
                                       @if(isset($field_value['multiple']) && $field_value['multiple']) multiple @endif
                                >
                            </span>
                        </span>
                            <input class="form-control url" readonly="readonly" type="text">
                            <div class="text-upload-PstPage text-center">
                                <p class="">@lang($page.'.Select any images or documents that might be helpful in explaining your project brief here.')</p>
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
                                                <a href="{{ asset($file_name) }}"
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
                                        <a href="{{ asset($field_value['value']) }}"
                                           target="_blank">
                                            <i class="fa fa-eye text-danger eye"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <!-- next button -->
                    <div class="nextButton-PostPage">
                        <button id="btn_c1" type="button"
                                class="btn btn-default nextBtn">@lang($page.'.Continue')</button>
                    </div>
                </div>
                <!--//////////////// END Name Project ///////////////////-->

            @php
                $field_value = $block_field['information']['skill'];
                $field_key = "skill";
            @endphp
            <!--//////////////// Start what skills ///////////////////-->
                <div id="whatSkill" class="display-none">
                    <div class="skill-PostPage">
                        <h3>@lang($page.'.Choose the skills you need for the project')</h3>
                        <div class="description-skill">

                            <p>@lang($page.'.By choosing the skills required by the project, you help search for better results for freelancers.')</p>
                            <select
                                name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                id="selectSkill" data-placeholder="@lang($page.'.What skills are required?')"
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

                            <span id="alert_divSkillSelect" class="invalid-feedback" role="alert">
                                <strong>@lang($page.'.What skills are required?')</strong>
                            </span>

                        </div>
                    </div>
                    <!-- next button -->
                    <div class="nextButton-PostPage">
                        <button id="btn_c2" type="button"
                                class="btn btn-default nextBtn">@lang($page.'.Continue')</button>
                    </div>
                </div>
                <!--//////////////// END what skills ///////////////////-->

            @php
                $field_value = $block_field['information']['currency'];
                $field_key = "currency";
            @endphp
            <!--//////////////// Start box pay ///////////////////-->
                <div id="boxPay" class="display-none">
                    <div class="box-pay-PostPage">
                        <h3>@lang($page.'.Choose your payment type')</h3>
                        <div class="row">
                            <div class="col-12 col-md-5 offset-md-1 pointer">
                                <!-- box pay project fixd-->
                                <div class="box-PstPage paddingBoxPay payment-type payment-type-active" data-title="project">
                                    <div class="media mt-3">
                                        <div class="media-left img-media col-md-3 col-sm-2 col-xs-2 p-2">
                                            <div>
                                                <img class="img-responsive" src="{{ asset('/images/svg/2.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="media-body text-media col-md-10 col-sm-10 col-xs-10">
                                            <h3>@lang($page.'.Pay fixed price')</h3>
                                            <p>@lang($page.'.Agree on a price and release payment when the job is done.[1:] Best for one-off tasks.')</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 offset-md-1r pointer">
                                <!-- box pay hour-->
                                <div class="box-PstPage paddingBoxPay payment-type" data-title="hour">
                                    <div class="media mt-3">
                                        <div class="media-left img-media col-md-3 col-sm-2 col-xs-2 p-2">
                                            <div>
                                                <img class="img-responsive" src="{{ asset('/images/svg/3.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="media-body text-media col-md-9 col-sm-10 col-xs-10">
                                            <h3>@lang($page.'.Pay by the hour')</h3>
                                            <p>@lang($page.'.Hire based on an hourly rate and pay for hours billed.[1:] Best for ongoing work.')</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- select option Currency -->
                    <div class="country-PoistPage">
                        <h3>@lang($page.'.What is your estimated budget?')</h3>
                        <div class="form-gorup offset-md-4r col-md-8 ">
                            <div class="row mt-5">
                                <div class="col-md-4 col-sm-4">
                                    <select
                                        id="selectCurrency" data-placeholder="@lang($page.'.What skills are required?')"
                                        class="m-t-5 @if(!isset($field_value['select2'])) select2 @else form-control @endif @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                        @if(isset($field_value['multiple']) && $field_value['multiple']) multiple
                                        @endif
                                        @if($field_value['readonly']) readonly @endif
                                        @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                                    >

                                        <option class="select-currency" value="null" selected>@lang($page.'.Select Currency...')</option>

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
                                <div class="col-md-8 col-sm-8">
                                    <select id="selectWage" name="wageid" class="select2 m-t-5" data-placeholder="@lang($page.'.Choose a Wage...')">
                                        <option value="">@lang($page.'.Select type project...')</option>
                                    </select>
                                </div>
                            </div>

                            <span id="alert_divPayBox" class="invalid-feedback" role="alert">
                                <strong>@lang($page.'.Select currency and estimated budget.')</strong>
                            </span>
                        </div>
                    </div>
                    <!-- next button -->
                    <div class="nextButton-PostPage col-md-12">
                        <button id="btn_c3" type="button"
                                class="btn btn-default nextBtn">@lang($page.'.Continue')</button>
                    </div>
                </div>
                <!--//////////////// END box pay ///////////////////-->


                <!--//////////////// Start Helping hand ///////////////////-->
                <div id="helpingHand" class="display-none">
                    {{--<div class="box-pay-PostPage">
                        <h3>@lang($page.'.Do you need a helping hand?')</h3>
                        <div class="row">
                            <div id="freeBox" onclick="helpingHand(1)" class="col-12 col-md-5 offset-md-1 pointer">
                                <!-- box -->
                                <div class="box-PstPage paddingBoxPay">
                                    <div class="media mt-3">
                                        <div class="media-left img-media col-md-3 col-sm-2 col-xs-2 p-2">
                                            <div>
                                                <img class="img-responsive" src="{{ asset('/images/svg/4.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="media-body text-media col-md-9 col-sm-10 col-xs-10">
                                            <h3>@lang($page.'.Standard project')</h3>
                                            <p>@lang($page.'.Free to post, your project will go live instantly and start receiving bids within seconds.')</p>
                                            <strong class="mt-3 mb-3">@lang($page.'.Free')</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="helpingHandbox" onclick="helpingHand(2)" class="col-12 col-md-5 offset-md-1r pointer">
                                <!-- box -->
                                <div class="box-PstPage paddingBoxPay">
                                    <div class="media mt-3">
                                        <div class="media-left img-media col-md-3 col-sm-2 col-xs-2 p-2">
                                            <div>
                                                <img class="img-responsive" src="{{ asset('/images/svg/5.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="media-body text-media col-md-9 col-sm-10 col-xs-10">
                                            <h3>@lang($page.'.Recruiter project')</h3>
                                            <p>@lang($page.".We'll assign one of our expert staff to help you find the perfect freelancer for the job.")</p>
                                            <strong class="mt-3 mb-3"><b class="text-danger display-flex">@lang($page.'.ONLY')<b name="assistantSetting_price" class="assistantSetting_price"></b></b></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <h4 id="line_advanceOption" class="pointer text-success f-right mb-5"><strong>Advances option</strong></h4>--}}
                </div>
                <!--//////////////// END  Helping hand ///////////////////-->

            @php
                $field_value = $block_field['information']['advanceoption'];
                $field_key = "advanceoption";
            @endphp
            <!--//////////////// Start advance option ///////////////////-->
                <div id="advanceOption" class="display-none">
                    <ul id="ul_advancedOption" class="pl-5 pr-5">

                        @foreach($field_value as $listAdvancedOption)

                            <li class="shadow-box row mt-3">
                                <div class="col-md-1">
                                    <div class="pretty p-icon p-smooth mt-4">
                                        <input id="{{$listAdvancedOption->advanceoptionid}}" name="{{'ad_' . $listAdvancedOption->advanceoptionid.'|'.$listAdvancedOption->name}}" type="checkbox" />
                                        <div class="state p-success">
                                            <i class="icon fa fa-check mt-2 ml-1"></i>
                                            <label></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 pt-3"><strong>{{$listAdvancedOption->name}}</strong></div>
                                <div class="col-md-7 pt-1"><p>{{$listAdvancedOption->description}}</p></div>
                                <div class="col-md-2  pt-1">
                                    @if($listAdvancedOption->discount_percent != 0) <div class="display-block text-danger"><strong> {{'only '.$listAdvancedOption->discount_percent}}</strong></div> @endif
                                    <div class="display-block @if($listAdvancedOption->discount_percent  != 0) line-through @endif">{{$listAdvancedOption->price .' '.$listAdvancedOption->currency->name}}</div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <!--//////////////// END advance option ///////////////////-->


                <!--//////////////// Start result box ///////////////////-->
                <div id="resultBox" class="display-none mt-5">
                    <div class="endest-box pl-4 pr-4">
                        <h3>What skills are required?</h3>
                        <div class="end-box">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="image-end-box">
                                        <img src="{{ asset('/images/svg/6.png')}}" width="60px" height="60px" alt="">
                                        <div class="image-text-end-box">
                                            <h5>

                                                <strong>@lang($page.'.Project')</strong>

                                                <p id="resultSelectWage"></p>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-end-box">
                                        <strong class=" mt-1"><p id="set_nameProject" class="display-4"></p></strong>
                                        <strong class=" mt-2"><p id="set_describProject"></p></strong>
                                        <div id="set_skill" class="display-flex mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- button -->
                    <div class="btn-postProject">
                        <button type="submit" class="btn btn-success saveSetting my-2">@lang($page.'.Post Project')</button>
                    </div>
                </div>
                <input type="hidden" id="assistant_settingid" name="assistant_settingid">
                <!--//////////////// Start result box ///////////////////-->
            </form>
        </div>
    </div>
@endsection

@section('script')

    <script>window.jQuery || document.write('<script src="{{asset('/js/minified/jquery-1.11.0.min.js')}}"><\/script>')</script>
    <!-- jQuery  -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>

    <script src="{{ asset('/assets/fastclick/fastclick.js') }}"></script>
    <script src="{{ asset('/assets/select2/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/sweet-alert/sweet-alert.min.js') }}"></script>

    <script type="text/javascript">
        var typePayProject= 'project';
        var assistant_settingid;
        // $('#box1').addClass('Card-shadow-select');

        // Select2
        jQuery(".select2").select2({
            width: '100%',
            allowClear: true
        });

        var resizefunc = [];

        $(document).ready(function () {
            $('.payment-type-active').click();
            //--------selected first item in selectCurrency.
            $('#selectCurrency').val($('#selectCurrency').find('option:first-child').val()).trigger('change');

            //------check not empty input -->Name Project.
            $('#btn_c1').click(function () {
                if ($('#nameOfProject').val().length > 1) {
                    if ($('#describProject').val().length > 30) {
                        $('#whatSkill').removeClass('display-none');
                        $('#whatSkill').addClass('visible-me');
                        $('#btn_c1').addClass('hidden');
                        $('#nameOfProject').removeClass('is-invalid');
                        $('#describProject').removeClass('is-invalid');
                        $('#alert_divdescribProject').addClass('display-none');
                        document.getElementById('whatSkill').scrollIntoView();

                        //----result name project.
                        $('#set_nameProject').text($('#nameOfProject').val());
                        $('#set_describProject').text($('#describProject').val());

                    } else {
                        $('#nameOfProject').removeClass('is-invalid');
                        $('#describProject').addClass('is-invalid');
                        $('#alert_divdescribProject').removeClass('display-none');

                    }
                } else {
                    $('#nameOfProject').addClass('is-invalid');
                }
            });

            //-----ceck select skill in --> what skill.
            $('#btn_c2').click(function () {
                if ($('#selectSkill').val() !== null) {
                    $('#boxPay').removeClass('display-none');
                    $('#boxPay').addClass('visible-me');
                    $('#btn_c2').addClass('hidden');
                    $('#alert_divSkillSelect').addClass('display-none');
                    $('#alert_divSkillSelect').removeClass('display-block');
                    document.getElementById('boxPay').scrollIntoView();

                    //----- set result skill.
                    var multi = $("#selectSkill option:selected").toArray();

                    $.each(multi, function (key, value) {
                        $('#set_skill').append('<P class="form-control w-auto ml-1">'+value.text+'</p>');
                    });
                } else {
                    $('#alert_divSkillSelect').removeClass('display-none');
                    $('#alert_divSkillSelect').addClass('display-block');
                }
            });

            //-----ceck select type project --> box pay
            $('#btn_c3').click(function () {
                if ($('#selectCurrency').val() !== "null") {
                    $('#helpingHand').removeClass('display-none');
                    $('#helpingHand').addClass('visible-me');
                    $('#btn_c3').addClass('hidden');
                    $('#alert_divPayBox').addClass('display-none');
                    $('#alert_divPayBox').removeClass('display-block');
                    document.getElementById('helpingHand').scrollIntoView();
                    helpingHand(1);
                }else{
                    $('#alert_divPayBox').removeClass('display-none');
                    $('#alert_divPayBox').addClass('display-block');
                }
            });

            $('#line_advanceOption').click(function () {
                const element = document.querySelector("#advanceOption");

                if (element.classList.contains("display-none") || element.classList.contains("hidden")) {
                    $('#advanceOption').removeClass('display-none');
                    $('#advanceOption').removeClass('hidden');
                    $('#advanceOption').addClass('visible-me');
                    document.getElementById('advanceOption').scrollIntoView();
                } else {
                    $('#advanceOption').removeClass('visible-me');
                    $('#advanceOption').addClass('hidden');
                    document.getElementById('helpingHand').scrollIntoView();
                }

            });

            $('#selectCurrency').on("click", function () {
                var this_val = $(this).val();
                get_Wage_assistantSetting(this_val);
                $('.select-currency').prop('disabled', true);
            });

            $('#selectWage').on("click", function () {
                $('#resultSelectWage').text($("#selectWage option:selected").html() );
            });

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

        $('.payment-type').click(function () {
            $('.payment-type').removeAttr('style');
            $(this).css('box-shadow', '0 9px 6px -6px #02ca59');
            var id = $(this).attr('data-title');
            typePay(id);
            var this_val = $('#selectCurrency').val();
            get_Wage_assistantSetting(this_val);
        });
        //----- type pay project : 1-> project fix  , 2-> hour.
        function typePay(id) {
            typePayProject = id;
        }
        function get_Wage_assistantSetting(this_val) {
            var formData = new FormData();
            var _val = "{{csrf_token()}}";
            formData.append('_token', _val);
            formData.append('id', this_val);
            formData.append('type', typePayProject);
            if (this_val) {
                //----get wage.
                $.ajax({
                    url: '/get_Wage_assistantSetting',
                    type: 'POST',
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success: function (result) {
                        if (result.length != 0) {

                            //---set value in -> assistantSetting_price.
                            $('.assistantSetting_price').text(": " + result[1].price + " " + result[1].currency.name);
                            $('.assistantSetting_price').attr('id',result[1].assistant_settingid);
                            assistant_settingid = result[1].assistant_settingid;
                            /* claer select2 */
                            var cbSelect = $('#selectWage');
                            cbSelect.empty();

                            /* select2 create new option */
                            $.each(result[0], function (key, value) {
                                var option;
                                if (value.type == 'project') {
                                    option = new Option(value.name + " (" + value.minbudget + " - " + value.maxbudget + "  " + value.currency.name + ")", value.wageid, true, true);
                                } else if (value.type == 'hour') {
                                    option = new Option(value.name + " (" + value.minbudget + " - " + value.maxbudget + "  " + value.currency.name + ") per hour", value.wageid, true, true);
                                }
                                cbSelect.append(option);
                            });
                            cbSelect.val(cbSelect.find('option:first-child').val()).trigger('change');
                            $('#resultSelectWage').text( cbSelect.find('option:first-child').html() );

                            //----add advancedoption.
                            $('#ul_advancedOption').empty();
                            $.each(result[2], function (key, value) {

                                var css_Line = '';
                                var div_discount = '';
                                if (value.discount_percent != 0) {
                                    css_Line = "line-through";
                                    div_discount = '<div class="display-block text-danger"><strong> ' + value.discount_percent + '</strong></div>';
                                }
                                $('#ul_advancedOption').append('<li class="shadow-box row mt-3">\n' +
                                    '                            <div class="col-md-1">\n' +
                                    '                                <div class="pretty p-icon p-smooth mt-4">\n' +
                                    '                                    <input id="' + value.advanceoptionid + '"  name="ad_' +value.advanceoptionid+'|'+ value.name + '"type="checkbox" />\n' +
                                    '                                    <div class="state p-success">\n' +
                                    '                                        <i class="icon fa fa-check mt-2 ml-1"></i>\n' +
                                    '                                        <label></label>\n' +
                                    '                                    </div>\n' +
                                    '                                </div>\n' +
                                    '                            </div>\n' +
                                    '                            <div class="col-md-2 pt-3"><strong>' + value.name + '</strong></div>\n' +
                                    '                            <div class="col-md-7 pt-1"><p>' + value.description + '</p></div>\n' +
                                    '                            <div class="col-md-2  pt-1">' + div_discount + '\n' +
                                    '                                <div class="display-block ' + css_Line + '">' + value.price + ' ' + value.currency.name + '</div>\n' +
                                    '                            </div>\n' +
                                    '                        </li>');
                            });
                        }
                    }
                });
            }
        }
        function helpingHand(id) {
            if(id == 1){
                $('#assistant_settingid').val('');
            }else{
                $('#assistant_settingid').val(assistant_settingid);
            }
            $('#resultBox').removeClass('display-none');
            $('#resultBox').addClass('visible-me');
            document.getElementById('resultBox').scrollIntoView();
        }
        function experince(id) {

//-----set value to input expreince.
            $('#expreince').val(id);
            $('.border_me').removeClass('Card-shadow-select');
            $('#box' + id).addClass('Card-shadow-select');

        }
        function sendData() {
            if (($('#FirstName').val().length < 1) && ($('#LastName').val().length < 1)) {
                $('#FirstName').addClass('is-invalid');
                $('#LastName').addClass('is-invalid');
            } else if ($('#FirstName').val().length < 1) {
                $('#FirstName').addClass('is-invalid');
                $('#LastName').removeClass('is-invalid');
            } else if ($('#LastName').val().length < 1) {
                $('#LastName').addClass('is-invalid');
                $('#FirstName').removeClass('is-invalid');
            } else {
                var formData = $('#formSendInfoUser');
                formData.submit();
            }
        }
    </script>
@endsection
