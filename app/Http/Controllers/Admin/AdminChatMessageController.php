<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminChatMessageController extends Controller
{
    function index(){
        // dd(Carbon::now());
        $chats = Chat::with(['user','product.productimage','order.orderitem.orderproduct.orderproductimage','admin', 'company', 'chatmessage'])->where([['company_id','=',auth()->guard('adminMiddle')->user()->company->id]])->orderBy('updated_at','desc')->get();
        // dd($chats);
        // $orderChats= $chats->sortByDesc('created_at')->groupBy('order_id');
        // $productChats= $chats->sortByDesc('created_at')->groupBy('product_id');
        // $userChatsGrouped = ['orderChats' =>$orderChats, 'productChats'=>$productChats];
        // dd($userChatsGrouped);
        // return response()->json($chats);
        return view(
            'admin.chat.index',
            [
                'title' => 'Chat',
                'active' => 'chat',
                // 'chats' => $chats,
            ]
        );
    }

    function loadAdminChatAll(Request $request){
        $loadAdminChatAll = Chat::with(['user','product.productimage','order.orderitem.orderproduct.orderproductimage','admin', 'company', 'chatMessage'])->where([['company_id','=',$request->company_id]])->orderBy('updated_at','desc')->get();
        // $orderChats= $loadAdminChatAll->groupBy('order_id');
        // $productChats= $loadAdminChatAll->groupBy('product_id');
        // $loadAdminChatAllGrouped = ['orderChats' =>$orderChats, 'productChats'=>$productChats];
        return response()->json($loadAdminChatAll);
    }

    function loadAdminChatModal(Request $request){
        if (isset($request->product_id)) {
            $chatHistory = Chat::with(['user', 'product','product.productimage', 'admin', 'company', 'chatMessage'])->where([['id','=',$request->id], ['user_id', '=', $request->user_id], ['product_id', '=', $request->product_id], ['company_id', '=', $request->company_id]])->get();
        } elseif (isset($request->order_id)) {
            $chatHistory = Chat::with(['user', 'order.orderitem.orderproduct.orderproductimage', 'order', 'admin', 'company', 'chatMessage'])->where([['id','=',$request->id], ['user_id', '=', $request->user_id], ['order_id', '=', $request->order_id], ['company_id', '=', $request->company_id]])->get();
        }
        return response()->json(['chatHistory'=>$chatHistory]);
    }

    function sendAdminChatModal(Request $request)
    {

        $validatedData = $request->validate(
            [
                'user_id' => 'required',
                'chat_message' => 'required',
            ]
        );
        $chat = null;
        if (isset($request->product_id)) {  
            $chat = Chat::where([['id','=',$request->id], ['user_id', '=', $request->user_id], ['product_id', '=', $request->product_id], ['company_id', '=', $request->company_id]])->first();
            if(!is_null($chat)){
                $chat->admin_id = $request->admin_id;
            }

            // $chat = Chat::firstOrCreate([
            //     'user_id' => $request->user_id,
            //     'admin_id' => $request->admin_id,
            //     'product_id' => $request->product_id,
            //     'company_id' => $request->company_id,
            //     'status' => 0,
            // ]);

            $chat->updated_at = Carbon::now();
            $chat->save();
            $chatMessage = ChatMessage::create([
                'chat_id' => $chat->id,
                'user_id' => $request->user_id,
                'admin_id' => $request->admin_id,
                'chat_message' => $validatedData['chat_message'],
                'status' => 0,
            ]);
        } elseif (isset($request->order_id)) {
            $chat = Chat::where([['id','=',$request->id], ['user_id', '=', $request->user_id], ['order_id', '=', $request->order_id], ['company_id', '=', $request->company_id]])->first();
            if(!is_null($chat)){
                $chat->admin_id = $request->admin_id;
            }
            // $chat = Chat::firstOrCreate([
            //     'user_id' => $request->user_id,
            //     'admin_id' => $request->admin_id,
            //     'order_id' => $request->order_id,
            //     'company_id' => $request->company_id,
            //     'status' => 0,
            // ]);
            $chat->updated_at = Carbon::now();
            $chat->save();
            $chatMessage = ChatMessage::create([
                'chat_id' => $chat->id,
                'user_id' => $request->user_id,
                'admin_id' => $request->admin_id,
                'chat_message' => $validatedData['chat_message'],
                'status' => 0,
            ]);
        }

        // $chat = [
        //     'user_id' => $request->user_id,
        //     'product_id' => $request->product_id,
        //     'admin_id' => $request->admin_id,
        //     'company_id' => $request->company_id,
        //     'chat_message' => $validatedData['chat_message'],
        //     'status' => 1,
        // ];

        return response()->json($chat);
    }

    function updateAdminChatStatus(Request $request)
    {
        // $validatedData = $request->validate(
        //     [
        //         'user_id' => 'required',
        //     ]
        // );
        if (isset($request->product_id)) {
            $chat = Chat::where([['user_id', '=', $request->user_id], ['product_id', '=', $request->product_id], ['company_id', '=', $request->company_id]])->first();
        } elseif (isset($request->order_id)) {
            $chat = Chat::where([['user_id', '=', $request->user_id], ['order_id', '=', $request->order_id], ['company_id', '=', $request->company_id]])->first();
        }
        $updateChatStatus = ChatMessage::where([['chat_id', '=', $chat->id], ['status','=',0]])->whereNull('admin_id')->get();
        foreach ($updateChatStatus as $chatStatus) {
            $chatStatus->status = 1;
            $chatStatus->save();
        }
        if ($updateChatStatus) {
            $response = '200 ok';
        } else {
            $response = '500 cannot update chat status';
        }

        return response()->json($response);
    }
}
