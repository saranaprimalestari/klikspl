<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class UserChatMessageController extends Controller
{
    function index()
    {
        // return view('user.chat.index');
    }

    function sendChat(Request $request)
    {

        $validatedData = $request->validate(
            [
                'user_id' => 'required',
                'chat_message' => 'required',
            ]
        );
        $chat = null;
        if (isset($request->product_id)) {
            $chat = Chat::firstOrCreate([
                'user_id' => $request->user_id,
                // 'admin_id' => $request->admin_id,
                'product_id' => $request->product_id,
                'company_id' => $request->company_id,
                'status' => 0,

            ]);
            $chat->updated_at = Carbon::now();
            $chat->save();
            $chatMessage = ChatMessage::create([
                'chat_id' => $chat->id,
                'user_id' => $request->user_id,
                // 'admin_id' => $request->admin_id,
                'chat_message' => $validatedData['chat_message'],
                'status' => 0,
            ]);
        } elseif (isset($request->order_id)) {
            $chat = Chat::firstOrCreate([
                'user_id' => $request->user_id,
                // 'admin_id' => $request->admin_id,
                'order_id' => $request->order_id,
                'company_id' => $request->company_id,
                'status' => 0,
            ]);
            $chat->updated_at = Carbon::now();
            $chat->save();
            $chatMessage = ChatMessage::create([
                'chat_id' => $chat->id,
                'user_id' => $request->user_id,
                // 'admin_id' => $request->admin_id,
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

    function loadChat(Request $request)
    {
        // dd($request);
        if (isset($request->product_id)) {
            // $chatHistory = Chat::with(['user','product','order','admin','company'])->where([['user_id', '=', $request->user_id], ['product_id', '=', $request->product_id], ['company_id', '=', $request->company_id]])->get();

            // $unreadChat = Chat::with(['user','product','order','admin','company'])->where([['user_id', '=', $request->user_id], ['product_id', '=', $request->product_id], ['company_id', '=', $request->company_id]])->whereNotNull('admin_id')->where('status', '=', 0)->get()->count();
            // // ['admin_id','=',$request->admin_id],
            $chatHistory = Chat::with(['user', 'product', 'order', 'admin', 'company', 'chatMessage'])->where([['user_id', '=', $request->user_id], ['product_id', '=', $request->product_id], ['company_id', '=', $request->company_id]])->get();
            $unreadChat = 0;
            foreach ($chatHistory as $key => $chat) {
                foreach ($chat->chatMessage as $key => $message) {
                    if (!is_null($message->admin_id)) {
                        if ($message->status == 0) {
                            $unreadChat += 1;
                        }
                    }
                }
            }
            $json = ['chatHistory' => $chatHistory, 'unreadChat' => $unreadChat];
        } elseif (isset($request->order_id)) {
            // $chatHistory = Chat::with(['user','product','order','admin','company'])->where([['user_id', '=', $request->user_id], ['order_id', '=', $request->order_id], ['company_id', '=', $request->company_id]])->get();

            // $unreadChat = Chat::with(['user','product','order','admin','company'])->where([['user_id', '=', $request->user_id], ['order_id', '=', $request->order_id], ['company_id', '=', $request->company_id]])->whereNotNull('admin_id')->where('status', '=', 0)->get()->count();
            // // ['admin_id','=',$request->admin_id],
            // $json = ['chatHistory' => $chatHistory, 'unreadChat' => $unreadChat];
            $chatHistory = Chat::with(['user', 'product', 'order', 'admin', 'company', 'chatMessage'])->where([['user_id', '=', $request->user_id], ['order_id', '=', $request->order_id], ['company_id', '=', $request->company_id]])->get();
            $unreadChat = 0;
            foreach ($chatHistory as $key => $chat) {
                foreach ($chat->chatMessage as $key => $message) {
                    if (!is_null($message->admin_id)) {
                        if ($message->status == 0) {
                            $unreadChat += 1;
                        }
                    }
                }
            }
            $json = ['chatHistory' => $chatHistory, 'unreadChat' => $unreadChat];
        }
        return response()->json($json);
    }

    function loadChatAdminAll(Request $request)
    {
        $loadAdminChatAll = Chat::with(['user', 'product.productimage', 'order.orderitem.orderproduct.orderproductimage', 'admin', 'company', 'chatMessage'])->where([['company_id', '=', $request->company_id]])->orderBy('updated_at', 'desc')->get();
        // $orderChats= $loadAdminChatAll->groupBy('order_id');
        // $productChats= $loadAdminChatAll->groupBy('product_id');
        // $loadAdminChatAllGrouped = ['orderChats' =>$orderChats, 'productChats'=>$productChats];
        return response()->json($loadAdminChatAll);
    }

    function updateChatStatus(Request $request)
    {
        $validatedData = $request->validate(
            [
                'user_id' => 'required',
            ]
        );
        if (isset($request->product_id)) {
            $chat = Chat::where([['user_id', '=', $request->user_id], ['product_id', '=', $request->product_id], ['company_id', '=', $request->company_id]])->first();
        } elseif (isset($request->order_id)) {
            $chat = Chat::where([['user_id', '=', $request->user_id], ['order_id', '=', $request->order_id], ['company_id', '=', $request->company_id]])->first();
        }
        if(!is_null($chat)){
            $updateChatStatus = ChatMessage::where([['chat_id', '=', $chat->id], ['status','=',0]])->whereNotNull('admin_id')->get();
            foreach ($updateChatStatus as $chatStatus) {
                $chatStatus->status = 1;
                $chatStatus->save();
            }
            if ($updateChatStatus) {
                $response = '200';
            } else {
                $response = '500 cannot update chat status';
            }
        }else{
            $response = "500 there's no data found"; 
        }

        return response()->json($response);
    }
}
