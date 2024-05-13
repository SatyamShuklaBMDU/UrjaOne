<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::where('for', 'Home')->get();
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
        $banner = Banner::where('for', 'About')->get();
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
