<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Product;
use App\Models\OrderItem;

use Illuminate\Http\Request;
use App\Models\ProductComment;
use App\Models\ProductVariant;
use App\Models\UserNotification;
use function PHPSTORM_META\type;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Crypt;

class OrderItemRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = OrderItem::where('order_item_status', '=', 'selesai')->where('user_id', '=', auth()->user()->id)->where('is_review', '=', 0)->get();

        return view('user.rating.index', [
            'title' => 'Penilaian Produk',
            'active' => 'rating',
            'orderItems' => $ratings,
        ]);
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
        $deadline_to_comment = Carbon::createFromFormat('Y-m-d', $request->comment_date)->addDays(30)->format('Y-m-d');
        $request->merge(['deadline_to_comment' => $deadline_to_comment]);
        // dd($request);
        $validatedData = $request->validate(
            [
                'id' => 'required',
                'user_id' => 'required',
                'product_id' => 'required',
                'product_variant_id' => 'required',
                'comment' => 'nullable',
                'star' => 'required',
                'comment_date' => 'required|date|date_format:Y-m-d',
                'order_id' => 'required',
                'deadline_to_comment' => 'required|date|date_format:Y-m-d',
                'comment_image' => 'image|file||mimes:jpeg,png,jpg|max:2048',

            ],
            [
                'star.required' => 'Bintang penilaian tidak boleh kosong',
                'comment_image.image' => 'Foto yang diupluad harus berupa gambar',
                'comment_image.file' => 'Foto yang diupluad harus berupa file',
                'comment_image.mimes' => 'Foto yang diupluad harus memiliki format file .jpg, .jpeg, .png',
                'comment_image.max' => 'Foto yang diupluad berukuran maximal 2MB',
            ]
        );
        // dd($request);

        $folderPathSave = 'user/' . auth()->user()->username . '/order/' . $request->order_id . '/comment';

        $productComment = ProductComment::create(
            [
                'user_id' => $validatedData['user_id'],
                'product_id' => $validatedData['product_id'],
                'product_variant_id' => $validatedData['product_variant_id'],
                'comment' => $validatedData['comment'],
                'star' => $validatedData['star'],
                'comment_date' => $validatedData['comment_date'],
                'order_id' => $validatedData['order_id'],
                'deadline_to_comment' => $validatedData['deadline_to_comment'],
                'is_edit' => 0,
            ]
        );
        $variantDescription = '';
        $product = Product::findOrFail($validatedData['product_id']);
        if (!empty($validatedData['product_id_variant_id'])) {
            $productVariant = ProductVariant::findOrFail($validatedData['product_id_variant_id']);
            $variantDescription = 'dengan varian '.$productVariant->variant_name;
        }

        if ($productComment) {
            if ($request->file('comment_image')) {
                $uploadCommentImage = ProductComment::find($productComment->id);
                $uploadCommentImage->comment_image = $request->file('comment_image')->store($folderPathSave);
                $uploadCommentImage->save();
            }

            $orderItem = OrderItem::find($validatedData['id']);
            $orderItem->is_review = 1;
            $updateOrderItem = $orderItem->save();
        }

        if ($productComment && $updateOrderItem) {
            $order = $orderItem->order;
            $orderProduct = $order->orderitem[0]->orderProduct;

            if (!is_null(auth()->user()->email)) {
                $details = ['id' => '2', 'email' => auth()->user()->email, 'title' => 'KLIK SPL: Berhasil Memberikan Penilaian dan Ulasan', 'message' => 'Terimakasih telah memberikan penilaian dan ulasan untuk Produk '.$product->name.' '.$variantDescription.' dalam Pesanan ' . $order->invoice_no . '. Penilaian dan ulasan yang anda beri membantu KLIKSPL untuk berkembang lebih baik lagi. Untuk melihat penilaian yang diberikan, silakan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/comment', 'closing' => '', 'footer' => ''];
                $detail = new Request($details);
                // $this->mailController = $mailController;
                // $this->mailController->sendMail($detail); 
                $sendMailController = $mailController;
                $sendMailController->sendMail($detail);
            }

            $notifications = [
                'user_id' => auth()->user()->id,
                'slug' => auth()->user()->username . '-' . Crypt::encryptString($order->id) . '-berhasil-memberi-penilaian-ulasan',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">Terimakasih telah memberikan penilaian dan ulasan untuk Produk '.$product->name.' '.$variantDescription.' dalam Pesanan ' . $order->invoice_no . '. Penilaian dan ulasan yang anda beri membantu KLIKSPL untuk berkembang lebih baik lagi.</p>',
                'excerpt' => 'Berhasil Memberi Penilaian dan Ulasan',
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk user
            $notification = UserNotification::create($notifications);

            $sendAdminNotification = Admin::where('admin_type', '=', 2)->where('company_id', '=', $orderProduct->company_id)->get();

            foreach ($sendAdminNotification as $admin) {
                if (!is_null($admin->email)) {
                    $details = ['id' => '2', 'email' => $admin->email, 'title' => 'KLIK SPL: Penilaian dan Ulasan Produk', 'message' => auth()->user()->username.' memberikan penilaian dan ulasan untuk Produk '.$product->name.' '.$variantDescription.' dalam Pesanan ' . $order->invoice_no . '. Yuk beri tanggapan dari penilaian dan ulasan yang diberikan pembeli dengan klik tautan berikut:', 'verifCode' => '', 'url' => 'https://klikspl.com/administrator/adminorder', 'closing' => '', 'footer' => ''];
                    $detail = new Request($details);
                    // $this->mailController = $mailController;
                    // $this->mailController->sendMail($detail); 
                    $sendMailController = $mailController;
                    $sendMailController->sendMail($detail);
                }
            }

            $adminNotificationDetail = [
                // 'admin_id' => auth()->user()->id,
                'order_id' => $order->id,
                'admin_type' => 2,
                'company_id' => $orderProduct->company_id,
                'slug' => Crypt::encryptString($order->id) . '-penilaian-ulasan',
                'type' => 'Pesanan',
                'description' => '<p class="m-0">'.auth()->user()->username.' memberikan penilaian dan ulasan untuk Produk '.$product->name.' '.$variantDescription.' dalam Pesanan ' . $order->invoice_no . '. Yuk beri tanggapan dari penilaian dan ulasan yang diberikan pembeli <span onclick="location.href=\''.route('productcomment.show', $productComment).'\'" class="text-danger fw-bold user-select-none">Klik disini</span>.</p>',
                'excerpt' => 'Penilaian dan Ulasan Produk',
                'image' => 'storage/' . $orderProduct->orderproductimage->first()->name,
                'is_read' => 0
            ];
            // membuat notifikasi pembuatan pesanan untuk admin
            $adminNotification = AdminNotification::create($adminNotificationDetail);

            return redirect()->route('rating.index')->with(['success' => 'Berhasil memberi penilaian produk pesanan']);
        } else {
            return redirect()->route('rating.index')->with(['failed' => 'Gagal memberi penilaian produk pesanan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderItem  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $rating)
    {
        // dd($rating);

        return view('user.rating.show', [
            'title' => 'Penilaian Produk',
            'active' => 'rating',
            'orderItem' => $rating,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderItem  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderItem $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderItem  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItem  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $rating)
    {
        //
    }
}
