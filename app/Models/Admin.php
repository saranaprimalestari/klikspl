<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    use HasFactory;
    use Notifiable;
    protected $guarded = ['id'];

    public function admintype()
    {
        return $this->belongsTo(AdminType::class, 'admin_type');
    }

    public function productComment()
    {
        return $this->hasMany(ProductComment::class);
    }
    
    public function adminNotification()
    {
        return $this->hasMany(AdminNotification::class);
    }
    
    public function PromoBanner()
    {
        return $this->hasMany(PromoBanner::class);
    }

    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function AdminSenderAddress()
    {
        return $this->hasMany(AdminSenderAddress::class);
    }

    public function chat()
    {
        return $this->hasMany(Chat::class);
    }

}
