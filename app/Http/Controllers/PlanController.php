<?php

namespace App\Http\Controllers;

use App\Models\Plans;
use App\Models\WalletPlan;
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

    public function addWalletPlans()
    {
        return view('dashboard.plans.add_wallet_plans');
    }

    public function allWalletPlans()
    {
        $plans = WalletPlan::all();
        return view('dashboard.plans.all_wallet_plans',compact('plans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image',
            'price' => 'required|string',
            'load' => 'required|integer',
            'area' => 'required|array',
            'category' => 'required|array',
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
            'area' => json_encode($request->area),
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
            'load' => 'required',
            'area' => 'required',
            'category' => 'required',
        ]);
        // dd($request->all());
        $plans = Plans::find($request->planId);
        $plans->name = $request->name;
        $plans->price = $request->price;
        $plans->description = $request->description;
        $plans->load = $request->load;
        $plans->area = json_encode($request->area);
        $plans->category = json_encode($request->category);
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

    public function Walletdelete($id)
    {
        $role = WalletPlan::findOrFail($id);
        $role->delete();
        return response()->json(['success' => true]);
    }
    
    public function StoreWalletPlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'load' => 'required|array',
            'amount' => 'required|array',
            'description' => 'required|string',
            'image' => 'nullable|image',
        ]);
        $walletPlan = new WalletPlan();
        $walletPlan->name = $request->name;
        $walletPlan->load = json_encode($request->load);
        $walletPlan->amount = json_encode($request->amount);
        $walletPlan->description = $request->description;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFileName = uniqid() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->move(public_path('PlanImage/'), $imageFileName);
            $imageRelativePath = 'PlanImage/' . $imageFileName;
            $walletPlan->plan_image = $imageRelativePath;
        }
        $walletPlan->save();
        return redirect()->route('wallet-plans')->with('success', 'Plan added successfully!');
    }
    public function UpdateWalletPlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'load' => 'required|array',
            'amount' => 'required|array',
            'description' => 'required|string',
            'image' => 'nullable|image',
        ]);
        $walletPlan = WalletPlan::find($request->planId);
        $walletPlan->name = $request->name;
        $walletPlan->load = json_encode($request->load);
        $walletPlan->amount = json_encode($request->amount);
        $walletPlan->description = $request->description;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFileName = uniqid() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->move(public_path('PlanImage/'), $imageFileName);
            $imageRelativePath = 'PlanImage/' . $imageFileName;
            $walletPlan->plan_image = $imageRelativePath;
        }
        $walletPlan->save();
        return back()->with('success', 'Plan updated successfully!');
    }

    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $plans = Plans::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.plans.all_plans', ['plans' => $plans, 'start' => $startDate, 'end' => $endDate]);
    }

    public function filterwalletdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $plans = WalletPlan::whereBetween('created_at', [$startDate, $endDate])->get();
        // dd($plans);
        return view('dashboard.plans.all_wallet_plans', ['plans' => $plans, 'start' => $startDate, 'end' => $endDate]);
    }

}   
