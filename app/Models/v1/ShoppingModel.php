<?php

namespace App\Models\v1;

use App\Models\User;
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

    public function user_shopping(){
        return $this->belongsTo(User::class, "username", "username");
    }
}
