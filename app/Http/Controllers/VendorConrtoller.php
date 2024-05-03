<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorRelatedImage;
use Illuminate\Http\Request;

class VendorConrtoller extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('Vendor.vendor_profile',compact('vendors'));
    }
    public function alldata($id){
        $vendor = Vendor::find($id);
        return response()->json($vendor);
    }
    public function statuschange(Request $request)
    {
        $status = $request->input('status');
        try {
            $vendor = Vendor::findOrFail($request->vendor);
            $vendor->status = $status;
            $vendor->save();
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
        $filteredCustomers = Vendor::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('Vendor.vendor_profile', ['vendors' => $filteredCustomers, 'start'=>$startDate, 'end'=>$endDate]);
    }
    public function imageVerification($id){
        $Did = decrypt($id);
        $vendors = VendorRelatedImage::where('vendor_id',$Did)->get();
        return view('Vendor.image_verification',compact('vendors'));
    }
}
