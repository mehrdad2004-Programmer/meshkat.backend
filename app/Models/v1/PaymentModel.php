<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;

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
}
