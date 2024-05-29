<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plans;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plans::where('status',true)->get();
        $baseUrl = 'https://bmdublog.com/UrjaOne/public/';
        $plans->each(function ($item) use ($baseUrl) {
            $item->description = strip_tags($item->description);
            $item->image = $baseUrl . $item->image;
        });
        return response()->json(['status' => true, 'message' => 'fetch Succesfully', 'plans' => $plans]);
    }
}
