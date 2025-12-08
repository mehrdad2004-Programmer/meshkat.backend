<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\AccessLogsModel;
use App\Models\v1\ProductsModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;


class ProductsController extends Controller
{
    public function insertProducts(Request $request){
        try{
            // Getting the Shamsi date
            $date = Jalalian::forge(Carbon::now())->format('Y/m/d');  // Convert to Shamsi

            // Getting time in Tehran timezone
            $time = Carbon::now()->setTimezone("Asia/Tehran")->format("H:i:s");

            //getting data
            $all = $request->all();
            $all['date'] = $date;
            $all['time'] = $time;
            $all['ip_address'] = $request->ip();
            $all['user_agent'] = $request->userAgent();
            $all['op_type'] = "insert_product";

            DB::beginTransaction();
            ProductsModel::create($all);
            AccessLogsModel::create($all);
            DB::commit();

            return response()->json([
                "msg" => "inserted",
                "statuscode" => 201
            ], 201);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }
}
