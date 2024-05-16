<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = Enquiry::where('status', 'submit')->latest()->get();
        return view('dashboard.Enquiry.enquiry', compact('enquiries'));
    }

    public function totalhistory()
    {
        $uniqueCustomerIds = Enquiry::select('customer_id')->distinct()->pluck('customer_id');
        $enquiries = [];
        foreach ($uniqueCustomerIds as $customerId) {
            $finalEnquiriesCount = Enquiry::where('customer_id', $customerId)
                ->where('status', 'submit')
                ->count();
            $draftEnquiriesCount = Enquiry::where('customer_id', $customerId)
                ->where('status', 'draft')
                ->count();
            $totalQuotationSum = Enquiry::where('customer_id', $customerId)
                ->sum('total_quotation');
            $customerData = Enquiry::where('customer_id', $customerId)->first(); // Assuming you want to retrieve other user data as well
            $customerData->final_enquiries_count = $finalEnquiriesCount;
            $customerData->draft_enquiries_count = $draftEnquiriesCount;
            $customerData->total_quotation_sum = $totalQuotationSum;
            $enquiries[] = $customerData;
        }
        return view('dashboard.History.main_enquiry', compact('enquiries'));
    }

    public function detailHistory($id)
    {
        $Did = decrypt($id);
        $enquiries = Enquiry::where('customer_id', $Did)->latest()->get();
        return view('dashboard.History.enquiry_history', compact('enquiries'));
    }

    public function totalhistoryfilter(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $uniqueCustomerIds = Enquiry::select('customer_id')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->distinct()
            ->pluck('customer_id');

        $enquiries = [];
        foreach ($uniqueCustomerIds as $customerId) {
            $finalEnquiriesCount = Enquiry::where('customer_id', $customerId)
                ->where('status', 'submit')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $draftEnquiriesCount = Enquiry::where('customer_id', $customerId)
                ->where('status', 'draft')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $totalQuotationSum = Enquiry::where('customer_id', $customerId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_quotation');

            $customerData = Enquiry::where('customer_id', $customerId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->first(); // Assuming you want to retrieve other user data as well

            if ($customerData) {
                $customerData->final_enquiries_count = $finalEnquiriesCount;
                $customerData->draft_enquiries_count = $draftEnquiriesCount;
                $customerData->total_quotation_sum = $totalQuotationSum;

                $enquiries[] = $customerData;
            }
        }
        return view('dashboard.History.main_enquiry', compact('enquiries', 'startDate', 'endDate'));

    }
    public function getEnquiryDetails($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $structureType = json_decode($enquiry->structure_type);
        $solarPanel = json_decode($enquiry->solar_panel_type);
        $panelBrands = json_decode($enquiry->panel_brands);
        $brands = json_decode($enquiry->inverter_brands);
        $time = json_decode($enquiry->book_plant_time);
        $data = [
            'subsidy' => $enquiry->subsidy,
            'finance' => $enquiry->finance,
            'structure_type' => $structureType,
            'solar_panel' => $solarPanel,
            'panel_brands' => $panelBrands,
            'brands' => $brands,
            'time' => $time,
        ];

        return Response::json($data);
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
        return view('dashboard.Enquiry.enquiry', ['enquiries' => $enquiries, 'start' => $startDate, 'end' => $endDate]);
    }
    public function filterenquiryHistory(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $enquiries = Enquiry::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.History.enquiry_history', ['enquiries' => $enquiries, 'start' => $startDate, 'end' => $endDate]);
    }
}
