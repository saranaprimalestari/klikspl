var baseURL = 'http://klikspl.test/';

$(document).ready(function() {
    window.company_id = $('#admin-company-id').val();
    window.adminId = $('#admin-id').val();
    window.onChatPage = $('#on-chat-page').val();

    if ((typeof(window.company_id) !== 'undefined' || typeof(window.adminId) !== 'undefined')) {
        if (typeof(window.onChatPage) !== 'undefined') {
            load_chat_admin_all($('meta[name="csrf-token"]').attr('content'), window.company_id);
            delete_admin_chat_automatically($('meta[name="csrf-token"]').attr('content'), window.company_id);

            setInterval(() => {
                load_chat_admin_all($('meta[name="csrf-token"]').attr('content'), window.company_id);
            }, 5500);
        } else {
            setInterval(() => {
                load_chat_admin_all($('meta[name="csrf-token"]').attr('content'), window.company_id);
            }, 10000);

        }
    }


});
window.latestChat = [];
window.unreadTotal = 0;

function load_chat_admin_all(csrfToken, companyId) {
    $.ajax({
        // url: "{!! route('load.admin.chat.all') !!}",
        url: window.location.origin + "/administrator/adminchatmessage/loadadminchatall",
        type: 'get',
        data: {
            _token: csrfToken,
            company_id: companyId,
        },
        success: function(response) {
            if (response != '') {
                console.log(response);
                $('.inner-admin-chat-all').html('');
                // var latestChat = [];
                $.each(response, function(id, chatResponse) {
                    // console.log(chatResponse);
                    // console.log(chatResponse['id']);
                    var unread = 0;
                    var chatUnread = 0;
                    var latestChatUnreadSum = 0;
                    var latestChatUnreadValues = [];
                    $.each(chatResponse['chat_message'], function(idChatUnique,
                        chatUnique) {
                        if (chatUnique['status'] == 0 &&
                            chatUnique['admin_id'] == null
                        ) {
                            unread += 1;
                            // ids = chatResponse['id'];
                            // console.log(ids);
                            // element = { ids: unread };
                            window.latestChat[chatResponse['id']] = unread;
                            // chatNotificationRingtone();
                        } else {
                            // ids = chatResponse['id'];
                            // element = { ids: unread };
                            window.latestChat[chatResponse['id']] = unread;
                        }
                    });
                    setTimeout(() => {
                        latestChatUnreadValues = Object.values(window.latestChat);
                        latestChatUnreadSum = latestChatUnreadValues.reduce((accumulator, value) => {
                            return accumulator + value;
                        }, 0);
                        console.log(window.latestChat);
                        console.log(latestChatUnreadValues);

                        for (let i = 0; i < latestChatUnreadValues.length; i++) {
                            if (latestChatUnreadValues[i] > 0) {
                                chatUnread += 1;
                            }
                        }
                        // console.log('latestChatUnreadSum : ' + latestChatUnreadSum);
                        // console.log('unreadtotal : ' + window.unreadTotal);
                        if (window.unreadTotal != latestChatUnreadSum) {
                            if (latestChatUnreadSum >= window.unreadTotal && window.unreadTotal != 0) {
                                // console.log('-- latestChatUnreadSum : ' + latestChatUnreadSum);
                                // console.log('-- unreadtotal : ' + window.unreadTotal);
                                chatNotificationRingtone();
                            }
                            window.unreadTotal = latestChatUnreadSum;
                        }
                        if (latestChatUnreadSum > 0) {
                            $('.chat-sidebar-badge').html('<span class="badge bg-danger d-inline-block">' + chatUnread + '</span>');
                        }
                    }, 500);

                    if (chatResponse['order'] != null) {
                        image = chatResponse['order']['orderitem'][0]['orderproduct']['orderproductimage'][0]['name'];

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
                        image = chatResponse['product']['productimage'][0]['name'];
                        type = 'Tanya Produk';
                        detail = chatResponse['product']['name'];
                    }

                    imgURL = (new URL('/storage/' + image,
                        baseURL));

                    var badge = '';
                    if (unread != 0) {
                        var badge = '<div class="col-2 col-sm-1 text-end">' +
                            '<span class=" unread-admin-chat-badge-' +
                            chatResponse['id'] + ' badge bg-danger rounded-pill" data-id="' +
                            chatResponse['id'] + '">' +
                            unread +
                            '</span>' +
                            '</div>';
                    }
                    var lastChat = chatResponse['chat_message'][chatResponse['chat_message'].length - 1];
                    var is_sent_read = '';

                    if (lastChat['admin_id'] != null) {
                        // console.log(lastChat['admin_id']);
                        if (lastChat['status'] == 0) {
                            is_sent_read = '<i class="me-1 bi bi-check2"></i>'
                        } else {
                            is_sent_read = '<i class="me-1 bi bi-check2-all"></i>'
                        }
                    }
                    // console.log((chatResponse['order_id'] != null && chatResponse['order'] != null));
                    if ((chatResponse['order_id'] != null && chatResponse['order'] != null) || (chatResponse['product_id'] != null && chatResponse['product'] != null)) {

                        $('.inner-admin-chat-all').append(
                            '<button type="button" class="inner-admin-chat-list list-group-item list-group-item-action chat-all-container px-0"aria-current="true" data-id="' +
                            chatResponse['id'] + '" data-uid="' +
                            chatResponse['user_id'] + '" data-pid="' +
                            chatResponse['product_id'] + '" data-oid="' +
                            chatResponse['order_id'] + '" data-cid="' +
                            chatResponse['company_id'] + '">' +
                            '<div class="row align-items-center m-0">' +
                            '<div class="col-lg-1 col-md-2 col-2 px-0 px-sm-2">' +
                            '<img class="img-fluid w-100 border-radius-05rem" src="' +
                            imgURL + '" alt="" width="20">' +
                            '</div>' +
                            '<div class="col-lg-10 col-md-9 col-8">' +
                            '<div class="ps-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="">' +
                            '<div class="fw-600 m-0 text-truncate" data-bs-toggle="tooltip" data-bs-placement="bottom" title="' + ' [' + type + ' - ' + detail + ']' + '">' +
                            chatResponse['user']['username'] +
                            ' [' + type + ' - ' + detail + ']' +
                            '</div>' +
                            '<div class="fs-12 text-truncate">' +
                            is_sent_read +
                            chatResponse['chat_message'][chatResponse[
                                'chat_message'].length - 1]['chat_message'] +
                            '</div>' +
                            '<div class="fs-12 text-secondary">' +
                            moment(chatResponse['chat_message'][chatResponse[
                                'chat_message'].length - 1]['created_at'])
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
                $('.inner-admin-chat-all').html('');
                $('.inner-admin-chat-all').html(
                    '<div class="row mx-0 mb-3">' +
                    '<div class="col-12 text-center mt-5">' +
                    '<img class="cart-items-logo" src="' + (new URL("/assets/klikspl-logo.png",
                        window.location.origin)) + '" alt="" width="100">' +
                    '<p class="text-muted py-3 px-2">' +
                    'Belum ada chat untuk anda saat ini' +
                    '</p>' +
                    '</div>' +
                    '</div>'
                );

            }
            console.log(latestChat);
            // var $wrapper = $('.inner-admin-chat-all');
            // console.log($wrapper);
            // $wrapper.find('.inner-admin-chat-list').sort(function(a, b) {
            //         return +b.dataset.id - +a.dataset.id;
            //     })
            //     .appendTo($wrapper);
        },
        dataType: "json"
    });
}

function update_admin_chat_status(csrfToken, chatId, userId, productId, orderId, adminId, companyId) {
    console.log(csrfToken);
    console.log(userId);
    console.log(productId);
    console.log(orderId);
    console.log(adminId);
    console.log(companyId);
    $.ajax({
        // url: "{{ url('/updatechatstatus') }}",
        url: window.location.origin + "/administrator/adminchatmessage/updateadminchatstatus",
        type: 'post',
        data: {
            _token: csrfToken,
            id: chatId,
            user_id: userId,
            product_id: productId,
            order_id: orderId,
            admin_id: adminId,
            company_id: companyId,
        },
        success: function(response) {
            console.log(response);
        },
        dataType: "json"
    });
}

function delete_admin_chat_automatically(csrfToken, companyId) {
    console.log(csrfToken);
    console.log(companyId);
    $.ajax({
        // url: "{{ url('/updatechatstatus') }}",
        url: window.location.origin + "/administrator/adminchatmessage/deleteadminchatautomatically",
        type: 'get',
        data: {
            _token: csrfToken,
            company_id: companyId,
        },
        success: function(response) {
            console.log(response);
        },
        dataType: "json"
    });
}

function chatNotificationRingtone() {
    console.log('it should be ringing');
    var snd = new Audio('/assets/sound/notification_message_2.mp3');
    snd.play();
}