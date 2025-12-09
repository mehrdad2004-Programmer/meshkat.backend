<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\ProductsModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;


class ProductsController extends Controller
{
    public function insertProducts(Request $request)
    {
        try {
            // Getting the Shamsi date
            $date = Jalalian::forge(Carbon::now())->format('Y/m/d');  // Convert to Shamsi

            // Getting time in Tehran timezone
            $time = Carbon::now()->setTimezone("Asia/Tehran")->format("H:i:s");

            //getting data
            $all = $request->all();
            $all['date'] = $date;
            $all['time'] = $time;

            if ($request->hasFile("thumbnail")) {
                // Get the uploaded file
                $file = $request->file("thumbnail");

                // Generate a unique file name using time() and the original file extension
                $filename = time() . "." . $file->getClientOriginalExtension();

                // Store the file in the 'public' disk and move it to the 'uploads' directory
                if ($file->storeAs('uploads', $filename, 'public')) {
                    // Add the filename to the data to be inserted
                    $all['thumbnail'] = $filename;
                    $inserted = ProductsModel::create($all);

                    if (!$inserted) {
                        return response()->json([
                            "msg" => "not inserted",
                            "statuscode" => 400
                        ], 400);
                    }

                    return response()->json([
                        "msg" => "inserted",
                        "statuscode" => 201
                    ], 201);
                }

                // Return success response
                return response()->json([
                    'msg' => 'not uploaded',
                    "statuscode" => 400
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                "msg" => $e->getMessage() . " at line " . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }

    public function updateProducts(Request $request)
    {
        try {
            // Check if a new thumbnail file is provided
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                // Store the new thumbnail in the 'uploads' folder under the public disk
                $file->storeAs('uploads', $filename, 'public');

                // Add the new filename to the request data
                $request->merge(['thumbnail' => $filename]);
            }

            // Update the product based on the tr_code
            $updated = ProductsModel::where("tr_code", $request->tr_code)->update($request->except('tr_code'));

            // Check if the update was successful
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


    public function deleteProducts(Request $request)
    {
        try {
            $deleted = ProductsModel::where("tr_code", $request->tr_code)->delete();

            if (!$deleted) {
                return response()->json([
                    "msg" => "not deleted",
                    'statuscode' => 400
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


    public function readProducts(Request $request)
    {
        try {
            $result = ProductsModel::query();

            // For paginated result
            if ($request->panel) {
                $paginate = $result->paginate(10);
                $statuscode = $paginate->isEmpty() ? 404 : 200;
                return response()->json([
                    "msg" => $paginate,
                    "statuscode" => $statuscode
                ], $statuscode);
            }

            // For the last 5 products
            $lastFive = $result->orderBy("id", "desc")->take(5)->get();
            $statuscode = $lastFive->isEmpty() ? 404 : 200;

            return response()->json([
                "msg" => $lastFive,
                "statuscode" => $statuscode
            ], $statuscode);
        } catch (\Exception $e) {
            return response()->json([
                "msg" => $e->getMessage() . ' at line ' . $e->getLine(),
                "statuscode" => 500
            ], 500);
        }
    }
}
