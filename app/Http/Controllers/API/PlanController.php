<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plans;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plans::all();
        foreach ($plans as $plan) {
            $discountPercentage = $plan->discount;
            $discountedPrice = $plan->price * (1 - $discountPercentage / 100);
            $plan->price = $discountedPrice;
        }
        return response()->json(['status' => true, 'message' => 'fetch Succesfully', 'plans' => $plans]);
    }
}
