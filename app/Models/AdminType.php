<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminType extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function userAdmin()
    // {
    //     return $this->hasMany(UserAdmin::class);
    // }
    public function Admin()
    {
        return $this->hasMany(Admin::class);
    }
}
