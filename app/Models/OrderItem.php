<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $with = ['order', 'user', 'product', 'productVariant', 'orderproduct'];

    public function order()
    {
        return $this->belongsto(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsto(User::class, 'user_id');
    }

    // public function Product()
    // {
    //     return $this->hasMany(Product::class);
    // }

    public function product()
    {
        return $this->belongsto(Product::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function orderproduct()
    {
        return $this->belongsto(OrderProduct::class, 'order_product_id');
    }
    
    public function scopeUserId($query,$userId)
    {
        return $query->where('user_id',$userId);
    }
    

}
