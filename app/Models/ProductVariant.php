<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    
    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
    
    public function OrderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function productOrigin()
    {
        return $this->hasMany(ProductOrigin::class);
    }
    
    public function productComment()
    {
        return $this->hasMany(ProductComment::class);
    }

}
