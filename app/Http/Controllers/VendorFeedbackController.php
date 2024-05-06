<?php

namespace App\Http\Controllers;

use App\Models\VendorFeedback;
use Illuminate\Http\Request;

class VendorFeedbackController extends Controller
{
    public function index()
    {
        $vendorFeedback = VendorFeedback::all();
        return view('dashboard.Feedbacks.VendorFeedback', compact('vendorFeedback'));
    }
    public function replyTofeedback(Request $request)
    {
        $request->validate([
            'feedbackId' => 'required|exists:vendor_feedback,id',
            'replyMessage' => 'required|string',
        ]);
        $feedback = VendorFeedback::findOrFail($request->feedbackId);
        $feedback->reply = $request->replyMessage;
        $feedback->reply_person_id = auth()->user()->id;
        $feedback->reply_datetime = now();
        $feedback->save();
        return response()->json(['message' => 'Reply sent successfully'], 200);
    }
    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $vendorFeedback = VendorFeedback::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Feedbacks.VendorFeedback', ['vendorFeedback' => $vendorFeedback, 'start' => $startDate, 'end' => $endDate]);
    }
    public function updateReply(Request $request)
    {
        $request->validate([
            'feedbackId' => 'required|exists:vendor_feedback,id',
            'editedReplyMessage' => 'required|string',
        ]);
        $feedback = VendorFeedback::findOrFail($request->feedbackId);
        $feedback->reply = $request->editedReplyMessage;
        $feedback->reply_person_id = auth()->user()->id;
        $feedback->reply_datetime = now();
        $feedback->save();
        return response()->json(['message' => 'Reply updated successfully'], 200);
    }
}
