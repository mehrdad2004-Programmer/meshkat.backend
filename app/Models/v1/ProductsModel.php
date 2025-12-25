<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use App\Models\v1\BasketModel;
use App\Models\v1\PaymentModel;
use App\Models\v1\ShoppingDetailsModel;

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
        "categoury",
        "thumbnail"
    ];

    public function products_basket(){
        return $this->hasMany(BasketModel::class, "tr_code", "tr_code");
    }

    public function products_payment(){
        return $this->hasMany(PaymentModel::class, "tr_code", "tr_code");
    }

    public function shopping_products()
    {
        return $this->hasMany(ShoppingDetailsModel::class, 'p_code', 'tr_code');
    }

}
