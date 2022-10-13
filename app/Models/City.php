<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    use HasFactory;
    // public $table = "cities";
    protected $guarded=['id'];
    protected $fillable=['city_id','province_id','type','name','postal_code'];
    
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
    
    public function productorigin()
    {
        return $this->hasMany(ProductOrigin::class);
    }

}
