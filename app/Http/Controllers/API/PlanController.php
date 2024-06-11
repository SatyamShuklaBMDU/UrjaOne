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
        foreach($normalplans as $plan){
            $plan['image'] = $baseUrl.$plan['image'];
            $plan['description'] = strip_tags($plan['description']);
        }
        dd($normalplans);
        $walletplans = WalletPlan::all()->toArray();
        $plans = array_merge($normalplans,$walletplans);
        $plans->each(function ($item) use ($baseUrl) {
            $item->description = strip_tags($item->description);
            $item->image = $baseUrl . $item->image;
        });
        dd($plans);
        return response()->json(['status' => true, 'message' => 'fetch Succesfully', 'plans' => $plans]);
    }
}
