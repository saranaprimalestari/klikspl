<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function orderProductImage()
    {
        return $this->hasMany(OrderProductImage::class);    
    }

}
