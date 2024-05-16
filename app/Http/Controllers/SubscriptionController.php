<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlans;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $paymentHistory = SubscriptionPlans::all();
        return view('dashboard.subscription.payment_history', compact('paymentHistory'));
    }

    public function statuschange(Request $request)
    {
        $status = $request->input('status');
        try {
            $customer = SubscriptionPlans::findOrFail($request->paymentID);
            $customer->status = $status;
            $customer->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $paymentHistory = SubscriptionPlans::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.subscription.payment_history', ['paymentHistory' => $paymentHistory, 'start' => $startDate, 'end' => $endDate]);
    }
}
