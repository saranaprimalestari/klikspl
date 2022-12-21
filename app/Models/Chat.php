<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    
    public function chatMessage()
    {
        return $this->hasMany(ChatMessage::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    
    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
}
