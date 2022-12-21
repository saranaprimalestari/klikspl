<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class UserChatController extends Controller
{
    function index()
    {
        return view(
            'user.chat.index',
            [
                'title' => 'Chat',
                'active' => 'chat',
            ]
        );
    }

    function loadChatAll(Request $request){
        $loadAdminChatAll = Chat::with(['user','product.productimage','order.orderitem.orderproduct.orderproductimage','admin', 'company', 'chatMessage'])->where([['user_id', '=', auth()->user()->id]])->orderBy('updated_at','desc')->get();
        // $orderChats= $loadAdminChatAll->groupBy('order_id');
        // $productChats= $loadAdminChatAll->groupBy('product_id');
        // $loadAdminChatAllGrouped = ['orderChats' =>$orderChats, 'productChats'=>$productChats];
        return response()->json($loadAdminChatAll);
    }
}
