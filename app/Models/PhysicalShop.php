<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalShop extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address','is_web_shop'];
}
