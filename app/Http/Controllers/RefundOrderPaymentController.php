<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Models\AdminNotification;
use App\Models\OrderStatusDetail;
use App\Models\RefundOrderPayment;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\StoreRefundOrderPaymentRequest;
use App\Http\Requests\UpdateRefundOrderPaymentRequest;

class RefundOrderPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MailController $mailController)
    {
        // dd($request);

        $validated = $request->validate([
            'order_id' => 'required',
            'user_id' => 'required',
            'company_id' => 'required',
            'name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
        ]);

        if (isset($request->email)) {
            $validatedEmail = $request->validate([
                'email' => 'email',
            ]);
        }

        if (isset($request->telp_no)) {
            $validatedTelpNo = $request->validate(
                [
                    'telp_no' => ['required', 'min:10', 'max:13', 'regex:/^[0-9]*$/'],
                ],
                [
                    'regex' => 'Nomor telepon tidak valid, nomor telepon hanya dapat diisi dengan angka',
                ]
            );
        }

        $refund = RefundOrderPayment::updateOrCreate(
            [
                'order_id' => $validated['order_id'],
                'user_id' => $validated['user_id'],
                'company_id' => $validated['company_id'],
            ],
            [
                'name' => $validated['name'],
                'bank_name' => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'email' => $request->email,
                'telp_no' => $request->telp_no,
                'status' => 'pengajuan',
            ]

        );

        $order = Order::find($request->order_id);
        $order->order_status = 'pengajuan pengembalian dana';
        $orderSave = $order->save();


        if ($orderSave && $refund) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pengajuan pengembalian dana';
                $item->save();
            }

            $orderStatus = OrderStatusDetail::create(
                [
                    'order_id' => $order->id,
                    'status' => 'Pengajuan pengembalian dana',
                    'status_detail' => 'Berhasil mengisi form pengembalian dana, pengajuan pengembalian dana sedang diproses oleh Admin KLIKSPL',
                    'status_date' => date('Y-m-d H:i:s')
                ]
            );

            $orderProduct = $order->orderitem[0]->orderProduct;

            $sendAdminNotification = Admin::whereIn('admin_type', [2, 3])->where('company_id', '=', $orderProduct->company_id)->get();

            foreach ($sendAdminNotification as $admin) {
                if (!is_null($admin->email)) {
                    $details = ['id' => '2', 'email' => $admin->email, 'title' => 'KLIK SPL: Pengajuan Pengembalian Dana', 'message' => auth()->user()->username . ' mengajukan pengembalian dana dari pembatalan pesanan ' . $order->invoice_no . '. Segera verifikasi data pengajuan pengembalian dana oleh user. Dan segera lakukan pengembalian dana jika data pengajuan sudah benar! Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/administrator/adminorder', 'closing' => '', 'footer' => ''];
                    $detail = new Request($details);
                    // $this->mailController = $mailController;
                    // $this->mailController->sendMail($detail); 
                    $sendMailController = $mailController;
                    $sendMailController->sendMail($detail);
                }
            }

            $notifications = [
                // 'admin_id' => auth()->user()->id,
                'order_id' => $order->id,
                'admin_type' => 3,
                'company_id' => $orderProduct->company_id,
                'slug' => Crypt::encryptString($order->id) . '-pengajuan-pengembalian-dana',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">' . auth()->user()->username . ' mengajukan pengembalian dana dari pembatalan pesanan ' . $order->invoice_no . '. Segera verifikasi data pengajuan pengembalian dana oleh user. Dan segera lakukan pengembalian dana jika data pengajuan sudah benar!</p>',
                'excerpt' => 'Pengajuan Pengembalian Dana',
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk admin
            $adminNotification = AdminNotification::create($notifications);

            if (!is_null(auth()->user()->email)) {
                $details = ['id' => '2', 'email' => auth()->user()->email, 'title' => 'KLIK SPL: Pengajuan Pengembalian Dana', 'message' => 'Pengajuan pengembalian dana dari pesanan ' . $order->invoice_no . ' masih dalam proses verifikasi admin KLIKSPL. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);

                if (isset($request->email)) {
                    if ($request->email != auth()->user()->email) {
                        $details = ['id' => '2', 'email' => $request->email, 'title' => 'KLIK SPL: Pengajuan Pengembalian Dana', 'message' => 'Pengajuan pengembalian dana dari pesanan ' . $order->invoice_no . ' masih dalam proses verifikasi admin KLIKSPL. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
                        $detail = new Request($details);
                        $sendMailController = $mailController;
                        $sendMailController->sendMail($detail);
                    }
                }
            }

            $notifications = [
                'user_id' => auth()->user()->id,
                'slug' => auth()->user()->username . '-' . Crypt::encryptString($order->id) . '-pengajuan-pengembalian-dana',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Proses pengembalian dana dari pesanan ' . $order->invoice_no . ' masih dalam proses verifikasi Admin KLIKSPL.</p>',
                'excerpt' => 'Pengajuan Pengembalian Dana',
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk user
            $notification = UserNotification::create($notifications);
        }
        return redirect()->route('order.index')->with('success', 'Pengajuan pengembalian dana dalam proses verifikasi oleh Admin KLIKSPL.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RefundOrderPayment  $refundOrderPayment
     * @return \Illuminate\Http\Response
     */
    public function show(RefundOrderPayment $refundOrderPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RefundOrderPayment  $refundOrderPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(RefundOrderPayment $refundOrderPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\RefundOrderPayment  $refundOrderPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefundOrderPayment $refundOrderPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RefundOrderPayment  $refundOrderPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefundOrderPayment $refundOrderPayment)
    {
        //
    }
}
