<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GhasedakSMSController extends Controller
{
    public function sendMessage(Request $request){
        try{
            $data = [
                "receptors" => [
                    [
                        "mobile" => $request->phone_no
                    ]
                ],
                "templateName" => "asawebinar",
                "isVoice" => false,
                "udh" => false
            ];

            foreach($request->params as $index=>$item){
                $data[$index] = $item;
            }

            $fetch = Http::withHeaders([
                "Content-Type" => "application/json",
                "ApiKey" => env('GHASEDAK_API_KEY'),
            ])
                ->post("https://gateway.ghasedak.me/rest/api/v1/WebService/SendOtpWithParams", $data);

            return response()->json([
                "msg" => $fetch->json(),
                "statuscode" => $fetch->status()
            ], $fetch->status());

        }catch(\Exception $e){
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }
}
