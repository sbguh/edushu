<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //

    protected $table = 'items';
    protected $fillable = [
                    'name','barcode','unit', 'sale_price', 'cost_price', 'description',
    ];
}
