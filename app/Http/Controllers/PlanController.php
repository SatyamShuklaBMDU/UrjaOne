<?php

namespace App\Http\Controllers;

use App\Models\Plans;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plans::all();
        return view('dashboard.plans.all_plans', compact('plans'));
    }

    public function addplans()
    {
        return view('dashboard.plans.add_plans');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image',
            'price' => 'required|string',
            'load' => 'required|integer',
            'area' => 'required|string',
            'category' => 'required',
            'status' => 'nullable|boolean',
            'description' => 'required',
        ]);
        // dd($request->all());
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFileName = uniqid() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->move(public_path('PlanImage/'), $imageFileName);
            $imageRelativePath = 'PlanImage/' . $imageFileName;
        }
        $plan = Plans::create([
            'name' => $request->name,
            'image' => $imageRelativePath,
            'price' => $request->price,
            'status' => $request->status??true,
            'description' => $request->description,
            'load' => $request->load,
            'category' => json_encode($request->category),
            'area' => $request->area,
        ]);
        return redirect()->route('plans-page')->with('success', 'Plan created successfully!');
    }
    public function statuschange(Request $request)
    {
        $status = $request->input('status');
        try {
            $customer = Plans::findOrFail($request->plan);
            $customer->status = $status;
            $customer->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
            'price' => 'required|string',
            'description' => 'required',
        ]);
        $plans = Plans::find($request->planId);
        $plans->name = $request->name;
        $plans->price = $request->price;
        $plans->description = $request->description;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFileName = uniqid() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->move(public_path('PlanImage/'), $imageFileName);
            $imageRelativePath = 'PlanImage/' . $imageFileName;
            $plans->image = $imageRelativePath;
        }
        $plans->save();
        return redirect()->route('plans-page')->with('success', 'Plan updated successfully!');
    }

    public function delete($id)
    {
        $role = Plans::findOrFail($id);
        $role->delete();
        return response()->json(['success' => true]);
    }

}
