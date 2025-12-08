<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\v1\AccessLogsModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        try{
            //getting local date and time
            $date = Carbon::now()->local('fa')->isoformat('Y/M/D');
            $time = Carbon::now()->setTimezone("Asia/Tehran")->format("H:i:s");

            //setting requests
            $all = $request->all();
            $all['date'] = $date;
            $all['time'] = $time;
            $all['ip_address'] = $request->ip();
            $all['user_agent'] = $request->userAgent();
            $all['op_type'] = "create_user";

            $inserted = User::create($all);

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

    public function login(Request $request){
        try{
            $user = User::where("username", $request->username)->first();

            if($user && Hash::check($request->password, $user->password)){
                return response()->json([
                    "msg" => "logged in",
                    "statuscode" => 200
                ], 200);
            }

            return response()->json([
                "msg" => "username or password is incorrect",
                "statuscode" => 400
            ], 400);

        }catch(\Exception $e){
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }

    public function changePassword(Request $request){
        try{
            $updated = User::where("username", $request->username)->update([
                "password" => $request->password
            ]);

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

    public function changeInfo(Request $request){
        try{
            $updated = User::where("username", $request->username)->update($request->all());

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
}
