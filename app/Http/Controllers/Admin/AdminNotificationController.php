<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\adminnotification;
use App\Http\Controllers\Controller;

class adminnotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->guard('adminMiddle')->user()->admin_type == 1 || auth()->guard('adminMiddle')->user()->admin_type == 2) {
            $notifications = adminnotification::where('company_id', auth()->guard('adminMiddle')->user()->company_id)->get()->sortByDesc('created_at');
        } else if (auth()->guard('adminMiddle')->user()->admin_type == 3) {
            $notifications = adminnotification::where('admin_type', '=', auth()->guard('adminMiddle')->user()->admin_type)->get()->sortByDesc('created_at');
        } else {
            $notifications = adminnotification::where('admin_type', '=', auth()->guard('adminMiddle')->user()->admin_type)->where('company_id', auth()->guard('adminMiddle')->user()->company_id)->get()->sortByDesc('created_at');
        }
        // dd($notifications);
        return view(
            'admin.notifications.index',
            [
                'title' => 'Notifikasi',
                'active' => 'notifications',
                'notifications' => $notifications,
            ]
        );
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\adminnotification  $adminnotification
     * @return \Illuminate\Http\Response
     */
    public function show(adminnotification $adminnotification)
    {
        $isRead = AdminNotification::find($adminnotification->id);
        $isRead->is_read = 1;
        $isRead->save();
        // dd($adminnotification);
        $orders = null;
        if ($adminnotification->type == 'Pesanan' || $adminnotification->type == 'Pembayaran Dikonfirmasi') {
            $orders = Order::find($adminnotification->order_id);
        }

        return view('admin.notifications.show', [
            'title' => 'Notifikasi',
            'active' => 'notifications',
            'notification' => $adminnotification,
            'order' => $orders
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\adminnotification  $adminnotification
     * @return \Illuminate\Http\Response
     */
    public function edit(adminnotification $adminnotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\adminnotification  $adminnotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, adminnotification $adminnotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\adminnotification  $adminnotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(adminnotification $adminnotification)
    {
        //
    }

    public function allNotificationsIsReaded()
    {
        $notifications = AdminNotification::where('is_read', '=', '0')->get();
        foreach ($notifications as $notification) {
            $notification->is_read = 1;
            $notification->save();
        }
        return redirect()->back()->with('success', 'Berhasil menandai semua notifikasi telah dibaca');
    }
}
