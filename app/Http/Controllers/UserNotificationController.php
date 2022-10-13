<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\UserNotification;
use App\Http\Requests\StoreUserNotificationRequest;
use App\Http\Requests\UpdateUserNotificationRequest;

class UserNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd( UserNotification::where('user_id', auth()->user()->id)->get());
        // return view('userNotification.index', [
        $notifications = UserNotification::latest()->where('user_id', auth()->user()->id)->get();
        return view('userNotification.index', [
            'title' => 'Notifikasi',
            'active' => 'notification',
            'notifications' => $notifications
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
     * @param  \App\Http\Requests\StoreUserNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserNotificationRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserNotification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(UserNotification $notification)
    {
        // dd($notification);
        $isRead = UserNotification::find($notification->id);
        $isRead->is_read = 1;
        $isRead->save();

        $orders = null;
        if($notification->type == 'Pesanan'){
            // dd($notification->slug);
            $exp = explode('-',$notification->slug);
            $orderId = $exp[1];
            // $orderId = preg_replace('/[^0-9]/','',$notification->slug);
            // dd($orderId);
            $order = Order::withTrashed()->find($orderId);
            // dd($order);
            if($order->user_id == auth()->user()->id){
                $orders = $order;
            }
        }
        //dd($isRead);
        return view('userNotification.show',[
            'title' => 'Notifikasi',
            'active' => 'notification',
            'notification' => $notification,
            'order' => $orders            
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserNotification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(UserNotification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserNotificationRequest  $request
     * @param  \App\Models\UserNotification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserNotificationRequest $request, UserNotification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserNotification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserNotification $notification)
    {
        // dd($notification);
          if (auth()->user()->id) {
            $notification->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus notifikasi.');
        } else {
            abort(403);
        }
    }

    public function allNotificationsIsReaded()
    {
        $notifications = UserNotification::all();
        foreach ($notifications as $notification) {
            $notification->is_read = 1;
            $notification->save();
        }
        return redirect()->back()->with('success', 'Berhasil menandai semua notifikasi telah dibaca');
    }
}
