<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\User;
use App\Models\Order;
use App\Models\Visitor;
use App\Models\CartItem;
use App\Models\ChatMessage;
use App\Models\ProductMerk;
use App\Models\ProductCategory;
use App\Models\UserNotification;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // config(['app.locale' => 'id']);
        // Carbon::setLocale('id');
        // date_default_timezone_set('Asia/Jakarta');
        
        $categories = ProductCategory::all();
        $partialCategories = ProductCategory::take(12)->get();
        View::share('categories', $categories);
        View::share('partialCategories', $partialCategories);

        $merks = ProductMerk::all();
        $partialMerks = ProductMerk::take(12)->get();
        View::share('merks', $merks);
        View::share('partialMerks', $partialMerks);

        $visitorDay = Visitor::where('created_at', 'like', Carbon::now()->format('Y-m-d') .'%')->get();
        $visitorThisMonth = Visitor::whereBetween('created_at', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->get();
        $visitorTotal = Visitor::all();
        View::share('visitorDay', $visitorDay);
        View::share('visitorThisMonth', $visitorThisMonth);
        View::share('visitorTotal', $visitorTotal);

        view()->composer('*', function ($view) {
            // dd($chats);
            if (Auth::check()) {
                // $chats = (DB::table(function($query){
                //     $query->selectRaw('*')
                //     ->from('chat_messages')
                //     ->orderBy('created_at','desc')
                //     ->limit(18446744073709551);
                // }, 'sub')->groupBy('sub.user_id','sub.product_id', 'sub.order_id')->get());
                // $chats = ChatMessage::where('user_id','=', auth()->user()->id)->orderBy('created_at','desc')->get();
                // $orderChats= $chats->groupBy('order_id');
                // $productChats= $chats->groupBy('product_id');
                // $userChatsGrouped = ['orderChats' =>$orderChats, 'productChats'=>$productChats];
                // dd($userChatsGrouped);
                // $chats = Chat::with(['chatmessage.chat'])->join('chat_messages', function($join){ $join->on('chats.id', '=', 'chat_messages.chat_id')->where('chat_messages.status', '=', 0)->whereNotNull('chat_messages.admin_id');})->get();
                $chats = ChatMessage::where([['status','=',0], ['user_id','=', auth()->user()->id]])->whereNotNull('admin_id')->orderBy('updated_at','desc')->get();
                $view->with('userCartItems', CartItem::where('user_id', auth()->user()->id)->with(['product', 'productvariant'])->get()->sortByDesc('created_at'));
                $view->with('userNotifications', UserNotification::where('user_id', auth()->user()->id)->where('is_read', '=', '0')->get()->sortByDesc('created_at'));
                $view->with('userOrders', Order::where([['user_id' ,'=', auth()->user()->id], ['order_status', '!=', 'selesai']])->get()->sortByDesc('created_at'));
                $userChatsGrouped = ['userChats' =>$chats, 'userChatGroupped'=>$chats->groupBy('chat_id')];
                $view->with('userChats', $userChatsGrouped);
                // $view->with('orderChats', $orderChats);
                // $view->with('productChats', $productChats);
                
                // $view->with('userChats', ChatMessage::where('user_id' ,'=', auth()->user()->id)->orderBy('created_at','desc')->groupBy('user_id','product_id', 'order_id')->get());

                // $view->with('userNotifications',UserNotification::where('user_id',auth()->user()->id)->get());
            }
        });
        view()->composer('*', function($view){
            if(auth::guard('adminMiddle')->check()){
                if(auth()->guard('adminMiddle')->user()->admin_type == 1){
                    $view->with('adminNotifications',AdminNotification::where('is_read', '=', '0')->get()->sortByDesc('created_at'));
                }elseif(auth()->guard('adminMiddle')->user()->admin_type == 2){
                    $view->with('adminNotifications',AdminNotification::where('is_read', '=', '0')->where('company_id', auth()->guard('adminMiddle')->user()->company_id)->get()->sortByDesc('created_at'));
                }elseif(auth()->guard('adminMiddle')->user()->admin_type == 3){
                    $view->with('adminNotifications',AdminNotification::where('is_read', '=', '0')->where('admin_type','=',auth()->guard('adminMiddle')->user()->admin_type)->get()->sortByDesc('created_at'));
                }else{
                    $view->with('adminNotifications',AdminNotification::where('is_read', '=', '0')->where('admin_type','=',auth()->guard('adminMiddle')->user()->admin_type)->where('company_id', auth()->guard('adminMiddle')->user()->company_id)->get()->sortByDesc('created_at'));
                }
            }
        });
    }
}
