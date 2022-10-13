<?php

namespace App\Models;

use App\Models\Promo;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPromo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function Product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    
    public function Promo()
    {
        return $this->belongsTo(Promo::class,'promo_id');
    }
    
}
