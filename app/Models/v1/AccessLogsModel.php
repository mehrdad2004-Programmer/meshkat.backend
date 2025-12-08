<?php

namespace App\Models\v1;

use App\Models\User;
use App\Models\v1\ProductsModel;
use Illuminate\Database\Eloquent\Model;

class AccessLogsModel extends Model
{
    protected $table = "access_logs";

    protected $fillable = [
        "tr_code",
        "username",
        "date",
        "time",
        "ip_address",
        "user_agent",
        "op_type",
    ];

    public function user_access_logs(){
        return $this->belongsTo(User::class, "username", "username");
    }

    public function products_access_logs(){
        return $this->belongsTo(ProductsModel::class, "tr_code", "tr_code");
    }
}
