<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundOrderPayment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function order()
    {
      return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
      return $this->belongsTo(User::class,'user_id');
    }    

    public function company()
    {
      return $this->belongsTo(company::class,'company_id');
    }    

    public function admin_id()
    {
      return $this->belongsTo(Admin::class,'admin_id');
    }
    
}
