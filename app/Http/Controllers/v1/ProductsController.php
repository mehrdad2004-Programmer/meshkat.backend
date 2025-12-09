<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\ProductsModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

            $inserted = ProductsModel::create($all);

            if(!$inserted){
                return response()->json([
                    "msg" => "not inserted",
                    "statuscode" => 400
                ], 400);
            }

            return response()->json([
                "msg" => "inserted",
                "statuscode" => 201
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }

    public function updateProducts(Request $request){
        try{
            $updated = ProductsModel::where("tr_code", $request->tr_code)->update($request->all());

            if(!$updated){
                return response()->json([
                    "msg" => "not updated",
                    "statuscode" => 400
                ], 400);
            }

            return response()->json([
                "msg" => "updated",
                "statuscode" => 200
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }

    public function deleteProducts(Request $request){
        try{
            $deleted = ProductsModel::where("tr_code", $request->tr_code)->delete();

            if(!$deleted){
                return response()->json([
                    "msg" => "deleted",
                    'statuscode' => 200
                ], 200);
            }

            return response()->json([
                "msg" => "not deleted",
                "statuscode" => 400
            ], 400);
        }catch(\Exception $e){
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }


    public function readProducts(Request $request){
        try{
            $result = ProductsModel::query();
            if($request->panel){
                $paginate = $result->paginate(10) ?? null;
                $statuscode = 404;
                if($paginate){
                    $statuscode = 200;
                }
                return response()->json([
                    "msg" => $paginate,
                    "statuscode" => $statuscode
                ], $statuscode);
            }

            $lastFive = $result->orderBy("id", "desc")->take(5)->get() ?? null;
            $statuscode = 404;
            if($lastFive){
                $statuscode = 200;
            }

            return response()->json([
                "msg" => $lastFive,
                "statuscode" => $statuscode
            ], $statuscode);

        }catch(\Exception $e){
            return response()->json([
                "msg" => $e->getMessage() . ' at line ' . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }
}
