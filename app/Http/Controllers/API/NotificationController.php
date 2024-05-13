<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function userfetch()
    {
        $notifications = Notification::where('for', 'user')->orWhere('for', 'both')->get();
        $baseUrl = 'https://bmdublog.com/UrjaOne/public/';
        $notifications->each(function ($item) use ($baseUrl) {
            $item->image = $baseUrl . $item->image;
        });
        if ($notifications->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No Notification found.'], 404);
        }
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Notification Fetch Successfully.',
            'notifications' => $notifications,
        ]);
    }

    public function vendorfetch()
    {
        $notifications = Notification::where('for', 'vendor')->orWhere('for', 'both')->get();
        $baseUrl = 'https://bmdublog.com/UrjaOne/public/';
        $notifications->each(function ($item) use ($baseUrl) {
            $item->image = $baseUrl . $item->image;
        });
        if ($notifications->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No Notification found.'], 404);
        }
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Notification Fetch Successfully.',
            'notifications' => $notifications,
        ]);
    }

}
