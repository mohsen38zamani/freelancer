@extends('index')

@section('header')
@endsection

@section('body')

        <!--=========== BEGIN All Category Skills ================-->
        <section id="bottom" class="">
            <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                <div class="row">
                    <br>
                    <!-- Start Service Title -->
                    <div class="section-heading">
                        <h2 class="text-dark mrg-top-50">@lang('site.Browse top job categories') </h2>
                        <div class="line"></div>
                    </div>
                    <!-- Start Service Content -->

                    @if (count($skill) >= 6)
                        @for($x = 0 ; $x < floor((count($skill) / 6))+1 ; $x++)
                            <div class="col-md-3 col-sm-6">
                                <div class="widget">
                                    <ul class="ul_language">
                                        @for($y=$x*6 ; $y < 6*($x+1) ; $y++)
                                            @break($y == count($skill))
                                            <li><img src="{{ asset('/images/tick.png') }}" alt="img">
                                                @if($lang != $def_lang) @lang('skill.' . $skill[$y]->name) @else {{ $skill[$y]->name }} @endif
                                            </li>
                                        @endfor
                                    </ul>
                                </div>
                            </div><!--/.col-md-3-->
                        @endfor
                    @else
                        <div class="col-md-3 col-sm-6">
                            <div class="widget">
                                <ul class="ul_language">
                                    @for($y=0; $y < count($skill) ; $y++)
                                        <li><img src="{{ asset('/images/tick.png') }}" alt="img">
                                            @if($lang != $def_lang) @lang('skill.' . $skill[$y]->name) @else {{ $skill[$y]->name }} @endif
                                        </li>
                                        @break($y == count($skill)-1)
                                    @endfor
                                </ul>
                            </div>
                        </div><!--/.col-md-3-->
                    @endif

                </div>
            </div>
        </section><!--/#bottom-->
        <!--=========== END All Category Skills ================-->

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
            swal("Notice", 'Your message was sent.', "success");
        </script>
    @endif
@endsection
