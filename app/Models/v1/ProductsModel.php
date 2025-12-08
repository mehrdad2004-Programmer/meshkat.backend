<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    protected $table = "products";

    protected $fillable = [
        "title",
        "price",
        "date",
        'time',
        "mixture",
        "tr_code",
        "categoury"
    ];
}
