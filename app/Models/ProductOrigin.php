<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrigin extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsto(Product::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsto(ProductVariant::class, 'product_variant_id');
    }
    
    public function city()
    {
      return $this->belongsTo(City::class,'city_ids','city_id');
    }
    
    public function senderAddress()
    {
      return $this->belongsTo(SenderAddress::class,'sender_address_id');
    }
    
}
