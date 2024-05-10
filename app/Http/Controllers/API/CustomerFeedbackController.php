<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CustomerFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerFeedbackController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'message' => 'required|string',
                'image' => 'nullable|mimes:jpg,jpeg,png',
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'errors' => $validate->messages(),
                ]);
            }
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $photoFileName = uniqid() . '.' . $request->image->extension();
                $photoPath = $request->file('image')->move(public_path('Feedback/Customer/'), $photoFileName);
                $photoRelativePath = 'Feedback/Customer/' . $photoFileName;
            }
            $data = CustomerFeedback::create([
                'message' => $request->message,
                'customer_id' => Auth::id(),
                'image' => $photoRelativePath??'',
            ]);
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Feedback Sent Successfully',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => true,
                'code' => 500,
                'error' => 'Internal Server Error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function fetch(Request $request)
    {
        try {
            $data = CustomerFeedback::where('customer_id', Auth::id())->get();
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
