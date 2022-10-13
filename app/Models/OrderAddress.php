<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderAddress extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    
    public function city()
    {
      return $this->belongsTo(City::class,'city_ids','city_id');
    }

    public function province()
    {
      return $this->belongsTo(Province::class,'province_ids','province_id');
    }
}
