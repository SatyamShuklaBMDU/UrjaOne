<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = WalletTransaction::where('type','credit')->get();
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
        $wallets = WalletTransaction::where('type','credit')->whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Wallets.wallet', ['wallets' => $wallets, 'start' => $startDate, 'end' => $endDate]);
    }

    public function wallethistory(Request $request)
    {
        $walletHistory = WalletTransaction::select('vendor_id')->distinct()->get();
        // dd($walletHistory);
        return view('dashboard.Wallets.wallet_transaction',compact('walletHistory'));
    }
    public function Detailedwalletstatement($id)
    {
        $Did = decrypt($id);
        $walletHistory = WalletTransaction::where('vendor_id',$Did)->where('type','credit')->get();
        // dd($walletHistory);
        return view('dashboard.Wallets.detailes_statement',compact('walletHistory'));
    }

    public function Detailedwallettransaction($id)
    {
        $Did = decrypt($id);
        $walletHistory = WalletTransaction::where('vendor_id',$Did)->where('type','debit')->get();
        // dd($walletHistory);
        return view('dashboard.Wallets.detailes_transaction',compact('walletHistory'));
    }
}
