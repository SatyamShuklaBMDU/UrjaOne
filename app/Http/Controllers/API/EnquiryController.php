<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function store()
    {
        $request = request();
        $loginid = Auth::id();
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:residential,commercial,industrial,agricultural',
            'plant_load' => 'required|integer',
            'subsidy' => 'nullable|string|in:true,false',
            'finance' => 'nullable|string|in:true,false',
            'structure_type' => 'nullable|string',
            'panel_type' => 'nullable|string',
            'panel_brand' => 'nullable|string',
            'inverter_brand' => 'nullable|string',
            'book_plant_time' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $response = ['Status' => false];
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $response[$field] = $messages[0];
            }
            return response()->json($response);
        }
        $structureTypeArray = explode(',', $request->structure_type);
        $solarPanelArray = explode(',', $request->panel_type);
        $panelbrandArray = explode(',', $request->panel_brand);
        $inverterbrandArray = explode(',', $request->inverter_brand);
        $bookplanttimeArray = explode(',', $request->book_plant_time);
        $uniqueLeadNo = $this->generateUniqueLeadNo($request->category);
        $enquiry = new Enquiry();
        $enquiry->customer_id = $loginid;
        $enquiry->lead_no = $uniqueLeadNo;
        $enquiry->category = $request->category;
        $enquiry->plant_load = $request->plant_load;
        $enquiry->subsidy = $request->subsidy === "true" ? true : false;
        $enquiry->finance = $request->finance === "true" ? true :  false;
        $enquiry->structure_type = json_encode($structureTypeArray);
        $enquiry->solar_panel_type = json_encode($solarPanelArray);
        $enquiry->panel_brands = json_encode($panelbrandArray);
        $enquiry->inverter_brands = json_encode($inverterbrandArray);
        $enquiry->book_plant_time = json_encode($bookplanttimeArray);
        $enquiry->status = 'submit';
        $enquiry->save();
        return response()->json([
            'status' => true,
            'message' => 'Enquiry created successfully',
            'data' => $enquiry,
        ]);
    }

    public function storeDraft()
    {
        $request = request();
        $loginid = Auth::id();
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:residential,commercial,industrial,agricultural',
            'plant_load' => 'required|integer',
            'subsidy' => 'nullable|string|in:true,false',
            'finance' => 'nullable|string|in:true,false',
            'structure_type' => 'nullable|string',
            'panel_type' => 'nullable|string',
            'panel_brand' => 'nullable|string',
            'inverter_brand' => 'nullable|string',
            'book_plant_time' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $response = ['Status' => false];
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $response[$field] = $messages[0];
            }
            return response()->json($response);
        }
        $structureTypeArray = explode(',', $request->structure_type);
        $solarPanelArray = explode(',', $request->panel_type);
        $panelbrandArray = explode(',', $request->panel_brand);
        $inverterbrandArray = explode(',', $request->inverter_brand);
        $bookplanttimeArray = explode(',', $request->book_plant_time);
        $uniqueLeadNo = $this->generateUniqueLeadNo($request->category);
        $enquiry = new Enquiry();
        $enquiry->customer_id = $loginid;
        $enquiry->lead_no = $uniqueLeadNo;
        $enquiry->category = $request->category;
        $enquiry->plant_load = $request->plant_load;
        $enquiry->subsidy = $request->subsidy === "true" ? true : false;
        $enquiry->finance = $request->finance === "true" ? true :  false;
        $enquiry->structure_type = json_encode($structureTypeArray);
        $enquiry->solar_panel_type = json_encode($solarPanelArray);
        $enquiry->panel_brands = json_encode($panelbrandArray);
        $enquiry->inverter_brands = json_encode($inverterbrandArray);
        $enquiry->book_plant_time = json_encode($bookplanttimeArray);
        $enquiry->status = 'draft';
        $enquiry->save();
        return response()->json([
            'status' => true,
            'message' => 'Enquiry created successfully',
            'data' => $enquiry,
        ]);
    }

    private function generateUniqueLeadNo($category)
    {
        $prefix = strtoupper(substr($category, 0, 1));
        do {
            $number = $prefix . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (Enquiry::where('lead_no', $number)->exists());

        return $number;
    }

    public function index()
    {
        $loginid = Auth::id();
        $enquiry = Enquiry::where('customer_id', $loginid)->latest()->get();
        if ($enquiry->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No data found',
            ]);
        }
        $enquiry->each(function ($item) {
            // $item->customer_id = $item->Customer->name;
            $item->structure_type = json_decode($item->structure_type);
            $item->solar_panel_type = json_decode($item->solar_panel_type);
            $item->panel_brands = json_decode($item->panel_brands);
            $item->inverter_brands = json_decode($item->inverter_brands);
            $item->book_plant_time = json_decode($item->book_plant_time);
        });

        return response()->json([
            'status' => true,
            'message' => 'Fetch all Enquiry.',
            'code' => 200,
            'data' => $enquiry,
        ]);
    }
    public function finalEnquiry()
    {
        $loginid = Auth::id();
        $enquiry = Enquiry::where('status', 'submit')->latest()->get();
        if ($enquiry->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No data found',
            ]);
        }
        $enquiry->each(function ($item) {
            // $item->customer_id = $item->Customer->name;
            $item->structure_type = json_decode($item->structure_type);
            $item->solar_panel_type = json_decode($item->solar_panel_type);
            $item->panel_brands = json_decode($item->panel_brands);
            $item->inverter_brands = json_decode($item->inverter_brands);
            $item->book_plant_time = json_decode($item->book_plant_time);
        });

        return response()->json([
            'status' => true,
            'message' => 'Fetch all Enquiry.',
            'code' => 200,
            'data' => $enquiry,
        ]);
    }

    public function fetchdetails($id)
    {
        $loginid = Auth::id();
        $enquiry = Enquiry::where('customer_id', $loginid)->where('id', $id)->first();
        // $enquiry->customer_id = $enquiry->Customer->name;
        $enquiry->structure_type = json_decode($enquiry->structure_type);
        $enquiry->solar_panel_type = json_decode($enquiry->solar_panel_type);
        $enquiry->panel_brands = json_decode($enquiry->panel_brands);
        $enquiry->inverter_brands = json_decode($enquiry->inverter_brands);
        $enquiry->book_plant_time = json_decode($enquiry->book_plant_time);
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Fetch Enquiry.',
            'data' => $enquiry,
        ]);

    }
    public function finaldetails($id)
    {
        $enquiry = Enquiry::where('lead_no', $id)->first();
        // $enquiry->customer_id = $enquiry->Customer->name;
        $enquiry->structure_type = json_decode($enquiry->structure_type);
        $enquiry->solar_panel_type = json_decode($enquiry->solar_panel_type);
        $enquiry->panel_brands = json_decode($enquiry->panel_brands);
        $enquiry->inverter_brands = json_decode($enquiry->inverter_brands);
        $enquiry->book_plant_time = json_decode($enquiry->book_plant_time);
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Fetch Enquiry.',
            'data' => $enquiry,
        ]);

    }
}
