<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\ShoppingDetailsModel;
use App\Models\v1\ShoppingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

class ShoppingController extends Controller
{
    public function insert(Request $request)
    {
        try {
            DB::beginTransaction();
            ShoppingModel::create($request->all());
            ShoppingDetailsModel::insert($request->details);
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


            $res = $data->get();

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
