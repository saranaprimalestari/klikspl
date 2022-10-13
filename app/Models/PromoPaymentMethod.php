<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoPaymentMethod extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    
    public function promo()
    {
        return $this->belongsTo(Promo::class,'promo_id');
    }
    
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
