<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function admintype()
    {
        return $this->belongsTo(AdminType::class, 'admin_type');
    }

    public function productComment()
    {
        return $this->hasMany(ProductComment::class);
    }
}
