<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use App\Models\v1\ProductsModel;
use App\Models\User;

class PaymentModel extends Model
{
    protected $table = "payment";

    protected $fillable = [
        "tr_code",
        "username",
        "amount",
        "date",
        "time",
        "athority",
        "ref_id",
        "status"
    ];

    public function user_payment(){
        return $this->belongsTo(User::class, "username", 'username');
    }

    public function products_payment(){
        return $this->belongsTo(ProductsModel::class, "tr_code", "tr_code");
    }
}
