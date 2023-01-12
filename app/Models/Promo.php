<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use HasFactory;
    use Sluggable;
    protected $guarded = ['id'];
    
    public function scopeFilterIndex($query, array $filters)
    {
        // dd(print_r($filters));
       
        if ($filters['status'] == 'aktif') {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('is_active', '=', 1)->where('start_period', '<=', Carbon::now())->where('end_period', '>=', Carbon::now());
                    // dd($query);
                });
            });
        }if ($filters['status'] == 'tidak aktif') {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('is_active', '=', 0)->where('end_period', '<', Carbon::now());
                    // dd($query);
                });
            });
        }elseif ($filters['status'] == 'akan datang') {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('start_period', '>', Carbon::now())
                        ->where('end_period', '>', Carbon::now());
                    // dd($query);
                });
            });
        }elseif ($filters['status'] == 'sudah berakhir') {
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->where('end_period', '<', Carbon::now());
                    // dd($query);
                });
            });
        }
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
        
    public function PromoPaymentMethod()
    {
        return $this->hasMany(PromoPaymentMethod::class);
    }
    
    public function promoType()
    {
        return $this->belongsTo(PromoType::class, 'promo_type_id');
    }
    
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    
    public function ProductPromo()
    {
        return $this->hasMany(ProductPromo::class);
    }
    
    public function UserPromoUse()
    {
        return $this->hasMany(UserPromoUse::class);
    }
    
    public function UserPromoOrderUse()
    {
        return $this->hasMany(UserPromoOrderUse::class);
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
