<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'required|string|max:255|unique:customers,phone_number',
            'whatsapp_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'pincode' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        // dd($request->all());
        $photoRelativePath = null;
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photoFileName = uniqid() . '.' . $request->photo->extension();
            $photoPath = $request->file('photo')->move(public_path('images'), $photoFileName);
            $photoRelativePath = 'images/' . $photoFileName;
        }
        $cin_no = 'CIN' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $user = Customer::create([
            'cin_no' => $cin_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'whatsapp_number' => $request->whatsapp_number ?? null,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'state' => $request->state,
            'password' => Hash::make('123456'),
            'photo' => $photoRelativePath,
            'status' => 'active',
        ]);
        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
    public function update(Request $request)
    {
        $loginid = Auth::id();
        $customer = Customer::findOrFail($loginid);
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'email|unique:customers,email,' . $customer->id,
            'phone_number' => 'string|max:255|unique:customers,phone_number,' . $customer->id,
            'whatsapp_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'pincode' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'password' => 'string|min:8',
            'coordinates' => 'nullable|numeric|between:-9999999.9999999,9999999.9999999',
            'category' => 'nullable|in:residential,commercial,industrial,agricultural',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        // Update customer fields
        $customer->fill($request->except(['password', 'photo']));
        // Update password if provided
        if ($request->has('password')) {
            $customer->password = Hash::make($request->password);
        }
        // Update photo if provided
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photoFileName = uniqid() . '.' . $request->photo->extension();
            $photoPath = $request->file('photo')->move(public_path('images'), $photoFileName);
            $photoRelativePath = 'images/' . $photoFileName;
            $customer->photo = $photoRelativePath;
        }
        $customer->save();
        return response()->json(['message' => 'User details updated successfully', 'user' => $customer], 200);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_mobile' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $credentials = $request->only('password');
        $user = Customer::where('email', $request->email_or_mobile)
            ->orWhere('phone_number', $request->email_or_mobile)
            ->first();
        if ($user->status !== 'active') {
            return response()->json(['message' => 'Account is not active'], 403);
        }
        if ($user && Auth::guard('customers')->attempt(['email' => $user->email, 'password' => $credentials['password']])) {
            $token = $user->createToken('app-token')->plainTextToken;
            return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token], 200);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
