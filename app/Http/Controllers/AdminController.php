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
        $role = Role::where('role','Super admin')->first();
        $users = User::where('role_id','!=',$role->id)->get();
        $roles = Role::all();
        return view('dashboard.Admin.all_admin', compact('users', 'roles'));
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

    public function update(Request $request)
    {
        $id = $request->input('id');
        $admin = User::find($id);
        // dd($admin);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'number' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
        ]);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->phone_number = $request->input('number');
        if ($request->has('password')) {
            $admin->password = Hash::make($request->input('password'));
        }
        $admin->save();
        return back()->with('success', 'User Updated Sucessfully.');
    }
    public function updateUserRole(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->role_id = $request->role_id;
            $user->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true]);
    }
    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $role = Role::where('role','Super admin')->first();
        $roles = Role::all();
        $users = User::where('role_id','!=',$role->id)->whereBetween('created_at', [$startDate, $endDate])->get();
        // dd($users);
        return view('dashboard.Admin.all_admin', ['users' => $users, 'start' => $startDate, 'end' => $endDate, 'roles'=>$roles]);
    }

}
