<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\BasketModel;
use App\Models\v1\ShoppingDetailsModel;
use App\Models\v1\ShoppingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

class ShoppingController extends Controller
{
    public function generate_code(){
        $id = ShoppingModel::orderBy("id", "desc")->first();

        $code = $id ? $id->id + 1000 : 1000;

        return $code;
    }

    public function insert(Request $request)
    {
        try {

            // Getting the Shamsi date
            $date = Jalalian::forge(Carbon::now())->format('Y/m/d');  // Convert to Shamsi

            // Getting time in Tehran timezone
            $time = Carbon::now()->setTimezone("Asia/Tehran")->format("H:i:s");

            $basket = BasketModel::where("status", "pending")
                ->where("username", $request->username)->get()->toArray();


            $new_basket = [];

            foreach($basket as $item){
                $item['p_code'] = $item['tr_code'];
                $item['tr_code'] = $this->generate_code();
                array_push($new_basket, $item);
            }

            $request->merge([
                "tr_code" => $this->generate_code(),
                "date" => $date,
                "time" => $time,
                "details" => $new_basket
            ]);

            DB::beginTransaction();
            ShoppingModel::create($request->all());
            foreach($request->details as $item){
                ShoppingDetailsModel::create($item);
            }
            BasketModel::where("username", $request->username)
            ->where("status", "pending")
            ->delete();
            DB::commit();

            return response()->json([
                "msg" => "inserted",
                "statuscode" => 201
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }

    public function get(Request $request)
    {
        try {
            $data = ShoppingModel::with([
                'shopping_details' => function($q) use ($request){
                    $q->with("shopping_products");
                },
                'user_shopping',
            ]);

            if($request->status){
                $data->where("status", $request->status);
            }

            if($request->tr_code){
                $data->where("tr_code", $request->tr_code);
            }


            $res = $data->orderBy("id", 'desc')->get();

            if ($res->isEmpty()) {
                return response()->json([
                    "msg" => "not found",
                    "statuscode" => 404
                ], 404);
            }

            return response()->json([
                "msg" => $res,
                "statuscode" => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $updated = ShoppingModel::where("tr_code", $request->tr_code)->update([
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
}
