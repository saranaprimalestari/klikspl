<?php

namespace App\Providers;

use App\Models\AdminNotification;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\ProductMerk;
use App\Models\ProductCategory;
use App\Models\UserNotification;
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

        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('userCartItems', CartItem::where('user_id', auth()->user()->id)->with(['product', 'productvariant'])->get()->sortByDesc('created_at'));
                $view->with('userNotifications', UserNotification::where('user_id', auth()->user()->id)->where('is_read', '=', '0')->get()->sortByDesc('created_at'));
                $view->with('userOrders', Order::where([['user_id' ,'=', auth()->user()->id], ['order_status', '!=', 'selesai']])->get()->sortByDesc('created_at'));

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

// dd(session()->all());
// dd(Auth::user());
// dd(auth()->user());
// $userCartItems = User::firstwhere('id',auth()->user())->with('cartItem')->get();
// View::share('userCartItems',$userCartItems);
// dd(User::where('id',auth()->user()->id)->with('cartItem')->get());
// if (Auth::check()) {
//     View::composer('*',function($view){
//         $view->with('userCartItems',User::where('id',auth()->user()->id)->with('cartItem')->get());
//     });
// }else{

// }