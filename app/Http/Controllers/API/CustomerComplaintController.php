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
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, $validator->errors()]);
            }
            $data = UserComplaint::create([
                'message' => $request->message,
                'customer_id' => Auth::id(),
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
}
