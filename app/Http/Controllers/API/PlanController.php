<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\WalletPlan;

class PlanController extends Controller
{
    public function index()
    {
        $baseUrl = 'https://bmdublog.com/UrjaOne/public/';
        $normalplans = Plans::where('status',true)->get()->toArray();
        $normalplans = array_map(function($plan) use($baseUrl){
            $plan['image'] = $baseUrl.$plan['image'];
            return $plan;
        },$normalplans);
        $walletplans = WalletPlan::all()->toArray();
        $walletplans = array_map(function($plan) use($baseUrl){
            $plan['plan_image'] = $baseUrl.$plan['plan_image'];
            $plan['load'] = implode(',',json_decode($plan['load']));
            $plan['amount'] = implode(',',json_decode($plan['amount']));
            return $plan;
        },$walletplans);
        $plans = array_merge($normalplans,$walletplans);
        return response()->json(['status' => true, 'message' => 'fetch Succesfully', 'plans' => $plans]);
    }
}
