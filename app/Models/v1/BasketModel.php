<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

class BasketModel extends Model
{
    protected $table = "basket";

    protected $fillable = [
        "tr_code",
        "date",
        "time",
        "username",
        "status",
    ];
}
