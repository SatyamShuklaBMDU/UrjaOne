<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\SubscriptionPlans;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'plan_name' => 'required|string',
            'plan_type' => 'required|string',
            'plan_category' => 'required|string',
            'plan_amount' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()], 400);
        }
        $vendor_id = Auth::id();
        $plan_id = $request->input('plan_id');
        $plan = Plans::find($plan_id);
        $plan_name = $request->input('plan_name');
        $plan_type = $request->input('plan_type');
        $plan_category = $request->input('plan_category');
        $plan_details = $plan->description;
        $plan_amount = $request->input('plan_amount');
        $plan_duration = $plan->duration;
        preg_match('/(\d+)\s*(\w+)/', $plan_duration, $matches);
        $duration_number = (int) $matches[1];
        $duration_unit = Str::lower($matches[2]);
        switch ($duration_unit) {
            case 'month':
            case 'months':
                $duration_months = $duration_number;
                break;
            case 'year':
            case 'years':
                $duration_months = $duration_number * 12;
                break;
            default:
                $duration_months = 1;
        }
        $expiration_date = Carbon::now()->addMonths($duration_months);
        $subscription = new SubscriptionPlans();
        $subscription->vendor_id = $vendor_id;
        $subscription->plan_id = $plan_id;
        $subscription->plan_name = $plan_name;
        $subscription->plan_type = $plan_type;
        $subscription->plan_category = $plan_category;
        $subscription->plan_details = $plan_details;
        $subscription->plan_amount = $plan_amount;
        $subscription->expiration_date = $expiration_date;
        $subscription->status = true;
        $subscription->save();
        return response()->json(['message' => 'Subscription plan registered successfully']);
    }
}
