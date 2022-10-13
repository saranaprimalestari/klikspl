<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(UserAddress::class,'user_id');
    }

    // public function Product()
    // {
    //     return $this->hasMany(Product::class);
    // }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_id');
    }
    public function getRouteKeyName()
    {
        return 'id';
    }
    public function senderAddress()
    {
      return $this->belongsTo(SenderAddress::class,'sender_address_id');
    }
}
