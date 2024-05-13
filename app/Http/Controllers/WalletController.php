<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = WalletTransaction::all();
        return view('dashboard.Wallets.wallet',compact('wallets'));
    }
    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $wallets = WalletTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Wallets.wallet', ['wallets' => $wallets, 'start' => $startDate, 'end' => $endDate]);
    }
}
