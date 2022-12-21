@auth
    <div class="chat-button-container">
        <div></div>
        <button type="button"
            class="btn btn-danger bg-red-klikspl shadow-none user-chat-button position-fixed border-radius-075rem">
            <i class="bi bi-chat-dots"></i> Chat
            <span
                class="unread-user-chat-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success d-none"><span
                    class="visually-hidden">unread chats</span></span>
        </button>
    </div>
    <div class="container fs-14 user-chat-container d-none chat-container">
        <div class="row">
            <div class="col-10 col-md-10 col-lg-4 user-chat-modal position-fixed p-0">
                <div class="card border-radius-075rem box-shadows">
                    <div class="card-header bg-transparent border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div class="text-red-klikspl fw-600">
                                <i class="bi bi-chat-dots"></i> Chat Admin
                            </div>
                            <div class="ms-auto">
                                <button class="btn btn-danger fs-14 user-chat-close-button p-0 px-2 py-1">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="chat-type">
                            @if (!empty($product))
                                <div class="fw-600 ps-3 pb-2">
                                    Tanya Produk:
                                </div>
                                <div class="card mx-3 border-radius-05rem fs-14 mb-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-2">
                                                @if (count($product->productimage) > 0)
                                                    @if (Storage::exists($product->productimage[0]->name))
                                                        <img id="main-image"
                                                            src="{{ asset('/storage/' . $product->productimage[0]->name) }}"
                                                            class="product-detail-img border-radius-05rem" alt="Foto Produk"
                                                            width="100%">
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-10 ps-0">
                                                <div class="product-name">
                                                    {{ $product->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif(!empty($order))
                            <div class="fw-600 ps-3 pb-2">
                                Tanya Pesanan:
                            </div>
                            <div class="card mx-3 border-radius-05rem fs-14 mb-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2">
                                            @if (count($order->orderitem[0]->orderproduct->orderproductimage) > 0)
                                                @if (Storage::exists($order->orderitem[0]->orderproduct->orderproductimage[0]->name))
                                                    <img id="main-image"
                                                        src="{{ asset('/storage/' .$order->orderitem[0]->orderproduct->orderproductimage[0]->name) }}"
                                                        class="product-detail-img border-radius-05rem" alt="Foto Produk"
                                                        width="100%">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-10 ps-0">
                                            <div class="product-name">
                                                @if (!is_null($order->invoice_no))
                                                    {{ $order->invoice_no }}
                                                @else
                                                    No.Invoice belum terbit
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="inner-user-chat-modal p-3 overflow-auto">
                           
                        </div>
                        <div class="user-chat-send px-3 pt-2 pb-3">
                            <div class="inner-user-chat-send-data-needed">
                                <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="user_id_chat" value="{{ auth()->user()->id }}">
                                @if (!empty($product))
                                    <input type="hidden" name="product_id_chat" value="{{ $product->id }}">
                                    <input type="hidden" name="company_id_chat" value="{{ $product->company_id }}">
                                @elseif(!empty($order))
                                    <input type="hidden" name="order_id_chat" value="{{ $order->id }}">
                                    <input type="hidden" name="company_id_chat" value="{{ $order->orderitem[0]->orderproduct->company_id }}">
                                @endif
                                <input type="hidden" name="admin_id_chat" value="">
                            </div>

                            <textarea class="form-control fs-14 mb-3 shadow-none" name="chat_user_chat" id="chat_user_chat" rows="2" required></textarea>
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
@endauth
