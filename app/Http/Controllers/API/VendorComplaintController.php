<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\VendorComplaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VendorComplaintController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'message' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, $validator->errors()]);
            }
            $data = VendorComplaint::create([
                'message' => $request->message,
                'vendor_id' => Auth::id(),
            ]);
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Complaint Sent Successfully',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'error' => 'Internal Server Error',
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function fetch(Request $request)
    {
        try {
            $data = VendorComplaint::where('vendor_id', Auth::id())->get();
            if ($data->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No data found',
                ]);
            }
            $baseUrl = 'https://bmdublog.com/UrjaOne/public/';
            $data->each(function ($item) use ($baseUrl) {
                $item->image = $baseUrl . $item->image;
            });
            return response()->json([
                'status' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
