<?php

namespace App\Http\Controllers;

use App\Models\VendorComplaint;
use Illuminate\Http\Request;

class VendorComplaintController extends Controller
{
    public function index()
    {
        $vendorComplaints = VendorComplaint::all();
        return view('dashboard.Complaints.VendorComplaint', compact('vendorComplaints'));
    }
    public function replyToComplaint(Request $request)
    {
        $request->validate([
            'complaintId' => 'required|exists:vendor_complaints,id',
            'replyMessage' => 'required|string',
        ]);
        $complaint = VendorComplaint::findOrFail($request->complaintId);
        $complaint->reply = $request->replyMessage;
        $complaint->reply_person_id = auth()->user()->id;
        $complaint->reply_datetime = now();
        $complaint->save();
        return response()->json(['message' => 'Reply sent successfully'], 200);
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'complaintId' => 'required|exists:vendor_complaints,id',
            'status' => 'required|in:confirm,follow',
        ]);
        $complaint = VendorComplaint::findOrFail($request->complaintId);
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
        $vendorComplaints = VendorComplaint::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Complaints.VendorComplaint', ['vendorComplaints' => $vendorComplaints, 'start' => $startDate, 'end' => $endDate]);
    }
    public function updateReply(Request $request)
    {
        $request->validate([
            'complaintId' => 'required|exists:vendor_complaints,id',
            'editedReplyMessage' => 'required|string',
        ]);
        $complaint = VendorComplaint::findOrFail($request->complaintId);
        $complaint->reply = $request->editedReplyMessage;
        $complaint->reply_person_id = auth()->user()->id;
        $complaint->reply_datetime = now();
        $complaint->save();
        return response()->json(['message' => 'Reply updated successfully'], 200);
    }
}
