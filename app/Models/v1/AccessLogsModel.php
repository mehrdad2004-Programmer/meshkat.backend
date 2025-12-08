<?php

namespace App\Models\v1;

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
}
