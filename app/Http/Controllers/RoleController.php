<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('role','!=','Super admin')->get();
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);
        $role = Role::find($id);
        $role->role = $request->input('role');
        $permissions = $request->input('permissions');
        $role->permission = json_encode($permissions);
        $role->save();
        return back()->with('success', 'Role Updated Successfully');
    }
    public function edit(Request $request, $id)
    {
        $Did = decrypt($id);
        $role = Role::findOrFail($Did);
        $permissionsArray = json_decode($role->permission, true);
        return view('dashboard.Role.add_role', [
            'role' => $role,
            'permissionsArray' => $permissionsArray,
            'edit' => true,
        ]);
    }
    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
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
        $roles = Role::where('role','!=','Super admin')->whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Role.all_role', ['roles' => $roles, 'start' => $startDate, 'end' => $endDate]);
    }
}
