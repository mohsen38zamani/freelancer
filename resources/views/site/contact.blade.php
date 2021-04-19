@extends('index')

@section('header')
@endsection

@section('body')

    @if($permission)
        @php
            $page = \Request::segment(1);
            $page_lang = "site";
            $page_action = \Request::segment(2);
             if(\Request::segment(3)){
                 $item_id = \Request::segment(3);
             }
        @endphp
        <!--=========== BEGIN menu map ================-->
        <section id="blogArchive" class="mt-0">

            {{session('result')}}
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="blog-breadcrumbs-area">
                        <div class="container">
                            <div class="blog-breadcrumbs-left">
                                <h2>@lang($page_lang.'.Contact') </h2>
                            </div>
                            <div class="blog-breadcrumbs-right">
                                <ol class="breadcrumb">
                                    <li>You are here</li>
                                    <li><a href="{{url('/')}}">@lang($page_lang.'.Home') </a></li>
                                    <li class="active">@lang($page_lang.'.Contact')</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--=========== BEGIN BANER SECTION ================-->
        <!--Hero_Section-->
        <section id="hero_section" class="top_cont_outer">
            <div class="hero_wrapper">
                <div class="container">
                    <div class="hero_section">
                        <div class="row">
                            <div class="col-lg-5 col-sm-7">
                                <div class="top_left_cont zoomIn wow animated">
                                    <h2>@lang($page_lang.'.Freelancer Enterprise enables companies to get more done for less')  </h2>
                                    <p>@lang($page_lang.".Access a global workforce of over 39.8 million freelancers to turn your organization's ideas into reality at scale, faster and for a fraction of the price.")</p>
                                </div>
                            </div>
                            <div class="col-lg-7 col-sm-5">
                                <img src="{{asset('/images/item-hero-559ff6a5.png')}}" class="zoomIn wow animated img-responsive" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Hero_Section-->
        <!--=========== END BANER SECTION ================-->

        <!--=========== BEGIN Discover the benefits SECTION ================-->
        <section id="service">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="service-area">
                            <!-- Start Service Title -->
                            <div class="section-heading">
                                <h2 class="text-dark">@lang($page_lang.'.Discover the benefits of Freelancer Enterprise')</h2>
                                <div class="line"></div>
                            </div>
                            <!-- Start Service Content -->
                            <div class="service-content">
                                <div class="row">
                                    <!-- Start Single Service -->
                                    <div class="col-lg-4 col-md-4">
                                        <div class="single-service">
                                            <div class="service-icon">
                                                <span class="fa fa-file-text-o service-icon-effect"></span>
                                            </div>
                                            <h3><a href="#">@lang($page_lang.'.Streamline Internal Adoption') </a></h3>
                                            <p>@lang($page_lang.".We’ll provide workshops, video tutorials and 24/7 priority support to help you hit the ground running. Technical and training evangelists are ready to be onsite and prepare your staff for the future of work.") </p>
                                        </div>
                                    </div>
                                    <!-- Start Single Service -->
                                    <div class="col-lg-4 col-md-4">
                                        <div class="single-service">
                                            <div class="service-icon">
                                                <span class="fa fa-cogs service-icon-effect"></span>
                                            </div>
                                            <h3><a href="#">@lang($page_lang.'.Workflow Automation') </a></h3>
                                            <p>@lang($page_lang.'.Our fully featured API can help you fast track workforce automation and free up the time of your staff to focus on what matters. Integrate directly into your software, intranet or backend systems and make API calls into our virtual work cloud to task freelancers.') </p>
                                        </div>
                                    </div>
                                    <!-- Start Single Service -->
                                    <div class="col-lg-4 col-md-4">
                                        <div class="single-service">
                                            <div class="service-icon">
                                                <span class="fa fa-headphones service-icon-effect"></span>
                                            </div>
                                            <h3><a href="#">@lang($page_lang.'.Managed Services') </a></h3>
                                            <p>@lang($page_lang.".We have a multi-lingual team of Project Success Managers across multiple time-zones and geographies who are ready to help you find the perfect freelancer, curate your contest or assist in project managing your engagements.") </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Start Single Service -->
                                    <div class="col-lg-4 col-md-4">
                                        <div class="single-service">
                                            <div class="service-icon">
                                                <span class="fa fa-clock-o service-icon-effect"></span>
                                            </div>
                                            <h3><a href="#">@lang($page_lang.'.Total Transparency') </a></h3>
                                            <p>@lang($page_lang.'.We understand you want the quality and results you’re paying for. Our time-tracking app measures output, automates screen captures and routes approvals for deliverables so you can provide feedback in real-time.') </p>
                                        </div>
                                    </div>
                                    <!-- Start Single Service -->
                                    <div class="col-lg-4 col-md-4">
                                        <div class="single-service">
                                            <div class="service-icon">
                                                <span class="fa fa-line-chart service-icon-effect"></span>
                                            </div>
                                            <h3><a href="#">@lang($page_lang.'.Increase Insights') </a></h3>
                                            <p>@lang($page_lang.'.Measure your success and track the data that matters to you. Get real-time reporting on metrics including usage and spend on your custom dashboard.')</p>
                                        </div>
                                    </div>
                                    <!-- Start Single Service -->
                                    <div class="col-lg-4 col-md-4">
                                        <div class="single-service">
                                            <div class="service-icon">
                                                <span class="fa fa-shield service-icon-effect"></span>
                                            </div>
                                            <h3><a href="#">@lang($page_lang.'.Enhance Trust')</a></h3>
                                            <p>@lang($page_lang.'.Our compliance and worker classification solutions, along with a spot-checking service by US lawyers will build your comfort in collaborating with a global cloud workforce. Our rigorous know your customer and identity verification will let you collaborate with confidence.') </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--=========== End Discover the benefits SECTION ================-->
        <!--=========== BEGIN INPUT SECTION ================-->
        <section id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="contact-form">
                            <div class="section-heading">
                                <h2 class="text-dark">@lang($page_lang.'.Freelancer Enterprise or API Enquiries') </h2>
                                <div class="line"></div>
                            </div>
                            <p>@lang($page_lang.'.One of our team members will get back to you right away about your enquiry.')</p>
                            <div class="col-md-12">
                                <form id="formSendData" class="submitphoto_form" action="{{url($action)}}" method="post">
                                    {{csrf_field()}}
                                    <div class="row col-md-12">
                                        @foreach($block_field as $block_key => $block_value)
                                            @foreach($block_value as $field_key => $field_value)
                                                {{--------    hidden    --------}}
                                                @if($field_value['type'] == 'hidden')
                                                    <input type="{{ $field_value['type'] }}" name="{{ $field_key }}"
                                                           id="{{ $field_key }}"
                                                           value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                    >
                                                    @continue
                                                @endif

                                                @if($field_value['type'] != 'textarea')
                                                    <div class="col-md-6 col-xs-12 ">
                                                        {{--------    text    --------}}
                                                        @if(!in_array($field_value['type'], array('select', 'textarea', 'file', 'checkbox', 'date', 'time', 'number', 'hidden', 'button', 'currency', 'tags')))
                                                            <input
                                                                type="{{ ($field_value['type'] == "date")? "text" : $field_value['type'] }}"
                                                                name="{{ $field_key }}" id="{{ $field_key }}"
                                                                value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                                class="wpcf7-text-me  wp-form-control-contact @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                                                @if($field_value['required']) required @endif
                                                                @if($field_value['type'] == 'tel') maxlength="11"
                                                                placeholder="091xxx" @endif
                                                                @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                                @endif
                                                                @if(isset($field_value['placeholder'])) placeholder="@lang($page_lang.'.'.$field_value['placeholder'])"
                                                                @endif
                                                                @if($field_value['readonly']) readonly @endif
                                                                @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                                                            >


                                                            {{--------    number    --------}}
                                                        @elseif($field_value['type'] == 'number')

                                                            <input
                                                                type="{{ ($field_value['type'] == "number")? "text" : $field_value['type'] }}"
                                                                name="{{ $field_key }}" id="{{ $field_key }}"
                                                                value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                                class="wpcf7-text-me  wp-form-control-contact  @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                                                @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}"
                                                                @endif
                                                                @if($field_value['required']) required @endif
                                                                @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                                @endif
                                                                @if($field_value['readonly']) readonly @endif
                                                            >


                                                            {{--------    tags    --------}}
                                                        @elseif($field_value['type'] == 'tags')

                                                            <input name="{{ $field_key }}" id="{{ $field_key }}"
                                                                   value="@if(empty(old($field_key))){{ ($field_value['value']) }}@else{{ (old($field_key)) }}@endif"
                                                                   class="wpcf7-text-me  wp-form-control-contact @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                                                   @if($field_value['required']) required @endif
                                                                   @if($field_value['readonly']) readonly @endif
                                                                   @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                                                            >


                                                            {{--------    currency    --------}}
                                                        @elseif($field_value['type'] == 'currency')

                                                            <input type="text" name="{{ $field_key }}"
                                                                   id="{{ $field_key }}"
                                                                   value="@if(empty(old($field_key))){{ floatval($field_value['value']) }}@else{{ floatval(old($field_key)) }}@endif"

                                                                   class="wpcf7-text-me  wp-form-control-contact  @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                                                   @if($field_value['required']) required @endif
                                                                   @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                                   @endif
                                                                   @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                                                   @endif
                                                                   @if($field_value['readonly']) readonly @endif
                                                                   @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                                                            >


                                                            {{--------    date    --------}}
                                                        @elseif($field_value['type'] == 'date')

                                                            <input type="{{ ($field_value['type'] == "date")? "text" : $field_value['type'] }}"
                                                                   value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                                   name="{{ $field_key }}" id="{{ $field_key }}"
                                                                   class="wpcf7-text-me  wp-form-control-contact @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                                                   autocomplete="off"
                                                                   @if($field_value['required']) required @endif
                                                                   @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                                   @endif
                                                                   @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                                                   @endif
                                                                   @if($field_value['readonly']) readonly @endif
                                                                   @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                                                                   placeholder="yyyy-mm-dd">


                                                            {{--------    time    --------}}
                                                        @elseif($field_value['type'] == 'time')

                                                            <input name="{{ $field_key }}" id="{{ $field_key }}"
                                                                   type="text"
                                                                   value="@if(empty(old($field_key))){{ $field_value['value'] }}@else{{ old($field_key) }}@endif"
                                                                   class="wpcf7-text-me  wp-form-control-contact @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"

                                                                   @if($field_value['required']) required @endif
                                                                   @if(isset($field_value['maxlength'])) maxlength="{{ $field_value['maxlength'] }}"
                                                                   @endif
                                                                   @if(isset($field_value['placeholder'])) placeholder="{{ $field_value['placeholder'] }}"
                                                                   @endif
                                                                   @if($field_value['readonly']) readonly @endif
                                                                   @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}" @endif
                                                            />


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
                                                                       class="wpcf7-text-me  wp-form-control-contact imgInp @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
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

                                                            {{------    checkbox    ------}}
                                                        @elseif($field_value['type'] == 'checkbox')
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="{{ $field_value['type'] }}"
                                                                       name="{{ $field_key }}" id="{{ $field_key }}"
                                                                       class="wpcf7-text-me  wp-form-control-contact checkbox @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
                                                                       @if($field_value['readonly']) readonly @endif
                                                                       @if($field_value['required']) required @endif
                                                                       @if(isset($field_value['data'])) data-title="{{ $field_value['data'] }}"
                                                                       @endif
                                                                       @if($field_value['value']) checked @endif>
                                                                <label for="{{ $field_key }}"> </label>
                                                            </div>

                                                            {{------    select    ------}}
                                                        @elseif($field_value['type'] == 'select')
                                                            <select
                                                                name="{{ $field_key }}@if(isset($field_value['multiple']) && $field_value['multiple'])[]@endif"
                                                                id="{{ $field_key }}"
                                                                class="wpcf7-text-me wp-form-control-contact @if(!isset($field_value['select2'])) select2 @endif @if(isset($field_value['class'])) {{ $field_value['class'] }} @endif"
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
                                                        @endif
                                                        @if ($errors->has($field_key))
                                                            <span class="help-block">
                                                                <strong class="text-danger ml-3">
                                                                    @php
                                                                        $msg = str_replace('_', ' ', $field_key);
                                                                        echo str_replace($msg, __($page.'.'.$field_key), $errors->first($field_key));
                                                                    @endphp
                                                                </strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif

                                            @endforeach
                                        @endforeach
                                    </div>
                                    @if($block_field['information']['message'])
                                        <div class="row col-md-12">
                                            <div class="col-md-12">
                                                                <textarea name="message" id="message"
                                                                          cols="30" rows="10"
                                                                          class="wp-form-control  wp-form-control-contact "
                                                                          @if(isset($block_field['information']['message']['placeholder'])) placeholder="@lang($page_lang.'.'.$block_field['information']['message']['placeholder'])"
                                                                          @endif
                                                                          ></textarea>

                                            </div>
                                        </div>
                                    @endif

                                    <div class="row col-md-12">
                                        <div class="col-md-12">
                                            <button id="btn_send" class="wpcf7-submit button--itzel" type="button"><i class="button__icon fa fa-envelope"></i><span>@lang($page_lang.'.Send Message')</span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="alert alert-danger m-t-150">
            <span>@lang($page_lang.'.You do not have permission to view this page')</span>
        </div>
    @endif
@endsection



@section('script')
    <!-- Page Specific JS Libraries -->
    <script src="{{ asset('/assets/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('/assets/sweet-alert/sweet-alert.min.js') }}"></script>
    <script src="{{ asset('/assets/sweet-alert/sweet-alert.init.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#btn_send').click(function () {
                $('#formSendData').submit();
            });
        })
    </script>

    @if(isset($_REQUEST['result']) && $_REQUEST['result'] == '200')
        <script>
            swal("Notice","@lang('site.Your message was sent.')", "success");
        </script>
    @endif
@endsection
