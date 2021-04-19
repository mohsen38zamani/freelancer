$(document).ready(function () {
    $('#dLabel1').click(function () {
        $('#txt_search').val('');
        clear_freelancer();
        clear_project();
    });

    $(document).keypress(function(e) {
        var word = $('#txt_search').val();
        if(e.which == 13 && word) {
            search(word);
        }
    });

    $('#btn_search').click(function () {
        var word = $('#txt_search').val();
        search(word);
    });

    function search(word) {
        var formData = new FormData();
        formData.append('_token', csrf_token);
        formData.append('word', word);

        $.ajax({
            url: '/public_search',
            type: 'POST',
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (result) {
                if (result.freelancers.length){
                    $('.f_search_item_list').remove();
                    $.each(result.freelancers, function (index, item) {
                        var url = url_profile + item.username;
                        if(item.attachment){
                            var img = public_address + item.attachment.path;
                        } else {
                            var img = img_default;
                        }
                        var child = '<li class="f_search_item_list">\n' +
                            '            <a href="'+ url +'" class="f_search_item_link">\n' +
                            '                <div class="col-md-2 col-sm-2 col-xs-2 m-t-5">\n' +
                            '                    <img\n' +
                            '                        src="'+ img +'"\n' +
                            '                        class="img-responsive display-inline-block f_search_item_img"\n' +
                            '                        alt="'+ item.name + ' ' + item.family +'">\n' +
                            '                </div>\n' +
                            '                <div class="col-md-10 m-t-8">\n' +
                            '                    <b class="f_search_item_name">'+ item.name + ' ' + item.family +'</b>\n' +
                            '                    <p class="f_search_item_description">'+ item.description +'</p>\n' +
                            '                </div>\n' +
                            '            </a>\n' +
                            '        </li>';
                        // console.log(item);
                        $('.f_search_list').append(child);
                    });
                    var href = $('.f_lbl_more').attr('data-href');
                    $('.f_lbl_more').attr('href', href + '?p=' + $('#txt_search').val());
                } else {
                    clear_freelancer();
                }

                if (result.projects.length){
                    $('.p_search_item_list').remove();
                    $.each(result.projects, function (index, item) {
                        var url = url_project + item.projectid;
                        var child = '<li class="p_search_item_list">\n' +
                            '            <a href="'+ url +'" class="p_search_item_link">\n' +
                            '                <div class="col-md-2 m-t-5">\n' +
                            '                    <i class="fa fa-desktop fa-2x p-t-10 cursor-p"></i>\n' +
                            '                </div>\n' +
                            '                <div class="col-md-10 m-t-8">\n' +
                            '                    <b class="p_search_item_name">'+ item.name + '</b>\n' +
                            '                    <p class="p_search_item_description">'+ item.description +'</p>\n' +
                            '                </div>\n' +
                            '            </a>\n' +
                            '        </li>';
                        // console.log(item);
                        $('.p_search_list').append(child);
                    });
                    var href = $('.p_lbl_more').attr('data-href');
                    $('.p_lbl_more').attr('href', href + '?p=' + $('#txt_search').val());
                } else {
                    clear_project();
                }
            }
        });
    }

    function clear_freelancer() {
        $('.f_search_item_list').remove();
        var child = '<li class="f_search_item_list">\n' +
            '            <a href="" class="f_search_item_link">\n' +
            '                <div class="col-md-2 col-sm-2 col-xs-2 m-t-5">\n' +
            '                    <img\n' +
            '                        src="'+ img_default +'"\n' +
            '                        class="img-responsive display-inline-block f_search_item_img"\n' +
            '                        alt="">\n' +
            '                </div>\n' +
            '                <div class="col-md-10 m-t-8">\n' +
            '                    <b class="f_search_item_name"></b>\n' +
            '                    <p class="f_search_item_description">'+ message_tr +'</p>\n' +
            '                </div>\n' +
            '            </a>\n' +
            '        </li>';
        $('.f_search_list').append(child);
        var href = $('.f_lbl_more').attr('data-href');
        $('.f_lbl_more').attr('href', href);
    }

    function clear_project() {
        $('.p_search_item_list').remove();
        var child ='<li class="p_search_item_list">\n' +
            '            <a href="" class="p_search_item_link">\n' +
            '                <div class="col-md-2 m-t-5">\n' +
            '                    <i class="fa fa-desktop fa-2x p-t-10 cursor-p"></i>\n' +
            '                </div>\n' +
            '                <div class="col-md-10 m-t-8">\n' +
            '                    <b class="p_search_item_name"></b>\n' +
            '                    <p class="p_search_item_description">'+ message_tr +'</p>\n' +
            '                </div>\n' +
            '            </a>\n' +
            '       </li>';
        $('.p_search_list').append(child);
        var href = $('.p_lbl_more').attr('data-href');
        $('.p_lbl_more').attr('href', href);}
});
