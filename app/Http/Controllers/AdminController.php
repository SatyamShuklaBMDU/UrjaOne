<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard.Admin.all_admin',compact('users'));
    }

    public function Addindex()
    {
        $roles = Role::all();
        return view('dashboard.Admin.add_admin', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20',
            'role' => 'required|integer',
            'password' => 'required|string|min:8',
        ]);
        $admin = new User();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->phone_number = $request->input('phone_number');
        $admin->role_id = $request->input('role');
        $admin->password = Hash::make($request->input('password'));
        $admin->save();
        return back()->with('success', 'User Created Sucessfully.');
    }
    public function edit($id)
    {
        $admin = User::find($id);
        return response()->json($admin);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $id,
            'phone_number' => 'required|string|max:20',
            'role' => 'required|integer',
            'password' => 'nullable|string|min:8',
        ]);
        $admin = User::find($id);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->phone_number = $request->input('phone_number');
        $admin->role_id = $request->input('role');
        if ($request->has('password')) {
            $admin->password = Hash::make($request->input('password'));
        }
        $admin->save();
        return back()->with('success', 'User Updated Sucessfully.');
    }
}
