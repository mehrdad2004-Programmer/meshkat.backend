<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class ShoppingModel extends Model
{
    protected $table = "shopping";

    protected $fillable = [
        "username",
        "date",
        "time",
        "tr_code",
        "status"
    ];
}
