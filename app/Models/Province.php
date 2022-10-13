<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    // public $table = "provinces";
    protected $guarded = ['id'];
    protected $fillable=['province_id','name'];
       
    public function useraddress()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function senderaddress()
    {
        return $this->hasMany(SenderAddress::class);
    }
       
    public function orderaddress()
    {
        return $this->hasMany(orderAddress::class);
    }

}
