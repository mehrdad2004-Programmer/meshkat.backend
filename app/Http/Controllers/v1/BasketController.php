<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\BasketModel;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class BasketController extends Controller
{
    public function insertBasket(Request $request)
    {
        try {

            // Getting the Shamsi date
            $date = Jalalian::forge(Carbon::now())->format('Y/m/d');  // Convert to Shamsi

            // Getting time in Tehran timezone
            $time = Carbon::now()->setTimezone("Asia/Tehran")->format("H:i:s");


            $all = $request->all();
            $all['date'] = $date;
            $all['time'] = $time;

            BasketModel::create($all);

            return response()->json([
                "msg" => "inserted",
                "statuscode" => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }

    public function deleteBasket(Request $request)
    {
        try {

            $deleted = BasketModel::where("tr_code", $request->tr_code)->delete();

            if (!$deleted) {
                return response()->json([
                    "msg" => "not deleted",
                    "statuscode" => 400
                ], 400);
            }

            return response()->json([
                "msg" => "deleted",
                "statuscode" => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }

    public function updateBasket(Request $request)
    {

        try {
            //this method will update status of basket to show wich products has been bought

            $updated = BasketModel::where("tr_code", $request->tr_code)->update([
                "status" => $request->status
            ]);

            if (!$updated) {
                return response()->json([
                    "msg" => "not updated",
                    "statuscode" => 400
                ], 400);
            }

            return response()->json([
                "msg" => "updated",
                "statuscode" => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }

    public function readBasket(Request $request)
    {
        try {
            $query = BasketModel::query();

            if($request->status){
                $query->where("status", $request->status);
            }

            if($request->username){
                $query->where("username", $request->username);
            }

            $baskets = $query->with([
                "products_basket",
                "user_basket"
            ])->groupBy("username")->get();

            return response()->json([
                "msg" => $baskets,
                "statuscode" => 200
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }
}
