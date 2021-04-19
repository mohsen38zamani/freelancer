@extends('layouts.app')

{{--section header--}}
@section('header')
    {{-- css include--}}

    <link href="{{ asset('/assets/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/jquery-multi-select/multi-select.css') }}" rel="stylesheet">

@endsection

@section('content')
    @php
        $page = "site";
    @endphp

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">

                        <div>
                            <img class="" src="images/favicon.png" alt="logo freelancer">
                        </div>

                        <div class="mt-3 mb-2">
                            <h2 class="h5 font-weight-bold font_tunga_signup">@lang($page.'.Select skills')</h2>
                        </div>

                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-12">

                                <h2 class="font_tunga_sizeable font-weight-bold h2 text-dark_ali">@lang($page.'.Please enter your personal information to get the best feedback from our system')</h2>

                                <div class="col-md-12 display-flex display-initial-resp height550">

                                    <div class="col-md-12 Card-shadow  p-0 pr-5 pl-5">
                                        <form id="formSendInfoUser" action="{{ url("/UserInfo") }}" method="post">
                                            {{csrf_field()}}
                                            <input name="expreince" id="expreince" type="hidden">
                                            <div class="mt-1 pt-5 ">
                                                <strong>@lang($page.'.Full Name')</strong>
                                                <div class="row mt-1 col-md-12 p-0">
                                                    <div class="form-group col-md-6">
                                                        <input type="text" name="FirstName" id="FirstName" class="form-control" placeholder="@lang($page.'.First Name')">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" name="LastName" id="LastName" class="form-control" placeholder="@lang($page.'.Last Name')">
                                                    </div>
                                                </div>

                                                <strong>@lang($page.'.Location')</strong>
                                                <div class="row mt-1 col-md-12 p-0">
{{--                                                                                                        {{dd($mainland)}}--}}
                                                    <div class="form-group col-md-6">
                                                        <select id="selectMainland" name="mainland" class="select2 mainland" data-placeholder="@lang($page.'.Choose a Country...')">
                                                            @foreach($mainland as $list)
                                                                <option value="{{$list->mainlandid}}">{{$list->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select id="selectCountery" name="country" class="select2" data-placeholder="@lang($page.'.Choose a Country...')">
                                                            @foreach($mainland[0]->country as $list)
                                                                <option value="{{$list->countryid}}">{{$list->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-2 row pr-0 pl-0 pb-4">
                                                @foreach($experince as $list)
                                                    <div class="col-md-4 mt-2">
                                                    <div id="{{'box'.$list->experinceid}}" class="border_me Card-shadow height56 text-center p-4 pointer" onclick="experince({{$list->experinceid}})">
                                                        <strong class="h4">{{$list->type}}</strong>
                                                        <div class="or-seperator"></div>
                                                        <p class=" mt-3 h5">{{$list->description}}</p>
                                                    </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row card-body col-md-12">
                            <div class="col-md-10"></div>
                            <div class="col-md-2 text-right">
                                <input type="button" class="btn btn-primary m-2" value="@lang($page.'.NEXT')" onclick="sendData()">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')
    <!-- jQuery  -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>

    <script src="{{ asset('/assets/fastclick/fastclick.js') }}"></script>
    <script src="{{ asset('/assets/select2/select2.min.js') }}"></script>

    <script type="text/javascript">

        $('#box1').addClass('Card-shadow-select');

        // Select2
        jQuery(".select2").select2({
            width: '100%',
            allowClear : true
        });


        var resizefunc = [];

        $(document).ready(function() {
			experince(1);
            var listcountry = new Array();

            $('.mainland').on("click", function () {

                var formData = new FormData();
                var _val = "{{csrf_token()}}";
                formData.append('_token', _val);
                formData.append('id', $(this).val());

                $.ajax({
                    url: '{{url('/getCountry')}}',
                    type: 'POST',
                    data: formData,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    success: function (result) {
                        if (result.length != 0) {
                            /* claer select2 */
                            var cbSelect = $('#selectCountery');
                            cbSelect.empty();

                            /* select2 create new option */
                            $.each(result, function (key, value) {
                                var option = new Option(value.name, value.countryid, true, true);
                                cbSelect.append(option);
                            });

                            cbSelect.val(cbSelect.find('option:first-child').val()).trigger('change');
                        }
                    }
                });
            });

        });


        function experince(id) {

            //-----set value to input expreince.
            $('#expreince').val(id);
            $('.border_me').removeClass('Card-shadow-select');
            $('#box'+id).addClass('Card-shadow-select');

        }
        function sendData() {
            if( ($('#FirstName').val().length < 1 ) && ($('#LastName').val().length < 1) ) {
                $('#FirstName').addClass('is-invalid');
                $('#LastName').addClass('is-invalid');
            }
            else if($('#FirstName').val().length < 1 ){
                $('#FirstName').addClass('is-invalid');
                $('#LastName').removeClass('is-invalid');
            }
            else if($('#LastName').val().length < 1 ){
                $('#LastName').addClass('is-invalid');
                $('#FirstName').removeClass('is-invalid');
            }
            else{
                var formData = $('#formSendInfoUser');
                formData.submit();
            }
        }
    </script>
@endsection
