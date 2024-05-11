<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function userfetch()
    {
        $notifications = Notification::where('for','user')->orWhere('for','both')->get();
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
        $notifications = Notification::where('for','vendor')->orWhere('for','both')->get();
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
