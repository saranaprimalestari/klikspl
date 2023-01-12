<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\UserNotification;
use App\Models\AdminNotification;
use App\Models\OrderStatusDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Admin\AdminOrderController;

class AdminRefundOrderPaymentController extends Controller
{

    public function declineRefundOrderPayment(Request $request, AdminOrderController $adminOrderController, MailController $mailController)
    {
        $adminOrderController->expiredCheck();

        $order = Order::where('id', '=', $request->order_id)->first();
        $order->order_status = 'pengajuan pengembalian dana ditolak';
        $order->save();


        if ($order->save()) {
            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pengajuan pengembalian dana ditolak';
                $item->save();
            }
        }

        $orderStatus = OrderStatusDetail::create(
            [
                'order_id' => $order->id,
                'status' => 'Pengajuan pengembalian dana ditolak',
                'status_detail' => 'Pengajuan pengembalian dana dari pesanan ' . $order->invoice_no . ' DITOLAK oleh Admin KLIKSPL, dengan alasan: ' . $request->cancel_refund_order_payment . '. Silakan isi ulang form pengajuan pengembalian dana dengan data yang benar!',
                'status_date' => date('Y-m-d H:i:s')
            ]
        );


        if ($orderStatus) {

            foreach ($order->refund as $refund) {
                $refund->status = 'ditolak';
                $refund->save();
            }

            $orderProduct = $order->orderitem[0]->orderProduct;

            if (!is_null($order->users->email)) {
                $details = ['id' => '2', 'email' => $order->users->email, 'title' => 'KLIK SPL: Pengajuan Pengembalian Dana Ditolak', 'message' => 'Pengajuan pengembalian dana dari pesanan ' . $order->invoice_no . ' DITOLAK oleh admin KLIKSPL dengan alasan: ' . $request->cancel_refund_order_payment . '. Silakan isi ulang form pengajuan pengembalian dana dengan data yang benar! Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                // $this->mailController = $mailController;
                // $this->mailController->sendMail($detail); 
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);
            }

            $notifications = [
                'user_id' => $order->user_id,
                'slug' => $order->users->username . '-' . Crypt::encryptString($order->id) . '-pengajuan-pengembalian-dana-ditolak',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Pengajuan pengembalian dana dari pesanan ' . $order->invoice_no . '  DITOLAK oleh Admin KLIKSPL, dengan alasan: ' . $request->cancel_refund_order_payment . '. Silakan isi ulang form pengajuan pengembalian dana dengan data yang benar!</p>',
                'excerpt' => 'Pengajuan Pengembalian Dana Ditolak',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];

            // membuat notifikasi pembuatan pesanan untuk user
            $notification = UserNotification::create($notifications);

            return redirect()->back()->with('success', 'Penolakan pengajuan pengembalian dana berhasil, pembeli diharuskan mengisi ulang form pengajuan pengembalian dana yang valid');
        } else {
            return redirect()->back()->with('failed', 'Terjadi kesalahan dalam pembatalan pengajuan pengembalian dana');
        }
    }

    public function confirmRefundOrderPayment(Request $request, AdminOrderController $adminOrderController, MailController $mailController)
    {
        $adminOrderController->expiredCheck();
        $order = Order::where('id', '=', $request->order_id)->first();
        $order->order_status = 'pengajuan pengembalian dana dikonfirmasi';
        $order->save();
        if ($order->save()) {

            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pengajuan pengembalian dana dikonfirmasi';
                $item->save();
            }

            foreach ($order->refund as $refund) {
                $refund->status = 'disetujui';
                $refund->save();
            }

            $orderProduct = $order->orderitem[0]->orderProduct;
            // $order->delete();
            if (!is_null($order->users->email)) {
                $details = ['id' => '2', 'email' => $order->users->email, 'title' => 'KLIK SPL: Pengajuan Pengembalian Dana Dikonfirmasi', 'message' => 'Pengajuan pengembalian dana dikonfirmasi oleh Admin KLIKSPL. Silakan tunggu notifikasi selanjutnya dan cek secara berkala website KLIKSPL / rekening anda. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                // $this->mailController = $mailController;
                // $this->mailController->sendMail($detail); 
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);
            }

            $notifications = [
                'user_id' => $order->user_id,
                'slug' => $order->users->username . '-' . Crypt::encryptString($order->id) . '-pengajuan-pengembalian-dana-dikonfirmasi',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Pengajuan pengembalian dana dikonfirmasi oleh Admin KLIKSPL. Silakan tunggu notifikasi selanjutnya dan cek secara berkala website KLIKSPL / rekening anda.</p>',
                'excerpt' => 'Pengajuan Pengembalian Dana Dikonfirmasi',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk user
            $notification = UserNotification::create($notifications);

            $sendAdminNotification = Admin::whereIn('admin_type', [2, 3])->where('company_id', '=', $orderProduct->company_id)->get();
            foreach ($sendAdminNotification as $admin) {
                if (!is_null($admin->email)) {
                    $details = ['id' => '2', 'email' => $admin->email, 'title' => 'KLIK SPL: Pengajuan Pengembalian Dana Dikonfirmasi', 'message' => 'Pengajuan pengembalian dana sudah anda konfirmasi. Segera transfer kembali dana yang sudah dibayarkan oleh pembeli ke rekening yang sudah diisikan oleh pembeli. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/administrator/adminorder', 'closing' => '', 'footer' => ''];
                    $detail = new Request($details);
                    // $this->mailController = $mailController;
                    // $this->mailController->sendMail($detail); 
                    $sendMailController = $mailController;
                    $sendMailController->sendMail($detail);
                }
            }

            $adminNotifications = [
                'order_id' => $order->id,
                'admin_id' => auth()->guard('adminMiddle')->user()->id,
                'admin_type' => 3,
                'company_id' => $orderProduct->company_id,
                'slug' => Crypt::encryptString($order->id) . '-pengajuan-pengembalian-dana-dikonfirmasi',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Pengajuan pengembalian dana sudah anda konfirmasi. Segera transfer kembali dana yang sudah dibayarkan oleh pembeli ke rekening yang sudah diisikan oleh pembeli.</p>',
                'excerpt' => 'Pengajuan Pengembalian Dana Dikonfirmasi',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk admin
            $adminNotification = AdminNotification::create($adminNotifications);

            $orderStatus = OrderStatusDetail::create(
                [
                    'order_id' => $order->id,
                    'status' => 'Pengajuan pengembalian dana dikonfirmasi',
                    // 'status_detail' => 'pengembalian dana Dikonfirmasi oleh Admin KLIKSPL.',
                    'status_detail' => 'Pengajuan pengembalian dana dikonfirmasi oleh Admin KLIKSPL. Silakan tunggu notifikasi selanjutnya dan cek secara berkala website KLIKSPL / rekening anda.',
                    'status_date' => date('Y-m-d H:i:s')
                    // Dana yang sudah dibayarkan akan dikembalikan ke nomor rekening yang digunakan saat melakukan pembayaran
                ]
            );
            return redirect()->route('adminorder.index')->with('success', 'Berhasil mengonfirmasi pengembalian dana pesanan. Segera transfer kembali dana yang sudah dibayarkan oleh pembeli.');
        }
    }
    public function sendProofOfRefund(Request $request, AdminOrderController $adminOrderController, MailController $mailController)
    {
        $adminOrderController->expiredCheck();

        $validatedData = $request->validate(
            [
                'type' => 'required',
                'proof_of_refund' => 'image|file||mimes:jpeg,png,jpg|max:2048'
            ],
            [
                'type' => 'Metode pengembalian dana tidak boleh kosong!',
                'proof_of_refund.image' => 'Bukti Pembayaran harus berupa gambar',
                'proof_of_refund.file' => 'Bukti Pembayaran harus berupa file',
                'proof_of_refund.mimes' => 'Bukti Pembayaran harus memiliki format file .jpg, .jpeg, .png',
                'proof_of_refund.max' => 'Bukti Pembayaran berukuran maximal 2MB',
            ]
        );

        // dd($request);

        $order = Order::where('id', '=', $request->order_id)->first();
        $orderDetail = OrderStatusDetail::where([['order_id', '=', $request->order_id], ['status', '=', 'pengajuan pembatalan']])->first();
        $cancel_order_detail = explode(': ', $orderDetail->status_detail);
        // dd($cancel_order_detail);
        $stockVariant = 0;
        $soldVariant = 0;
        foreach ($order->orderitem as $orderitem) {
            $product = Product::where('id', '=', $orderitem->product_id)->first();
            if (!empty($orderitem->product_variant_id)) {
                $productVariantId = ProductVariant::where('id', '=', $orderitem->product_variant_id)->first();
                // echo "product variant stock before : " .$productVariantId->stock;
                // echo "<br>";
                // echo "product variant sold before : " .$productVariantId->sold;
                // echo "<br>";
                $productVariantId->stock = (int)$productVariantId->stock + (int)$orderitem->quantity;
                $productVariantId->sold = (int)$productVariantId->sold - (int)$orderitem->quantity;
                // echo "product variant stock : " .$productVariantId->stock;
                // echo "<br>";
                // echo "product variant sold : " .$productVariantId->sold;
                // echo "<br>";
                // echo "order item qty : " .$orderitem->quantity;
                // echo "<br>";
                $stockVariant += $productVariantId->stock;
                $soldVariant += $productVariantId->sold;
                $productVariantId->save();

                // $product->stock = $stockVariant;
                // $product->sold = $soldVariant;
                // $product->save();
            } else {
                $product->stock = (int)$product->stock + (int)$orderitem->quantity;
                $product->sold = (int)$product->sold - (int)$orderitem->quantity;
                // echo "product stock : " . $product->stock;
                // echo "<br>";
                // echo "product sold : " . $product->sold;
                // echo "<br>";
                // echo "order item qty : " . $orderitem->quantity;
                // echo "<br>";
                $product->save();
            }
            // echo "product id : " . $product->id;
            // echo "<br>";
            // echo "not empty : " . !empty($product->productvariant);
            // echo "<br>";
            // echo "not null : " . !is_null($product->productvariant);
            // echo "<br>";
            // echo "count : " . count($product->productvariant);
            // echo "<br>";
            if (count($product->productvariant) > 0) {
                // echo ('ada product variant');
                // echo "<br>";
                $product->stock = $product->productvariant->sum('stock');
                $product->sold = $product->productvariant->sum('sold');
                $product->save();
            }
            // dd($request);
        }

        $order->order_status = 'pesanan dibatalkan';
        $order->save();

        if ($order->save()) {

            foreach ($order->orderitem as $item) {
                $item->order_item_status = 'pesanan dibatalkan';
                $item->save();
            }

            if (!is_null($request->file('proof_of_refund')) || $request->file('proof_of_refund')) {
                $folderPathSave = 'user/' . $order->users->username . '/order/' . $request->order_id . '/proof-of-refund';

                // echo $folderPathSave;
                // echo "<br><br>";
                // echo $request->order_id;

                if ($request->file('proof_of_refund')) {
                    // echo 'if req proof';
                    $validatedData['proof_of_refund'] = $request->file('proof_of_refund')->store($folderPathSave);
                    // echo $validatedData['proof_of_refund'];
                }
                // $order->proof_of_payment = $validatedData['proof_of_refund'];
                if($validatedData['proof_of_refund']){
                    foreach ($order->refund as $refund) {
                        $refund->status = 'dibayarkan';
                        $refund->type = $validatedData['type'];
                        $refund->proof_of_payment =  $validatedData['proof_of_refund'];
                        $refund->save();
                    }
                }
            }

            $orderProduct = $order->orderitem[0]->orderProduct;
            // $order->delete();
            if (!is_null($order->users->email)) {
                $details = ['id' => '2', 'email' => $order->users->email, 'title' => 'KLIK SPL: Pesanan Dibatalkan', 'message' => 'Dana Pengembalian sudah ditransfer ke nomor rekening anda, silakan cek dana yang masuk pada rekening anda. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/order', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                // $this->mailController = $mailController;
                // $this->mailController->sendMail($detail); 
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);
            }

            $notifications = [
                'user_id' => $order->user_id,
                'slug' => $order->users->username . '-' . Crypt::encryptString($order->id) . '-pesanan-dibatalkan',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Dana Pengembalian sudah ditransfer ke nomor rekening anda, silakan cek dana yang masuk pada rekening anda.</p>',
                'excerpt' => 'Pesanan Dibatalkan',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk user
            $notification = UserNotification::create($notifications);

            $sendAdminNotification = Admin::whereIn('admin_type', [2, 3])->where('company_id', '=', $orderProduct->company_id)->get();
            foreach ($sendAdminNotification as $admin) {
                if (!is_null($admin->email)) {
                    $details = ['id' => '2', 'email' => $admin->email, 'title' => 'KLIK SPL: Pengembalian Dana Berhasil', 'message' => 'Dana pengembalian pesanan '.$order->invoice_no.' sudah ditransfer kembali ke rekening pembeli. Untuk melihat detail pesanan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/administrator/adminorder', 'closing' => '', 'footer' => ''];
                    $detail = new Request($details);
                    // $this->mailController = $mailController;
                    // $this->mailController->sendMail($detail); 
                    $sendMailController = $mailController;
                    $sendMailController->sendMail($detail);
                }
            }

            $adminNotifications = [
                'order_id' => $order->id,
                'admin_id' => auth()->guard('adminMiddle')->user()->id,
                'admin_type' => 3,
                'company_id' => $orderProduct->company_id,
                'slug' => Crypt::encryptString($order->id) . '-pengembalian-dana-berhasil',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Dana pengembalian pesanan '.$order->invoice_no.' sudah ditransfer kembali ke rekening pembeli.',
                // 'image' => $shopBag,
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk admin
            $adminNotification = AdminNotification::create($adminNotifications);

            $orderStatus = OrderStatusDetail::create(
                [
                    'order_id' => $order->id,
                    'status' => 'Pesanan Dibatalkan',
                    'status_detail' => 'Dana Pengembalian sudah ditransfer ke nomor rekening anda, silakan cek dana yang masuk pada rekening anda. Alasan pembatalan: ' . $cancel_order_detail[1],
                    'status_date' => date('Y-m-d H:i:s')
                ]
            );

            $order->delete();

            return redirect()->route('adminorder.index')->with('success', 'Berhasil menyelesaikan proses transfer kembali dana pembeli.');
        }
    }
}
