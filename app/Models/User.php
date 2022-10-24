<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userAddress()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function userNotification()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function productComment()
    {
        return $this->hasMany(ProductComment::class);
    }

    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    
    public function UserPromoUse()
    {
        return $this->hasMany(UserPromoUse::class);
    }
    
    public function UserPromoOrderUse()
    {
        return $this->hasMany(UserPromoOrderUse::class);
    }
    
    public function getRouteKeyName()
    {
        return 'username';
    }

}
