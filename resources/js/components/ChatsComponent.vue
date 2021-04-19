<template>
    <div class="row">
        <div class="col-md-8 message-box" style="visibility: hidden;">
            <div class="card-header card-header-meesage">Message</div>
            <input type="hidden" name="target_user_id" id="target_user_id" value="">
            <div class="chat-conversation card-body p-0" style="background-color: white;">
                <ul class="list-unstyled conversation-list" style="height: 300px; overflow-y: scroll" v-chat-scroll="{smooth: true}">
                    <li v-for="(message, index) in messages" :key="index" :class="'m-b-5 clearfix p-2 chat_li_id' + message.user.id">
                        <div class="chat-avatar">
                            <i>{{ message.user.user_profile.name }} {{ message.user.user_profile.family }}</i>
                        </div>
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <span style="font-size: 9px; color:#a6a6a6;">{{ message.created_at}}</span>
                                <p v-html="message.message"></p>
                                <!--<p v-show="message.visit" class="chat-tick"><i class="fa fa-check text-success"></i></p>-->
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- input and file box -->
            <div class="row">
                <div class="col-md-11">
                    <input
                        @keydown="sendTypingEvent"
                        @keyup.enter="sendMessage"
                        v-model="newMessage"
                        type="text"
                        name="message"
                        id="message"
                        placeholder="Enter your message ..."
                        class="form-control">
                </div>
                <div class="col-md-1">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                <b class="fa fa-link"></b>
                                <input type="file" name="file" id="file" class="imgInp">
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- User list -->
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-header">Chat history</div>
                <div class="card-body">
                    <ul>
                        <li style="list-style: none">
                            <span class="text-muted" v-if="activeUser">{{ activeUser.user_profile.name }} {{ activeUser.user_profile.family }} user is typing...</span>&nbsp;
                        </li>
                        <li class="py-2" v-for="(user, index) in history_users" :key="index"
                            :class="'click_li_uid li_uid' + user.id" style="cursor: pointer; list-style: none" @click="fetchMessages(user.id)">

                            <img v-if="user.img_user" :src="user.img_user" alt="" style="width: 50px; padding-right: 5px;">

                            <span :id="'uid' + user.id">{{ user.user_profile_img.name }} {{ user.user_profile_img.family }}</span>

                            <div :id="'mc' + user.id" style="background: #00B405; padding-top: 2%; font-size: 10px; font-weight: bold; margin: 0 8px; color: #fff;
                            border-radius: 20px; width: 20px; height: 20px; display: inline-grid; text-align: center; line-height: 1;"
                                 v-show="user.message_count">{{ user.message_count }}</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    $(document).ready(function () {
        var tuid = getUrlParameter('id');
        if (tuid) $('.message-box').css('visibility', 'unset');
        $('#target_user_id').val(tuid);

        setInterval(function(){
            $('.chat_li_id' + $('#target_user_id').val()).addClass('odd');
        }, 50);

        /* start input upload */
        $(document).on('change', '.btn-file :file', function () {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function (event, label) {
/*            var input = $('#message'),
                log = label;
            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }*/
        });

        $(".imgInp").change(function () {
            var inputElement = this;
            console.log(inputElement.files[0]);
            if (inputElement.files && inputElement.files[0]) {
                // var formData = new FormData();
                // formData.append('file', $('#file')[0].files[0]);
                /*            $.ajax({
                                url : 'upload.php',
                                type : 'POST',
                                data : formData,
                                processData: false,  // tell jQuery not to process the data
                                contentType: false,  // tell jQuery not to set contentType
                                success : function(data) {
                                    console.log(data);
                                    alert(data);
                                }
                            });*/
            }
        });
        /* end input upload */
    });
    export default {
        props: ['user'],

        data() {
            return {
                messages: [],
                history_users: [],
                newMessage: '',
                users: [],
                activeUser: false,
                activeUserId: false,
                typingTimer: false,
            }
        },
        created() {
            this.fetchHistoryUser();

            /* fetchMessages if set url id parameter */
            // tuid = target user id
            var tuid = getUrlParameter('id');
            if (tuid) {
                this.fetchMessages(tuid);
            }

            Echo.join('chat')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    // $('.li_uid' + user.id).css('color', '#005FB4');
                    this.users.push(user);
                })
                .leaving(user => {
                    $('.li_uid' + user.id).css('color', 'black');
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listen('MessageSent', (event) => {
                    if (event.message.user_id == this.activeUserId) {
                        this.messages.push(event.message);
                        axios.post('seemessages', {id: event.message.id}).then(response => {});
                    } else {
                        $('#mc' + event.message.user_id).html(parseInt($('#mc' + event.message.user_id).html()) + 1);
                        $('#mc' + event.message.user_id).css('display', 'inline-grid');
                    }
                })
                .listenForWhisper('typing', user => {
                    this.activeUser = user;

                    this.typingTimer = setTimeout(() => {
                        this.activeUser = false;
                        if (this.typingTimer) {
                            clearTimeout(this.typingTimer);
                        }
                    }, 3000);
                });
        },

        methods: {
            fetchMessages(id) {
                this.activeUserId = id;
                $('#target_user_id').val(id);
                $('#mc' + id).html(0);
                $('#mc' + id).css('display', 'none');
                $('.message-box').css('visibility', 'unset');
                $('.card-header-meesage').html($('#uid' + id).html());

                axios.post('getmessages', {target_user_id: id}).then(response => {
                    this.messages = response.data;
                });
            },

            fetchHistoryUser() {
                axios.get('getHistoryUser').then(response => {
                    this.history_users = response.data;
                });
            },

            sendMessage() {
                var target_user_id = $('#target_user_id').val();
                if (target_user_id && this.newMessage) {
                    this.messages.push({
                        user: this.user,
                        message: this.newMessage
                    });
                    axios.post('messages', {message: this.newMessage, target_user_id: target_user_id});
                    this.newMessage = '';
                }
            },

            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing', this.user);
            }
        }
    }

    /* get url parameters */
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };
</script>
