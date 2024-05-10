<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserComplaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class CustomerComplaintController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = FacadesValidator::make($request->all(), [
                'message' => 'required|string',
                'image' => 'nullable|mimes:jpg,jpeg,png',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, $validator->errors()]);
            }
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $photoFileName = uniqid() . '.' . $request->image->extension();
                $photoPath = $request->file('image')->move(public_path('Complaint/customer/'), $photoFileName);
                $photoRelativePath = 'Complaint/customer/' . $photoFileName;
            }
            $data = UserComplaint::create([
                'message' => $request->message,
                'customer_id' => Auth::id(),
                'image' => $photoRelativePath??'',
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
            $data = UserComplaint::where('customer_id', Auth::id())->get();
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
