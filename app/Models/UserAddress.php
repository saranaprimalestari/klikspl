<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    public $table = "user_addresses";
    protected $guarded = ['id'];

    // protected $with = ['City', 'Province'];

    public function users()
    {
      return $this->belongsTo(User::class,'user_id');
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
