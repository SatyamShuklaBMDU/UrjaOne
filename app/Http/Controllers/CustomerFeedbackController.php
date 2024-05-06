<?php

namespace App\Http\Controllers;

use App\Models\CustomerFeedback;
use Illuminate\Http\Request;

class CustomerFeedbackController extends Controller
{
    public function index(){
        $userFeedback = CustomerFeedback::all();
        return view('dashboard.Feedbacks.UserFeedback',compact('userFeedback'));
    }
    public function replyTofeedback(Request $request)
    {
        $request->validate([
            'feedbackId' => 'required|exists:customer_feedback,id',
            'replyMessage' => 'required|string',
        ]);
        $feedback = CustomerFeedback::findOrFail($request->feedbackId);
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
        $userFeedback = CustomerFeedback::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Feedbacks.UserFeedback', ['userFeedback' => $userFeedback, 'start' => $startDate, 'end' => $endDate]);
    }
    public function updateReply(Request $request)
    {
        $request->validate([
            'feedbackId' => 'required|exists:vendor_feedback,id',
            'editedReplyMessage' => 'required|string',
        ]);
        $feedback = CustomerFeedback::findOrFail($request->feedbackId);
        $feedback->reply = $request->editedReplyMessage;
        $feedback->reply_person_id = auth()->user()->id;
        $feedback->reply_datetime = now();
        $feedback->save();
        return response()->json(['message' => 'Reply updated successfully'], 200);
    }
}
