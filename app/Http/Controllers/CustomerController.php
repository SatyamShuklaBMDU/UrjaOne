<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('Users.user_profile',compact('customers'));
    }
    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $filteredCustomers = Customer::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('Users.user_profile', ['customers' => $filteredCustomers, 'start'=>$startDate, 'end'=>$endDate]);
    }

    public function alldata($id){
        $customer = Customer::find($id);
        return response()->json($customer);
    }
    public function statuschange(Request $request)
    {
        $status = $request->input('status');
        try {
            $customer = Customer::findOrFail($request->customer);
            $customer->status = $status;
            $customer->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
