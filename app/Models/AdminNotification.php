<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
      return $this->belongsTo(Admin::class,'admin_id');
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
