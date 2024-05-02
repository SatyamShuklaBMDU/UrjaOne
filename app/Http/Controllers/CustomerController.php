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
        // Define validation rules
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $filteredCustomers = Customer::whereBetween('created_at', [$startDate, $endDate])->get();
        // dd($filteredCustomers);
        return view('Users.user_profile', ['customers' => $filteredCustomers, 'start'=>$startDate, 'end'=>$endDate]);
    }
}
