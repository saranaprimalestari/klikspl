<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductComment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeFilterAdmin($query, array $filters)
    {
        // dd($filters);
        $query->when($filters['star'] ?? false, function ($query, $keyword) {
            return $query->orderBy('star', $keyword);
        });
        $query->when($filters['created_at'] ?? false, function ($query, $keyword) {
            return $query->orderBy('created_at', $keyword);
        });
        $query->when($filters['invoice_no'] ?? false, function ($query, $keyword) {
            return $query->orderBy('invoice_no', $keyword);
        });
    }

    public function product()
    {
        return $this->belongsto(Product::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsto(ProductVariant::class, 'product_variant_id');
    }

    public function user()
    {
        return $this->belongsto(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // public function userAdmin()
    // {
    //     return $this->belongsTo(Order::class, 'useradmin_id');
    // }
    // public function Admin()
    // {
    //     return $this->belongsTo(Order::class, 'admin_id');
    // }
    public function Admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'reply_comment_id');
    }

    // public function parent()
    // {
    //     return $this->belongsTo(self::class, 'id');
    // }

    public function parent()
    {
        return $this->belongsTo(self::class, 'reply_comment_id');
    }
}
