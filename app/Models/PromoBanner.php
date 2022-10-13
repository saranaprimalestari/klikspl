<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoBanner extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        // dd(print_r($filters));
       
        if ($filters['status'] == 'aktif') {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->orwhere(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('is_active', '=', 1)->where('start_period', '<=', Carbon::now())->where('end_period', '>=', Carbon::now());
                    // dd($query);
                });
            });
        }if ($filters['status'] == 'tidak aktif') {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->orwhere(function ($query) use ($keyword) {
                    // $keyword = 'pesanan dibatalkan';
                    // dd($keyword);
                    $query->where('is_active', '=', 0)->where('start_period', '<=', Carbon::now())->where('end_period', '>=', Carbon::now());
                    // dd($query);
                });
            });
        }elseif ($filters['status'] == 'akan datang') {
            // dd($filters['status']);
            $query->when($filters['status'] ?? false, function ($query, $keyword) {
                return $query->orwhere(function ($query) use ($keyword) {
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

    public function Admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}
