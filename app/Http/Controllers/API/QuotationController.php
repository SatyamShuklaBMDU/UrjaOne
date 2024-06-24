<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Quotations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class QuotationController extends Controller
{
    public function store(Request $request)
    {
        $login = Auth::id();
        $validator = Validator::make($request->all(), [
            'lead_no' => 'required|string|max:255',
            'price_per_kw' => 'required|string|max:255',
            'panel_warranty' => 'required|string|max:255',
            'inverter_warranty' => 'required|string|max:255',
            'technical_support' => 'required|string|max:255',
            'ac_cable_brand' => 'nullable|string|max:255',
            'dc_cable_brand' => 'nullable|string|max:255',
            'mms_structure' => 'nullable|string|max:255',
            'earthing' => 'nullable|string|max:255',
            'subsidy_support' => 'nullable|boolean',
            'metering_support' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            $response = ['status' => false];
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $response[$field] = $messages[0];
            }
            return response()->json($response);
        }
        DB::beginTransaction();
        try {
            $enquiry_id = Enquiry::where('lead_no', $request->lead_no)->first();
            // dd($enquiry_id);
            $quotation_no = $this->generateUniqueQuotationNo();
            $quotation = new Quotations([
                'vendor_id' => $login,
                'enquiry_id' => $enquiry_id->id,
                'quotation_no' => $quotation_no,
                'lead_no' => $request->lead_no,
                'price_per_kw' => $request->price_per_kw,
                'panel_warranty' => $request->panel_warranty,
                'inverter_warranty' => $request->inverter_warranty,
                'technical_support' => $request->technical_support,
                'ac_cable_brand' => $request->ac_cable_brand,
                'dc_cable_brand' => $request->dc_cable_brand,
                'mms_structure' => $request->mms_structure,
                'earthing' => $request->earthing,
                'subsidy_support' => $request->subsidy_support,
                'metering_support' => $request->metering_support,
            ]);
            $totalQuotations = (int) $enquiry_id->total_quotation + 1; // Convert to int and increment
            $enquiry_id->total_quotation = (string) $totalQuotations; // Convert back to string
            $enquiry_id->save();
            $quotation->save();
            DB::commit();
            return response()->json(['message' => 'Quotation created successfully', 'quotation' => $quotation], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
            // return response()->json(['error' => 'Failed to create quotation due to an error.'], 500);
        }
    }

    private function generateUniqueQuotationNo()
    {
        do {
            $number = 'QUOTE' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (Quotations::where('quotation_no', $number)->exists());

        return $number;
    }
    public function getData(Request $request)
    {
        $loginid = Auth::id();
        $quotations = Quotations::where('vendor_id', $loginid)->latest()->get();
        if ($quotations->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No data found',
            ]);
        }
        return response()->json(['data' => $quotations], Response::HTTP_OK);
    }
}
