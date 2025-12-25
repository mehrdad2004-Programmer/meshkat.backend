<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class ShoppingDetailsModel extends Model
{
    protected $table = "shopping_details";

    protected $fillable = [
        "tr_code",
        "p_code",
    ];
}
