<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function admin()
    {
      return $this->belongsTo(Admin::class,'admin_id');
    }
    
    public function adminType()
    {
      return $this->belongsTo(AdminType::class,'admin_type');
    }
    
    public function company()
    {
      return $this->belongsTo(Company::class,'company_id');
    }
    
    public function order()
    {
      return $this->belongsTo(Order::class,'order_id');
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
