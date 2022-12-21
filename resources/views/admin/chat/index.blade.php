@extends('admin.layouts.main')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Chat</h1>
        </a>
    </div>
    <div class="card mb-3 border-radius-1-5rem fs-14 border-0">
        <div class="card-body p-4 px-0 px-sm-4">
            <div class="row m-1">
                <div class="col-12">
                    <div class="container p-0 mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group me-3">
                                    <div class="input-group fs-14">
                                        <input type="text"
                                            class="form-control border-radius-1-75rem fs-14 shadow-none border-end-0"
                                            id="searchKeyword" placeholder="Cari username atau chat..."
                                            aria-label="Cari username atau chat..." aria-describedby="basic-addon2"
                                            name="search">
                                        <span class="input-group-text border-radius-1-75rem fs-14 bg-white border-start-0"
                                            id="basic-addon2"><i class="bi bi-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush inner-admin-chat-all">
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

    <div class="container fs-14 admin-chat-container d-none">
        <div class="row">
            <div class="col-10 col-md-10 col-lg-4 admin-chat-modal position-fixed p-0">
                <div class="card border-radius-075rem box-shadows">
                    <div class="card-header bg-transparent border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div class="d-flex text-red-klikspl fw-600">
                                <i class="bi bi-chat-dots"></i>
                                {{-- <img src="{{ asset('/assets/avatars.png') }}" alt=""> --}}
                                <div class="ms-2 chat-to-username-user">
                                    Chat User
                                </div>
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-danger fs-14 admin-chat-close-button p-0 px-2 py-1">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="chat-type">
                        </div>
                        <div class="inner-admin-chat-modal p-3 overflow-auto">
                            <div class="row mx-0 mb-3">
                                <div class="col-12 text-center mt-5">
                                    <img class="cart-img" src="{{ asset('/assets/klikspl-logo.png') }}" alt=""
                                        width="100">
                                    <p class="text-muted py-3 px-2">
                                        Tanyakan terkait produk di halaman ini ke ADMIN KLIKSPL
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="admin-chat-send px-3 pt-2 pb-3">
                            <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="admin_id_admin_chat" value="{{ auth()->guard('adminMiddle')->user()->id }}">
                            <input type="hidden" name="order_id_admin_chat" value="">
                            <input type="hidden" name="product_id_admin_chat" value="">
                            <input type="hidden" name="chat_id_admin_chat" value="">
                            <input type="hidden" name="company_id_admin_chat" value="{{ auth()->guard('adminMiddle')->user()->company_id }}">
                            <textarea class="form-control fs-14 mb-3 shadow-none" name="chat_admin_chat" id="chat_admin_chat" rows="2" required></textarea>
                            <div class="text-end">
                                <button type="button" class="btn btn-danger bg-red-klikspl fs-14 send-chat-button">
                                    <div class="spinner-border spinner-border-sm send-chat-spinner d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <i class="send-chat-icon bi bi-send"></i>
                                    <span>
                                        Kirim
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input id="admin-company-id" type="hidden" name="company_id"
        value="{{ auth()->guard('adminMiddle')->user()->company_id }}">
    <input id="admin-id" type="hidden" name="admin_id" value="{{ auth()->guard('adminMiddle')->user()->id }}">
    <script>
        $(document).ready(function() {
            $('#searchKeyword').on("keyup", function() {
                var search = $('input[name="search"]').val().toLowerCase();
                $(".chat-all-container").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(search) > -1);
                    // });
                });
            });

            window.chatLength = 0;
            window.chat = 0;
            $('body').on('click', '.inner-admin-chat-list', function() {
                if ($('.admin-chat-container').hasClass('d-none')) {

                    clear_chat_modal();

                    window.csrfToken = $('meta[name="csrf-token"]').attr('content');
                    window.adminChatId = ($(this).data('id'));
                    window.adminUserId = ($(this).data('uid'));
                    window.adminProductId = ($(this).data('pid'));
                    window.adminOrderId = ($(this).data('oid'));
                    window.adminCompanyId = ($(this).data('cid'));
                    window.adminId = $('#admin-id').val();

                    $('input[name="chat_id_admin_chat"]').val(window.adminChatId);
                    $('input[name="order_id_admin_chat"]').val(window.adminOrderId);
                    $('input[name="product_id_admin_chat"]').val(window.adminProductId);

                    load_admin_chat_modal(window.csrfToken, window.adminChatId, window.adminUserId, window
                        .adminProductId, window.adminOrderId, window.adminId, window.adminCompanyId);

                    console.log('chat : ' + chat);
                    console.log('chat length : ' + window.chatLength);

                    update_admin_chat_status(window.csrfToken, window.adminChatId, window.adminUserId,
                        window
                        .adminProductId, window.adminOrderId, window.adminId, window.adminCompanyId);

                    run_load_chat();
                    show_admin_chat_container();

                    // setTimeout(() => {
                    //     console.log('slebew');
                    scroll_to_recent_chat();
                    // }, 1000);
                    close_modal_after_5_minutes();

                } else {
                    stop_load_chat();
                    hide_admin_chat_container();
                    clear_chat_modal();

                }
            });

            $('body').on('click', '.admin-chat-close-button', function() {
                stop_load_chat();
                clear_chat_modal();
                if ($('.admin-chat-container').hasClass('d-block')) {
                    hide_admin_chat_container();
                }
            });

            $('.send-chat-button').on('click', function() {
                console.log('sending chat...');
                window.adminChat = $("textarea[name='chat_admin_chat']").val();

                if (window.chat != null && window.chat != '') {
                    send_admin_chat(window.csrfToken, window.adminChatId, window.adminUserId, window
                        .adminProductId, window.adminOrderId, window.adminId, window.adminCompanyId,
                        window.adminChat);
                    $('.send-chat-icon').addClass('d-none');
                    $('.send-chat-spinner').removeClass('d-none');
                    // $('.send-chat-spinner').addClass('d-block');
                    $('.send-chat-button').attr('disabled', true);

                } else {
                    alert('chat tidak boleh kosong!');
                }
            });

            function scroll_to_recent_chat() {
                setTimeout(() => {
                    $(".inner-admin-chat-modal").animate({
                        scrollTop: $(
                                ".inner-admin-chat-modal").get(0)
                            .scrollHeight
                    }, 500);
                }, 1000);
            }

            function show_admin_chat_container() {
                $('.admin-chat-container').removeClass('d-none');
                $('.admin-chat-container').addClass('d-block');
            }

            function hide_admin_chat_container() {
                $('.admin-chat-container').removeClass('d-block');
                $('.admin-chat-container').addClass('d-none');
            }

            function clear_chat_modal() {
                window.csrfToken = '';
                window.adminChatId = '';
                window.adminUserId = '';
                window.adminProductId = '';
                window.adminOrderId = '';
                window.adminCompanyId = '';
                window.adminId = '';
                console.log('clear chat modal');
                $('.inner-admin-chat-modal').html('');
            }

            function run_load_chat() {
                run_interval =
                    setInterval(() => {
                        load_admin_chat_modal(window.csrfToken, window.adminChatId, window.adminUserId, window
                            .adminProductId, window.adminOrderId, window.adminId, window.adminCompanyId);
                        console.log(window.chat);
                        console.log(window.chatLength);

                    }, 2000);
            }

            function stop_load_chat() {
                clearInterval(run_interval);
                run_interval = null;
            }

            function admin_chat_container_is_opened() {
                if ($('.admin-chat-container').hasClass('d-block')) {
                    return true;
                } else {
                    return false;
                }
            }

            function close_modal_after_5_minutes(){
                if(admin_chat_container_is_opened()){
                    setTimeout(function() {
                         $(".admin-chat-container").fadeOut(500); 
                         stop_load_chat();
                         hide_admin_chat_container();
                        }, 300000);
                }
            }
            function load_admin_chat_modal(csrfToken, adminChatId, adminUserId, adminProductId, adminOrderId,
                adminId, adminCompanyId) {
                $.ajax({
                    // url: "{{ url('/userloadchat') }}",
                    url: window.location.origin + "/administrator/adminchatmessage/loadadminchatmodal",
                    type: 'get',
                    data: {
                        _token: csrfToken,
                        id: adminChatId,
                        user_id: adminUserId,
                        product_id: adminProductId,
                        order_id: adminOrderId,
                        admin_id: adminId,
                        company_id: adminCompanyId,
                        // chat_message: chat,
                    },
                    success: function(response) {
                        console.log(response);
                        console.log(response['chatHistory'][0]['id']);
                        if (response['chatHistory'] != '') {

                            $('.chat-to-username-user').text(response['chatHistory'][0]['user'][
                                'username'
                            ]);

                            $('.inner-admin-chat-modal').html('');
                            if (response['chatHistory'][0]['order_id'] != null) {
                                image = response['chatHistory'][0]['order']['orderitem'][0][
                                    'orderproduct'
                                ][
                                    'orderproductimage'
                                ][0]['name'];
                                type = 'Pesanan';
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
                                '<div class="chat-type-detail-name">' +
                                detail +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>');
                            $.each(response['chatHistory'], function(id, chats) {
                                $.each(chats['chat_message'], function(idChat, chat) {
                                    if (chat['admin_id'] == null) {
                                        $('.inner-admin-chat-modal').append(
                                            '<div class = "row mx-0 mb-3" > ' +
                                            '<div class="col-8 bg-success p-3 text-white border-radius-075rem">' +
                                            '<p class="m-0 mb-2">' + chat[
                                                'chat_message'] +
                                            '</p>' +
                                            '<p class="fs-11 m-0">' + moment(
                                                chat[
                                                    'created_at']).fromNow() +
                                            '</p>' +
                                            '</div>' +
                                            '</div>');
                                    } else {
                                        if (chat['status'] == 0) {
                                            var check = 'bi bi-check2';
                                        } else {
                                            var check = 'bi bi-check2-all';
                                        }
                                        $('.inner-admin-chat-modal').append(
                                            '<div class = "row mx-0 justify-content-end mb-3" > ' +
                                            '<div class="col-8 bg-danger p-3 text-white border-radius-075rem">' +
                                            '<div class="m-0 mb-1 fw-600">' + chats['admin']['username'] +
                                            '</div>' +
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
                                    }
                                });
                            });

                            window.chatLength = response['chatHistory'][0]['chat_message'].length;
                            if (window.chat < window.chatLength) {
                                window.chat = window.chatLength;
                                // setTimeout(() => {
                                scroll_to_recent_chat();
                                // }, 1000);
                            }
                        } else {
                            $('.inner-admin-chat-modal').html(
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
                        if (admin_chat_container_is_opened()) {
                            update_admin_chat_status(window.csrfToken, window.adminChatId, window
                                .adminUserId,
                                window
                                .adminProductId, window.adminOrderId, window.adminId, window
                                .adminCompanyId);
                        }
                    },
                    dataType: "json"
                });
            }

            function send_admin_chat(csrfToken, adminChatId, adminUserId, adminProductId, adminOrderId,
                adminId, adminCompanyId, adminChat) {
                $.ajax({
                    url: window.location.origin + "/administrator/adminchatmessage/sendadminchatmodal",
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        id: adminChatId,
                        user_id: adminUserId,
                        product_id: adminProductId,
                        order_id: adminOrderId,
                        admin_id: adminId,
                        company_id: adminCompanyId,
                        chat_message: adminChat,
                    },
                    success: function(response) {
                        console.log('sent chat : ');
                        console.log(response);
                        $("textarea[name='chat_admin_chat']").val('');
                        $(document).ready(function() {
                            console.log('launch once');
                            // setTimeout(() => {
                            //     console.log('slebew');
                            scroll_to_recent_chat();
                            // }, 500);
                        });

                        load_admin_chat_modal(window.csrfToken, window.adminChatId, window.adminUserId,
                            window
                            .adminProductId, window.adminOrderId, window.adminId, window
                            .adminCompanyId);

                        $('.send-chat-spinner').addClass('d-none');
                        $('.send-chat-spinner').removeClass('d-block');
                        $('.send-chat-icon').removeClass('d-none');
                        $('.send-chat-button').attr('disabled', false);
                    },
                    dataType: "json"
                });
            }

        });
    </script>
@endsection
