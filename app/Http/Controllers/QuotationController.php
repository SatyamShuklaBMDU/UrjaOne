<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Quotations;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index()
    {
        $enquiries = Enquiry::where('status', 'submit')->latest()->get();
        return view('dashboard.Quotations.quotation', compact('enquiries'));
    }

    public function getQuotations($leadid)
    {
        $Did = decrypt($leadid);
        $quoatations = Quotations::where('lead_no', $Did)->latest()->get();
        return view('dashboard.Quotations.all_quotations', compact('quoatations'));
    }

    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $enquiries = Enquiry::where('status', 'submit')->whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Quotations.quotation', ['enquiries' => $enquiries, 'start' => $startDate, 'end' => $endDate]);
    }
}
