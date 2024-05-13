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
            'type' => 'required|string|max:255',
            'category' => 'required|in:residential,commercial,industrial,agricultural',
            'price' => 'required|string',
            'duration' => 'required|string',
            'status' => 'nullable|boolean',
            'description' => 'required',
            'discount' => 'nullable|integer|min:0|max:100',
        ]);

        $plan = Plans::create($validatedData);
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
        $plans = Plans::find($request->planId);
        $plans->name = $request->name;
        $plans->type = $request->type;
        $plans->category = $request->category;
        $plans->price = $request->price;
        $plans->duration = $request->duration;
        $plans->description = $request->description;
        $plans->discount = $request->discount;
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
