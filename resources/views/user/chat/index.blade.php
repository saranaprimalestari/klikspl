@extends('user.layout')
@section('account')
    <h5 class="mb-4">Chat</h5>
    <div class="alert alert-danger fs-14" role="alert">
        Chat akan dihapus otomatis <strong> setelah 30 hari</strong> dari chat awal dimulai
    </div>
    <div class="card mb-3 border-radius-075rem fs-14 ">
        <div class="card-body p-4 px-0 px-sm-4">
            <div class="row m-0">
                <div class="col-12">
                    <div class="container p-0 mb-3">
                        <div class="row">
                            <div class="col-md-4 px-sm-0">
                                <div class="input-group me-3">
                                    <div class="input-group fs-14">
                                        <input type="text"
                                            class="form-control border-radius-075rem fs-14 shadow-none border-end-0"
                                            id="searchKeyword" placeholder="Cari chat..." aria-label="Cari chat..."
                                            aria-describedby="basic-addon2" name="search">
                                        <span class="input-group-text border-radius-075rem fs-14 bg-white border-start-0"
                                            id="basic-addon2"><i class="bi bi-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush inner-user-chat-all">
                        <div class="text-center my-5 py-5">
                            <div class="spinner-border text-secondary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="text-secondary">
                                Memuat chat...

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.chat.chat-modal')
    <input type="hidden" name="user_id_chat_all" value="{{ auth()->user()->id }}">
    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
    <script>
        $(window).on('load', function() {
            $('.inner-user-chat-send-data-needed').html('');
        });

        $(document).ready(function() {
            $('#searchKeyword').on("keyup", function() {
                var search = $('input[name="search"]').val().toLowerCase();
                $(".user-chat-all-container").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1);
                    // });
                });
            });

            window.userLatestChat = [];
            window.userUnreadTotal = 0;

            function scroll_to_recent_chat() {
                setTimeout(() => {
                    $(".inner-user-chat-modal").animate({
                        scrollTop: $(
                                ".inner-user-chat-modal").get(0)
                            .scrollHeight
                    }, 500);
                }, 1000);
            }

            function show_user_chat_container() {
                $('.user-chat-container').removeClass('d-none');
                $('.user-chat-container').addClass('d-block');
            }

            function hide_user_chat_container() {
                $('.user-chat-container').removeClass('d-block');
                $('.user-chat-container').addClass('d-none');
            }

            function clear_chat_modal() {
                window.csrfToken = '';
                window.userChatId = '';
                window.userIdUserChatPage = '';
                window.userProductId = '';
                window.userOrderId = '';
                window.userCompanyId = '';
                window.adminIdUserChatPage = '';
                console.log('clear chat modal');
                $('.inner-user-chat-modal').html('');
            }

            function run_load_chat() {
                run_interval =
                    setInterval(() => {
                        $.when(load_chat(window.csrfToken, window.userIdUserChatPage, window
                            .userProductId, window.userOrderId, window.adminIdUserChatPage, window
                            .userCompanyId)).done(function(response) {
                            console.log(response);
                            load_chat_user_page(response);
                        }).fail(function(data) {
                            load_chat_product_order_failed(data)
                        });
                    }, 2000);
            }

            function stop_load_chat() {
                clearInterval(run_interval);
                run_interval = null;
            }

            function user_chat_container_is_opened() {
                if ($('.user-chat-container').hasClass('d-block')) {
                    return true;
                } else {
                    return false;
                }
            }

            function close_modal_after_5_minutes() {
                if (user_chat_container_is_opened()) {
                    setTimeout(function() {
                        $(".user-chat-container").fadeOut(500);
                        stop_load_chat();
                        hide_user_chat_container();
                    }, 300000);
                }
            }

            function userChatTextareaFocus() {
                setTimeout(() => {
                    $('#chat_user_chat').focus();
                }, 500);
            }

            function load_chat_user_page(response) {
                console.log(response);
                console.log(response['chatHistory'][0]['id']);
                if (response['chatHistory'] != '') {

                    $('.chat-to-username-user').text(response['chatHistory'][0]['user'][
                        'username'
                    ]);

                    $('.inner-user-chat-modal').html('');
                    if (response['chatHistory'][0]['order_id'] != null) {
                        image = response['chatHistory'][0]['order']['orderitem'][0][
                            'orderproduct'
                        ][
                            'orderproductimage'
                        ][0]['name'];

                        if (response['chatHistory'][0]['order']['deleted_at'] != null) {
                            type = 'Pesanan Kedaluwarsa';
                        } else {
                            type = 'Pesanan';
                        }

                        if (response['chatHistory'][0]['order']['invoice_no'] != null) {
                            detail = response['chatHistory'][0]['order']['invoice_no'];
                        } else {
                            detail = 'No.Invoice belum terbit';
                        }
                    } else if (response['chatHistory'][0]['product_id'] != null) {
                        image = response['chatHistory'][0]['product']['productimage'][0][
                            'name'
                        ];
                        type = 'Tanya Produk';
                        detail = response['chatHistory'][0]['product']['name'];
                    }
                    imgURL = (new URL('/storage/' + image,
                        baseURL));

                    $('.chat-type').html(
                        '<div class="fw-600 ps-3 pb-2">' +
                        type +
                        '</div>' +
                        '<div class="card mx-3 border-radius-05rem fs-14 mb-2">' +
                        '<div class="card-body">' +
                        '<div class="row">' +
                        '<div class="col-2">' +
                        '<img id="main-image" class ="product-detail-img  border-radius-05rem" src="' +
                        imgURL + '" alt = "Foto Produk" width = "100%" > ' +
                        '</div>' +
                        '<div class="col-10 ps-0">' +
                        '<div class="chat-type-detail-name text-truncate">' +
                        detail +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');
                    $.each(response['chatHistory'], function(id, chats) {
                        $.each(chats['chat_message'], function(idChat, chat) {
                            if (chat['admin_id'] == null) {
                                if (chat['status'] == 0) {
                                    var check = 'bi bi-check2';
                                } else {
                                    var check = 'bi bi-check2-all';
                                }
                                $('.inner-user-chat-modal').append(
                                    '<div class = "row mx-0 justify-content-end mb-3" > ' +
                                    '<div class="col-8 bg-danger p-3 text-white border-radius-075rem">' +
                                    '<p class="m-0 mb-2">' + chat[
                                        'chat_message'] +
                                    '</p>' +
                                    '<div class="d-flex">' +
                                    '<div class="fs-11 m-0">' + moment(
                                        chat[
                                            'created_at']).fromNow() +
                                    '</div>' +
                                    '<div class="fs-14 ms-auto"><i class="' +
                                    check + '"></i></div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>');
                            } else {
                                $('.inner-user-chat-modal').append(
                                    '<div class = "row mx-0 mb-3" > ' +
                                    '<div class="col-8 bg-light p-3  border-radius-075rem">' +
                                    '<p class="m-0 mb-2">' + chat[
                                        'chat_message'] +
                                    '</p>' +
                                    '<p class="fs-11 m-0">' + moment(
                                        chat[
                                            'created_at']).fromNow() +
                                    '</p>' +
                                    '</div>' +
                                    '</div>');
                            }
                        });
                    });

                    window.chatLength = response['chatHistory'][0]['chat_message'].length;
                    if (window.chat < window.chatLength) {
                        window.chat = window.chatLength;
                        // chatNotificationRingtone();

                        // setTimeout(() => {
                        scroll_to_recent_chat();
                        // }, 1000);
                    }
                } else {
                    $('.inner-user-chat-modal').html(
                        '<div class="row mx-0 mb-3">' +
                        '<div class="col-12 text-center mt-5">' +
                        '<img class="cart-img" src="' + (new URL("/assets/klikspl-logo.png",
                            window.location.origin)) + '" alt="" width="100">' +
                        '<p class="text-muted py-3 px-2">' +
                        'Tanyakan terkait produk / pesanan di halaman ini ke ADMIN KLIKSPL' +
                        '</p>' +
                        '</div>' +
                        '</div>');
                }
                if (user_chat_container_is_opened()) {
                    update_chat_status(window.csrfToken, window.userIdUserChatPage, window.userProductId, window
                        .userOrderId, window.adminIdUserChatPage, window.userCompanyId);
                }
            }

            function send_chat_user_page(response) {
                console.log('sent chat : ');
                console.log(response);
                $("textarea[name='chat_user_chat']").val('');
                $(document).ready(function() {
                    console.log('launch once');
                    // setTimeout(() => {
                    //     console.log('slebew');
                    scroll_to_recent_chat();
                    // }, 500);
                });
                $.when(load_chat(window.csrfToken, window.userIdUserChatPage, window
                    .userProductId, window.userOrderId, window.adminIdUserChatPage, window
                    .userCompanyId)).done(function(response) {
                    console.log(response);
                    load_chat_user_page(response);
                    userChatTextareaFocus();
                }).fail(function(data) {
                    load_chat_product_order_failed(data)
                });

                $('.send-chat-spinner').addClass('d-none');
                $('.send-chat-spinner').removeClass('d-block');
                $('.send-chat-icon').removeClass('d-none');
                $('.send-chat-page-button').attr('disabled', false);
            }

            function load_chat_all(csrfToken, userId) {
                $.ajax({
                    // url: "{!! route('load.admin.chat.all') !!}",
                    url: window.location.origin + "/userloadchatall",
                    type: 'get',
                    data: {
                        _token: csrfToken,
                        user_id: userId,
                    },
                    success: function(response) {
                        if (response != '') {
                            console.log(response);
                            $('.inner-user-chat-all').html('');
                            $.each(response, function(id, chatResponse) {
                                // console.log(chatResponse);
                                // console.log(chatResponse['id']);
                                var unread = 0;
                                var userLatestChatUnreadSum = 0;
                                var userLatestChatUnreadValues = [];
                                $.each(chatResponse['chat_message'], function(
                                    idChatUnique,
                                    chatUnique) {
                                    if (chatUnique['status'] == 0 &&
                                        chatUnique['admin_id'] != null
                                    ) {
                                        unread += 1;
                                        window.userLatestChat[chatResponse['id']] =
                                            unread;
                                    } else {
                                        window.userLatestChat[chatResponse['id']] =
                                            unread;
                                    }
                                });
                                setTimeout(() => {
                                    userLatestChatUnreadValues = Object.values(window
                                        .userLatestChat);
                                    userLatestChatUnreadSum = userLatestChatUnreadValues
                                        .reduce((
                                            accumulator, value) => {
                                            return accumulator + value;
                                        }, 0);

                                    // console.log('latestChatUnreadSum : ' + userLatestChatUnreadSum);
                                    // console.log('userUnreadtotal : ' + window.userUnreadTotal);
                                    if (window.userUnreadTotal !=
                                        userLatestChatUnreadSum) {
                                        if (userLatestChatUnreadSum >= window
                                            .userUnreadTotal &&
                                            window
                                            .userUnreadTotal != 0) {
                                            chatNotificationRingtone();
                                        }
                                        window.userUnreadTotal =
                                            userLatestChatUnreadSum;
                                        // chatNotificationRingtone();
                                    }
                                }, 500);

                                if (chatResponse['order'] != null) {
                                    image = chatResponse['order']['orderitem'][0][
                                        'orderproduct'
                                    ]['orderproductimage'][0]['name'];

                                    if (chatResponse['order']['deleted_at'] != null) {
                                        type = 'Pesanan Kedaluwarsa';
                                    } else {
                                        type = 'Pesanan';
                                    }

                                    if (chatResponse['order']['invoice_no'] != null) {
                                        detail = chatResponse['order']['invoice_no'];
                                    } else {
                                        detail = 'No.Invoice belum terbit';
                                    }
                                } else if (chatResponse['product_id'] != null) {
                                    image = chatResponse['product']['productimage'][0][
                                        'name'
                                    ];
                                    type = 'Tanya Produk';
                                    detail = chatResponse['product']['name'];
                                }

                                imgURL = (new URL('/storage/' + image,
                                    baseURL));

                                var badge = '';
                                if (unread != 0) {
                                    var badge =
                                        '<div class="col-2 col-sm-1 text-end">' +
                                        '<span class=" unread-user-chat-badge-' +
                                        chatResponse['id'] +
                                        ' badge bg-danger rounded-pill" data-id="' +
                                        chatResponse['id'] + '">' +
                                        unread +
                                        '</span>' +
                                        '</div>';
                                }
                                lastChat = chatResponse['chat_message'][chatResponse[
                                    'chat_message'].length - 1];
                                // console.log(lastChat);

                                var is_sent_read = '';

                                if (lastChat['admin_id'] == null) {
                                    // console.log(lastChat['admin_id']);
                                    if (lastChat['status'] == 0) {
                                        is_sent_read = '<i class="me-1 bi bi-check2"></i>'
                                    } else {
                                        is_sent_read = '<i class="me-1 bi bi-check2-all"></i>'
                                    }
                                }
                                if ((chatResponse['order_id'] != null && chatResponse[
                                        'order'] != null) || (chatResponse['product_id'] !=
                                        null && chatResponse['product'] != null)) {
                                    $('.inner-user-chat-all').append(
                                        '<button type="button" class="inner-user-chat-list list-group-item list-group-item-action user-chat-all-container px-0"aria-current="true" data-id="' +
                                        chatResponse['id'] + '" data-uid="' +
                                        chatResponse['user_id'] + '" data-pid="' +
                                        chatResponse['product_id'] + '" data-oid="' +
                                        chatResponse['order_id'] + '" data-cid="' +
                                        chatResponse['company_id'] + '" data-aid="' +
                                        chatResponse['admin_id'] + '">' +
                                        '<div class="row align-items-center m-0">' +
                                        '<div class="col-lg-1 col-md-2 col-2 px-0 px-sm-2">' +
                                        '<img class="img-fluid w-100 border-radius-05rem" src="' +
                                        imgURL + '" alt="" width="20">' +
                                        '</div>' +
                                        '<div class="col-lg-10 col-md-9 col-8">' +
                                        '<div class="ps-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="">' +
                                        '<div class="fw-600 m-0 text-truncate" data-bs-toggle="tooltip" data-bs-placement="bottom" title="' +
                                        ' [' + type + ' - ' + detail + ']' + '">' +
                                        chatResponse['user']['username'] +
                                        ' [' + type + ' - ' + detail + ']' +
                                        '</div>' +
                                        '<div class="fs-12 text-truncate">' +
                                        is_sent_read +
                                        chatResponse['chat_message'][chatResponse[
                                            'chat_message'].length - 1][
                                            'chat_message'
                                        ] +
                                        '</div>' +
                                        '<div class="fs-12 text-secondary">' +
                                        moment(chatResponse['chat_message'][
                                            chatResponse[
                                                'chat_message'].length - 1
                                        ]['created_at'])
                                        .fromNow() +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        badge +
                                        '</div>' +
                                        '</button>'
                                    );
                                }
                            });
                        } else {
                            $('.inner-user-chat-all').html('');
                            $('.inner-user-chat-all').html(
                                '<div class="row mx-0 mb-3">' +
                                '<div class="col-12 text-center mt-5">' +
                                '<img class="cart-items-logo" src="' + (new URL(
                                    "/assets/klikspl-logo.png",
                                    window.location.origin)) + '" alt="" width="100">' +
                                '<p class="text-muted py-3 px-2">' +
                                'Belum ada chat untuk anda saat ini' +
                                '</p>' +
                                '</div>' +
                                '</div>'
                            );

                        }
                    },
                    dataType: "json"
                });
            }

            window.userIdAll = $("input[name='user_id_chat_all']").val();
            console.log(userIdAll);
            console.log($("input[name='csrf_token']").val());
            load_chat_all(window.csrfToken, window.userIdAll);

            setInterval(function() {
                if (typeof(window.userIdAll) !== 'undefined') {
                    load_chat_all(window.csrfToken, window.userIdAll);
                }
            }, 5000);


            window.chatLength = 0;
            window.chat = 0;
            $('body').on('click', '.inner-user-chat-list', function() {
                if ($('.user-chat-container').hasClass('d-none')) {

                    clear_chat_modal();

                    userChatTextareaFocus();

                    window.csrfToken = $('meta[name="csrf-token"]').attr('content');
                    window.userChatId = ($(this).data('id'));
                    window.userIdUserChatPage = ($(this).data('uid'));
                    window.userProductId = ($(this).data('pid'));
                    window.userOrderId = ($(this).data('oid'));
                    window.userCompanyId = ($(this).data('cid'));
                    window.adminIdUserChatPage = ($(this).data('aid'));

                    console.log(window.csrfToken);
                    console.log(window.userChatId);
                    console.log(window.userIdUserChatPage);
                    console.log(window.userProductId);
                    console.log(window.userOrderId);
                    console.log(window.userCompanyId);
                    console.log(window.adminIdUserChatPage);

                    $('input[name="chat_id_user_chat"]').val(window.userChatId);
                    $('input[name="order_id_user_chat"]').val(window.userOrderId);
                    $('input[name="product_id_user_chat"]').val(window.userProductId);

                    $.when(load_chat(window.csrfToken, window.userIdUserChatPage, window
                        .userProductId, window.userOrderId, window.adminIdUserChatPage, window
                        .userCompanyId)).done(function(response) {
                        console.log(response);
                        load_chat_user_page(response);
                    }).fail(function(data) {
                        load_chat_product_order_failed(data)
                    });


                    console.log('chat : ' + chat);
                    console.log('chat length : ' + window.chatLength);

                    update_chat_status(window.csrfToken, window.userIdUserChatPage, window.userProductId,
                        window.userOrderId, window.adminIdUserChatPage, window.userCompanyId);

                    run_load_chat();
                    show_user_chat_container();

                    // setTimeout(() => {
                    //     console.log('slebew');
                    scroll_to_recent_chat();
                    // }, 1000);
                    close_modal_after_5_minutes();

                } else {
                    stop_load_chat();
                    hide_user_chat_container();
                    clear_chat_modal();

                }
            });

            $('body').on('click', '.user-chat-page-close-button', function() {
                stop_load_chat();
                clear_chat_modal();
                if ($('.user-chat-container').hasClass('d-block')) {
                    hide_user_chat_container();
                }
            });

            $('.send-chat-page-button').on('click', function() {
                console.log('sending chat...');
                window.userChat = $("textarea[name='chat_user_chat']").val();

                if (window.chat != null && window.chat != '') {
                    $.when(send_chat(window.csrfToken, window.userIdUserChatPage, window.userProductId,
                        window.userOrderId, window.adminIdUserChatPage, window.userCompanyId, window
                        .userChat)).done(function(response) {
                        send_chat_user_page(response);
                    }).fail(function(data) {
                        send_chat_product_order_failed(data)
                    });
                    $('.send-chat-icon').addClass('d-none');
                    $('.send-chat-spinner').removeClass('d-none');
                    // $('.send-chat-spinner').addClass('d-block');
                    $('.send-chat-page-button').attr('disabled', true);

                } else {
                    alert('chat tidak boleh kosong!');
                }
            });
        });
    </script>
@endsection
