<?php

namespace App\Http\Controllers;

use App\Models\UserComplaint;
use Illuminate\Http\Request;

class CustomerComplaintController extends Controller
{
    public function index()
    {
        $customerComplaint = UserComplaint::latest()->get();
        return view('dashboard.Complaints.UserComplaint', compact('customerComplaint'));
    }

    public function replyToComplaint(Request $request)
    {
        $request->validate([
            'complaintId' => 'required|exists:user_complaints,id',
            'replyMessage' => 'required|string',
        ]);
        $complaint = UserComplaint::findOrFail($request->complaintId);
        $complaint->reply = $request->replyMessage;
        $complaint->reply_person_id = auth()->user()->id;
        $complaint->reply_datetime = now();
        $complaint->save();
        return response()->json(['message' => 'Reply sent successfully'], 200);
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'complaintId' => 'required|exists:user_complaints,id',
            'status' => 'required|in:confirm,follow',
        ]);
        $complaint = UserComplaint::findOrFail($request->complaintId);
        $complaint->status = $request->status;
        $complaint->save();
        return response()->json(['message' => 'Status updated successfully'], 200);
    }
    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $customerComplaint = UserComplaint::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Complaints.UserComplaint', ['customerComplaint' => $customerComplaint, 'start' => $startDate, 'end' => $endDate]);
    }
    public function updateReply(Request $request)
    {
        $request->validate([
            'complaintId' => 'required|exists:user_complaints,id',
            'editedReplyMessage' => 'required|string',
        ]);
        $complaint = UserComplaint::findOrFail($request->complaintId);
        $complaint->reply = $request->editedReplyMessage;
        $complaint->reply_person_id = auth()->user()->id;
        $complaint->reply_datetime = now();
        $complaint->save();
        return response()->json(['message' => 'Reply updated successfully'], 200);
    }
}
