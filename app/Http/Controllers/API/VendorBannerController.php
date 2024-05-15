<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\VendorBanner;
use Illuminate\Http\Request;

class VendorBannerController extends Controller
{
    public function index()
    {
        $banner = VendorBanner::where('for', 'Home')->get();
        $baseUrl = 'https://bmdublog.com/UrjaOne/public/';
            $banner->each(function ($item) use ($baseUrl) {
                $item->banner = $baseUrl . $item->banner;
            });
        if ($banner->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No data found',
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $banner,
        ]);
    }
    public function Aboutindex()
    {
        $banner = VendorBanner::where('for', 'About')->get();
        $baseUrl = 'https://bmdublog.com/UrjaOne/public/';
            $banner->each(function ($item) use ($baseUrl) {
                $item->banner = $baseUrl . $item->banner;
            });
        if ($banner->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No data found',
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $banner,
        ]);
    }

}
