<?php

namespace App\Models;

use App\Http\Controllers\OrderController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function PromoPaymentMethod()
    {
        return $this->hasMany(PromoPaymentMethod::class);
    }
}
