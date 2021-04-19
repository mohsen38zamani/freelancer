@extends('layouts.app')

{{--section header--}}
@section('header')
    {{-- css include--}}

    <!-- custom scrollbar stylesheet -->
    <link href="{{ asset('/css/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/pretty-checkbox.min.css') }}" rel="stylesheet">

@endsection

@section('content')
    @php
        $page ="site";
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

                                <h2 class="font_tunga_sizeable font-weight-bold h2 text-dark_ali">@lang($page.'.By choosing your skills you can help us with your job offer:')</h2>

                                <div class="col-md-12 display-flex display-initial-resp height550">

                                    <div class="col-md-3 Card-shadow mt-3 w-75 mr-2 ml-2 flex-basis-46 p-0 ">
                                        <section id="examples">
                                            <div  id="content-1" class="content">

                                                @foreach($Lv1skill as $list)
                                                    <p class="pointer p_hover lv1p col-md-12 h5 mt-3 {{$list->icon_class}}" id="{{'lv1_'.$list->lv1skillid}}">
                                                        <i class="{{ $list->icon_class }}"></i><strong class="pl-3">{{$list->name}}</strong>
                                                    </p>
                                                @endforeach

                                            </div>
                                        </section>
                                    </div>

                                    <div class="col-md-6 Card-shadow mt-3 w-75 mr-2 ml-2 flex-basis-46 p-0 ">
                                        <section id="examples">
                                            <div  id="content-2" class="content col-md-12">

                                                @foreach($Lv1skill as $list)

                                                    @foreach($list->skill as $skill)
                                                        <div class="{{'lv1_'.$list->lv1skillid}} hideall col-md-5 pretty p-icon p-curve p-tada mt-4" hidden>
                                                            <input type="checkbox" class="chk-select" name="{{'chk_'.$skill->skillid}}" id="{{'chk_'.$skill->skillid}}">
                                                            <div class="state p-primary-o">
                                                                <i class="icon fa fa-check"></i>
                                                                <label><strong> {{$skill->name}}</strong></label>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                @endforeach

                                            </div>
                                        </section>
                                    </div>

                                    <div class="col-md-3 Card-shadow mt-3 w-75 mr-2 ml-2 flex-basis-46 ">
                                        <section id="examples">
                                            <div  id="content-3" class="content">
                                                {{-- ---- insert by jquery.--}}
                                            </div>
                                        </section>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row card-body col-md-12">
                            <div class="col-md-10">
                                <h2 class="font_tunga_sizeable font-weight-bold h2 text-dark_ali">@lang($page.'.Selected skill:') <strong id="selectcount"></strong></h2>
                            </div>
                            <div class="col-md-2 text-right">
                                <form id="formSkillSend" name="formSkillSend" action="{{ url("/skill") }}" method="post">
                                    {{csrf_field()}}
                                    <input type="button" class="btn btn-primary m-2" value="@lang($page.'.NEXT')" onclick="sendData()">
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')

    <script>window.jQuery || document.write('<script src="{{asset('/js/minified/jquery-1.11.0.min.js')}}"><\/script>')</script>

    <!-- custom scrollbar plugin -->
    <script src="{{asset('/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>

    <script>
        (function($){
            $(window).on("load",function(){

                $("#content-1").mCustomScrollbar({
                    autoHideScrollbar:true,
                    theme:"rounded"
                });

                $("#content-2").mCustomScrollbar({
                    autoHideScrollbar:true,
                    theme:"rounded"
                });

                $("#content-3").mCustomScrollbar({
                    autoHideScrollbar:true,
                    theme:"rounded"
                });

            });
        })(jQuery);
    </script>


    <script type="text/javascript">
        selectSkill = new Array();

        $(document).ready(function() {
            //-------click Lv1skill -> show skill's in middle box.
            $(".lv1p").click(function (e) {
                eventid = this.id; // get id item click.
                $('.hideall').attr('hidden',true);
                $('.'+eventid).removeAttr('hidden');
            });

            //------click skill checkbox -> insert to box right.
            $(".chk-select:checkbox").change(function (e) {
                eventid = this.id; // get id item click.
                eventvalue = $(this).closest('div').find("strong").text(); // get value item click.
                // alert(selectSkill.length);
                idcheckbox = eventid.substring(4, eventid.length);
                if(selectSkill.length < 20)
                {
                    //-----if exists in 'selectSkill' removed item in array and item design.
                    if( $.inArray( idcheckbox, selectSkill) > -1 ){
                        selectSkill.splice( $.inArray(idcheckbox, selectSkill), 1 );
                        $('#sub_lv1_'+idcheckbox).remove();
                        $('#selectcount').text((selectSkill.length)+'/20' );
                    }
                    else {
                        //---------array add -> id => checkbox is true.
                        if (this.checked == true) {
                            selectSkill.push(idcheckbox);
                            $('#mCSB_3_container').append('<div id="sub_lv1_' + idcheckbox + '" class="col-md-12 pretty p-icon p-curve p-tada mt-4" >\n' +
                                '                                                    <input id="sub_' + idcheckbox + '" class="sub-chk-select" type="checkbox" onclick="clickChkRemove('+idcheckbox+')">\n' +
                                '                                                    <div class="state p-primary-o">\n' +
                                '                                                        <i class="icon fa fa-check"></i>\n' +
                                '                                                        <label><strong>' + eventvalue + '</strong></label>\n' +
                                '                                                    </div>\n' +
                                '                                                </div>');
                            $('#sub_' + idcheckbox).prop('checked', true);
                            $('#selectcount').text((selectSkill.length)+'/20' );
                        }
                    }
                }
                else{
                    //----if count select=20 -> not allowed checked and insert in 'selectSkill'.
                    if(this.checked == true){
                        this.checked = false;
                    }

                    //-----if exists in 'selectSkill' removed item in array and item design.
                    if( $.inArray( idcheckbox, selectSkill ) > -1 ){
                        selectSkill.splice( $.inArray(idcheckbox, selectSkill), 1 );
                        $('#sub_lv1_'+idcheckbox).remove();
                        $('#selectcount').text((selectSkill.length)+'/20' );
                    }
                }
            });

        });


        //------click skill checkbox 'box right' --> remove current item clicked and remove item in 'middle box'.
        function clickChkRemove(id) {
            //-----if exists in 'selectSkill' removed item in array and item design.
            if ($.inArray(String(id), selectSkill) > -1) {
                selectSkill.splice($.inArray(String(id), selectSkill), 1);
                $('#chk_' + String(id)).prop('checked', false);
                $('#sub_lv1_'+String(id)).remove();
                $('#selectcount').text((selectSkill.length)+'/20' );
            }
        }

        function sendData() {
            var formData = $('#formSkillSend');
            $('#formSkillSend').append("<input name='data' type='hidden' value='"+selectSkill+"'/>");
            formData.submit();
        }
    </script>
@endsection
