<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPromoUse extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function User()
    {
      return $this->belongsTo(User::class,'user_id');
    }

    public function Promo()
    {
      return $this->belongsTo(Promo::class,'promo_id');
    }
}
