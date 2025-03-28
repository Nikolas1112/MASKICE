<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WriteOffSupplies extends Model
{
    use HasFactory;

    protected $fillable = ['shop_name', 'product_sku_code','writeoff_quantities','reason','added_at'];

    protected $table = 'writeoff_supplies';
    

}
