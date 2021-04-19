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
            $allowedMimeTypes = ['image/jpeg','image/jpg','image/gif','image/png','image/bmp','image/svg+xml'];

        @endphp
        @section('page-title') {{ ucfirst($page_action) . ' ' .$page }} @endsection
    <div class="container post-page">
        <div class="logo-des">
            <!-- title -->
            <div class="title-PostPage display-inline-block">
                <h1>Help</h1>
            </div>
        </div>
        <div class="panel m-t-15">
            <!-- title And button -->
            <div class="col-md-12">
                <!-- button toggle -->
                <div class="f-right">
                    <div class="switcher">
                        <input type="radio" name="balance" id="tab_employer"
                               class="faq-selector-item switcher__input switcher__input--yin active" checked="" data-name="employer">
                        <label for="tab_employer" class="switcher__label">@lang($page . '.employer')</label>

                        <input type="radio" name="balance" id="tab_freelancer"
                               class="faq-selector-item switcher__input switcher__input--yang" data-name="freelancer">
                        <label for="tab_freelancer" class="switcher__label">@lang($page . '.freelancer')</label>

                        <span class="switcher__toggle"></span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <ul class="faq-list">
                        @foreach($data as $item)
                            @php $faqid = $item['faqid']; @endphp
                        <li class="faq-item @if($item['roleid'] == 3)freelancer @else employer @endif"><a href="{{ url("/faq/help/$faqid") }}">@if($lang != $def_lang) @lang($page . '.' . $item['title']) @else {{ $item['title'] }} @endif</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-danger m-t-150">
            <span>You do not have permission to view this page</span>
        </div>
    @endif
@endsection
@section('script-extend')
    <script>
        $(document).ready(function () {
            $('.freelancer').addClass('display-none');
            removeBorder($('.employer'));

            $('.faq-selector-item').click(function () {
                var item = $(this).attr('data-name');

                $('.faq-selector-item').removeClass('active');
                $(this).addClass('active');

                $('.faq-item').addClass('display-none');
                var elements = $('.' + item);
                removeBorder(elements);
                $(elements).removeClass('display-none');
            });

            function removeBorder(element) {
                $.each(element, function (key, value) {
                    $(value).css('border', 0);
                    $(value).css('padding-top', 0);
                    return false;
                });
            }
        });
    </script>
@endsection
