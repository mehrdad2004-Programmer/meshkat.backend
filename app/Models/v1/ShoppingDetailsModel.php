<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use App\Models\v1\ShoppingModel;
use App\Models\v1\ProductsModel;

class ShoppingDetailsModel extends Model
{
    protected $table = "shopping_details";

    protected $fillable = [
        "tr_code",
        "p_code",
    ];

    public function shopping_details()
    {
        return $this->belongsTo(ShoppingModel::class, "tr_code", "tr_code");
    }


    public function shopping_products()
    {
        return $this->belongsTo(ProductsModel::class, 'p_code', 'tr_code');
    }
}
