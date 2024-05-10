<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerFeedback;
use App\Models\UserComplaint;
use App\Models\Vendor;
use App\Models\VendorComplaint;
use App\Models\VendorFeedback;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Customer::count();
        $user += Vendor::count();
        $feedback = CustomerFeedback::count();
        $feedback += VendorFeedback::count();
        $complaint = UserComplaint::count();
        $complaint += VendorComplaint::count();
        return view('dashboard',compact('user','feedback','complaint'));
    }
}
