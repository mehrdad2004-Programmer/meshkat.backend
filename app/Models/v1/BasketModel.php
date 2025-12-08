<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\v1\ProductsModel;

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

    public function user_basket(){
        return $this->belongsTo(User::class, "username", 'username');
    }

    public function products_basket(){
        return $this->belongsTo(ProductsModel::class, "tr_code", "tr_code");
    }
}
