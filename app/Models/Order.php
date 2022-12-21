<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    // protected $with = ['orderItem', 'orderaddress'];
    public function scopeFilter($query, array $filters)
    {
        // dd(print_r($filters));

        if ($filters['status'] == 'expired') {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('order_status', 'like', '%' . $keyword . '%')
                        ->orwhere('order_status', 'like', '%pesanan dibatalkan%');
                    // dd($query);
                });
            });
        } elseif ($filters['status'] == 'pesanan dibayarkan') {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('order_status', 'like', '%' . $keyword . '%')
                        ->orwhere('order_status', 'like', '%pembayaran ditolak%')
                        ->orwhere('order_status', 'like', '%upload ulang bukti pembayaran%');
                    // dd($query);
                });
            });
        } elseif ($filters['status'] == 'aktif') {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('order_status', 'not like', '%expired%')
                        ->where('order_status', 'not like', '%pesanan dibatalkan%')
                        ->where('order_status', 'not like', '%selesai%');
                    // dd($query);
                });
            });
        } else {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('order_status', 'like', '%' . $keyword . '%');
                    // dd($query);
                });
            });
            // dd($query->get());
        }
    }

    public function scopeFilterAdmin($query, array $filters)
    {
        // dd(print_r($filters));

        // if ($filters['status'] == 'expired') {
        // dd($filters['status']);
        $query->when($filters['status'] ?? false, function ($query, $keyword) {
            if ($keyword == 'expired') {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('order_status', 'like', '%' . $keyword . '%')
                        ->orwhere('order_status', 'like', '%pesanan dibatalkan%');
                    // dd($query);
                });
            } elseif ($keyword == 'pesanan dibayarkan') {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('order_status', 'like', '%' . $keyword . '%')
                        ->orwhere('order_status', 'like', '%upload ulang bukti pembayaran%');
                    // dd($query);
                });
            } elseif ($keyword == 'sampai tujuan') {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('order_status', 'like', '%' . $keyword . '%')
                        ->orwhere('order_status', 'like', '%selesai%')->whereIn('id', function ($query) {
                            $query->select('order_id')->from(with(new OrderItem)->getTable())->where('is_review', '=', '0');
                        });
                    // dd($query);
                });
            } elseif ($keyword == 'selesai') {
                return $query->where(function ($query) use ($keyword) {
                    // dd($keyword);
                    $query->where('order_status', 'like', '%' . $keyword . '%')->whereIn('id', function ($query) {
                        $query->select('order_id')->from(with(new OrderItem)->getTable())->where('is_review', '=', '1');
                    });
                    // dd($query);
                });
            } elseif ($keyword == 'aktif') {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('order_status', 'not like', '%expired%')
                        ->where('order_status', 'not like', '%pesanan dibatalkan%')
                        ->where('order_status', 'not like', '%selesai%');
                    // dd($query);
                });
            } else {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('order_status', 'like', '%' . $keyword . '%');
                    // dd($query);
                });
            }
        });
        // } elseif ($filters['status'] == 'pesanan dibayarkan') {
        //     // dd($filters['status']);
        //     $query->when($filters['status'] ?? false, function ($query, $keyword) {
        //         return $query->where(function ($query) use ($keyword) {
        //             // $keyword = 'pesanan dibatalkan';
        //             // dd($keyword);
        //             $query->where('order_status', 'like', '%' . $keyword . '%')
        //                 ->orwhere('order_status', 'like', '%upload ulang bukti pembayaran%');
        //             // dd($query);
        //         });
        //     });
        // } else {
        //     $query->when($filters['status'] ?? false, function ($query, $keyword) {
        //         return $query->where(function ($query) use ($keyword) {
        //             $query->where('order_status', 'like', '%' . $keyword . '%');
        //             // dd($query);
        //         });
        //     });
        // }
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->with(['orderitem.orderproduct' => function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }]);
        });
        $query->when($filters['date_start'] ?? false, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->where('created_at', '>=', Carbon::parse($keyword)->toDatetimeString());
                // dd($query);
            });
        });
        $query->when($filters['date_end'] ?? false, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->where('created_at', '<=', Carbon::parse($keyword)->toDatetimeString());
                // dd($query);
            });
        });
        $query->when($filters['orderBy'] ?? false, function ($query, $keyword) {
            if ($keyword == 'desc') {
                return $query->orderByDesc('created_at');
            } else {
                return $query->orderBy('created_at');
            }
        });
    }

    // public function scopeFilterSearch($query, array $filters)
    // {
    //     // dd($filters['date_start']);
    //     // dd(Carbon::parse($filters['date_start'])->toDatetimeString());
    //     // $query->when($filters['search'] ?? false, function ($query, $category) {
    //     //     return $query->whereHas('orderitem', function ($query) use ($category) {
    //     //         return $query->whereHas('orderproduct', function ($query) use ($category) {
    //     //             // $query->where('price', $category);
    //     //             $query->where('name', $category);
    //     //             dd($query);
    //     //         });
    //     //     });
    //     // });
    //     $query->when($filters['search'] ?? false, function ($query, $search) {
    //         return $query->with(['orderitem.orderproduct' => function($query) use ($search){
    //             $query->where('name','like','%'.$search.'%');

    //         }]);
    //     });
    //     $query->when($filters['date_start'] ?? false, function ($query, $keyword) {
    //         return $query->where(function ($query) use ($keyword) {
    //             $query->where('created_at', '>=', Carbon::parse($keyword)->toDatetimeString());
    //             // dd($query);
    //         });
    //     });
    //     $query->when($filters['date_end'] ?? false, function ($query, $keyword) {
    //         return $query->where(function ($query) use ($keyword) {
    //             $query->where('created_at', '<=', Carbon::parse($keyword)->toDatetimeString());
    //             // dd($query);
    //         });
    //     });
    //     // dd($query);
    // }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderaddress()
    {
        return $this->belongsTo(OrderAddress::class, 'order_address_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderDeliveryStatus()
    {
        return $this->hasMany(OrderDeliveryStatus::class);
    }

    public function orderStatusDetail()
    {
        return $this->hasMany(OrderStatusDetail::class);
    }

    public function userPayment()
    {
        return $this->hasOne(UserPayment::class);
    }

    public function productComment()
    {
        return $this->hasMany(ProductComment::class);
    }

    public function scopeUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function senderAddress()
    {
        return $this->belongsTo(SenderAddress::class, 'sender_address_id');
    }

    public function UserPromoOrderUse()
    {
        return $this->hasMany(UserPromoOrderUse::class);
    }

    public function adminNotification()
    {
        return $this->hasMany(AdminNotification::class);
    }
    
    public function chat()
    {
        return $this->hasMany(Chat::class);
    }

}
