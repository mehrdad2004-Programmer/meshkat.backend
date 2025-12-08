<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use App\Models\v1\BasketModel;
use App\Models\v1\PaymentModel;
use App\Models\v1\AccessLogsModel;

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

    public function products_basket(){
        return $this->hasMany(BasketModel::class, "tr_code", "tr_code");
    }

    public function products_access_logs(){
        return $this->hasMany(AccessLogsModel::class, "tr_code", "tr_code");
    }

    public function products_payment(){
        return $this->hasMany(PaymentModel::class, "tr_code", "tr_code");
    }

}
