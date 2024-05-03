<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorRelatedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone_number' => 'required|string|unique:vendors,phone_number',
            'email' => 'required|email|unique:vendors,email',
            'company_name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $cin_no = 'CIN' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $vendor = Vendor::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'password' => Hash::make('123456'),
            'cin_no' => $cin_no,
        ]);
        return response()->json(['message' => 'Vendor registered successfully', 'vendor' => $vendor], 201);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $credentials = $request->only('phone_number', 'password');

        if (Auth::guard('vendor')->attempt($credentials)) {
            $user = Auth::guard('vendor')->user();
            // Generate API token
            $token = $user->createToken('AuthToken')->plainTextToken;
            return response()->json(['Message' => 'Login Successfull', 'token' => $token], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
    public function update(Request $request)
    {
        $loginid = Auth::id();
        $customer = Vendor::findOrFail($loginid);
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'email|unique:vendors,email,' . $customer->id,
            'phone_number' => 'string|max:255|unique:vendors,phone_number,' . $customer->id,
            'whatsapp_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'pincode' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'company_name' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'coordinates' => 'nullable|numeric|between:-9999999.9999999,9999999.9999999',
            'category' => 'nullable|in:residential,commercial,industrial,agricultural',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $customer->fill($request->except(['password', 'photo']));
        if ($request->has('password')) {
            $customer->password = Hash::make($request->password);
        }
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photoFileName = uniqid() . '.' . $request->photo->extension();
            $photoPath = $request->file('photo')->move(public_path('vendor/profile_images'), $photoFileName);
            $photoRelativePath = 'vendor/profile_images/' . $photoFileName;
            $customer->photo = $photoRelativePath;
        }
        $customer->save();
        return response()->json(['message' => 'Vendor details updated successfully', 'user' => $customer], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
    public function uploadImages(Request $request)
    {
        $user = Auth::id();
        $validator = Validator::make($request->all(), [
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'titles.*' => 'required|string',
            'numbers.*' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $images = $request->file('images');
        $titles = $request->titles;
        $numbers = $request->numbers;
        foreach ($images as $index => $image) {
            $title = $titles[$index];
            $number = $numbers[$index];
            $photoFileName = uniqid() . '.' . $image->extension();
            $photoPath = $image->move(public_path('vendor/kyc_images'), $photoFileName);
            $photoRelativePath = 'vendor/kyc_images/' . $photoFileName;
            VendorRelatedImage::create([
                'vendor_id' => $user,
                'title' => $title,
                'image' => $photoRelativePath,
                'number' => $number,
            ]);
        }
        return response()->json(['message' => 'Images uploaded successfully'], 200);
    }
}
