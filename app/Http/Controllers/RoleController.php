<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('dashboard.Role.all_role', compact('roles'));
    }

    public function addRole()
    {
        return view('dashboard.Role.add_role');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);
        // dd($request->all());
        $role = new Role();
        $role->role = $request->input('role');
        $permissions = $request->input('permissions');
        $role->permission = json_encode($permissions);
        $role->save();
        return back()->with('success', 'Role Created Successfully');
    }
    public function update(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);
        $role = Role::find($request->role_id);
        $role->role = $request->input('role');
        $permissions = $request->input('permissions');
        $role->permission = json_encode($permissions);
        $role->save();
        return back()->with('success', 'Role Updated Successfully');
    }
    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $role = Role::findOrFail($id);
            return response()->json($role);
        }
    }

}
