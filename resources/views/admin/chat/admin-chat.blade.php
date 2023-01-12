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
                        <textarea class="form-control fs-14 mb-1 shadow-none" name="chat_admin_chat" id="chat_admin_chat" rows="2" required></textarea>
                        <div class="d-flex mb-2">
                            <div class="text-danger fs-11 m-0 fw-bold">
                                    Chat akan dihapus otomatis setelah 30 hari dari chat awal dimulai
                            </div>
                        </div>
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