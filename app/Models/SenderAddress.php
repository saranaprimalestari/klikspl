<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenderAddress extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function city()
    {
      return $this->belongsTo(City::class,'city_ids','city_id');
    }

    public function province()
    {
      return $this->belongsTo(Province::class,'province_ids','province_id');
    }
    
    public function productorigin()
    {
        return $this->hasMany(ProductOrigin::class);
    }
    
    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
    
    public function order()
    {
        return $this->hasMany(Order::class);
    }

}
