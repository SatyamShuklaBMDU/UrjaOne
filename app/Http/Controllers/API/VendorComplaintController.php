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
                'image' => 'nullable|mimes:jpg,jpeg,png',
            ]);
            if ($validator->fails()) {
                $response = ['status' => false];
                foreach ($validator->errors()->toArray() as $field => $messages) {
                    $response[$field] = $messages[0];
                }
                return response()->json($response);
            }
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $photoFileName = uniqid() . '.' . $request->image->extension();
                $photoPath = $request->file('image')->move(public_path('Complaint/vendor/'), $photoFileName);
                $photoRelativePath = 'Complaint/vendor/' . $photoFileName;
            }
            $data = VendorComplaint::create([
                'message' => $request->message,
                'vendor_id' => Auth::id(),
                'image' => $photoRelativePath ?? '',
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
