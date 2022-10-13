<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Admin()
    {
        return $this->hasMany(Admin::class);
    }

    public function PromoBanner()
    {
        return $this->hasMany(PromoBanner::class);
    }
    
    public function Product()
    {
        return $this->hasMany(Product::class);
    }
}
