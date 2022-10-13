<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory;
    use Sluggable;
    protected $guarded = ['id'];
    // protected $with = ['ProductCategory', 'ProductMerk'];

    public function scopeFilter($query, array $filters)
    {
        // dd(print_r($filters));
        $query->when($filters['keyword'] ?? false, function ($query, $keyword){
            return $query->where(function($query) use ($keyword){
                $query->where('name', 'like' ,'%' . $keyword . '%');
            });
        });

        $query->when($filters['category'] ?? false, function ($query, $category){
            return $query->whereHas('productcategory', function($query) use ($category){
                $query->where('slug', $category);
            });
        });
        // dd($filters['merk']);
        $query->when($filters['merk'] ?? false, function ($query, $merk){
            return $query->whereHas('productmerk', function($query) use ($merk){
                $query->where('slug', $merk);
            });
        });
        // dd($filters['sortby']);
        $query->when($filters['sortby'] ?? false, function ($query, $sortby){
            if($sortby == 'Terbaru'){
                return $query->latest();
            }elseif($sortby == 'Terbaik'){
                return $query->latest();
            }elseif($sortby == 'Terlaris'){
                return $query->orderByDesc('sold');
            }elseif($sortby == 'Dilihat Terbanyak'){
                return $query->orderByDesc('view');
            }elseif($sortby == 'Harga Terendah'){
                return $query->latest();
            }elseif($sortby == 'Harga Tertinggi'){
                return $query->latest();
            }
        });
        // dd($query);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class,'product_category_id');
    }

    public function productMerk()
    {
        return $this->belongsTo(ProductMerk::class,'product_merk_id');
    }
    
    public function promo()
    {
        return $this->belongsTo(Promo::class,'promo_id');
    }

    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productComment()
    {
        return $this->hasMany(ProductComment::class);
    }

    public function productVariant()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // public function ProductView()
    // {
    //     return $this->hasMany(ProductView::class);
    // }

    // public function CartItem()
    // {
    //     return $this->hasMany(CartItem::class);
    // }

    public function OrderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function OrderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }

    public function productOrigin()
    {
        return $this->hasMany(ProductOrigin::class);
    }
    
    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    
    public function ProductPromo()
    {
        return $this->hasMany(ProductPromo::class);
    }
    
    
}
