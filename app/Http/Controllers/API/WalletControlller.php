<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WalletControlller extends Controller
{
    public function credit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            $response = ['status' => false];
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $response[$field] = $messages[0];
            }
            return response()->json($response);
        }
        $user = Vendor::findOrFail(Auth::id());
        $wallet = $user->wallets;
        $previousbalance = $wallet->balance;
        $updatedbalance = $wallet->balance += $request->amount;
        $wallet->save();
        // dd($previousbalance);
        $amount = $user->walletTransactions()->sum('amount');
        $transaction = $user->walletTransactions()->create([
            'last_amount' => $previousbalance,
            'amount' => $request->amount,
            'type' => 'credit',
            'wallet_id' => $wallet->id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Wallet credit successfully',
            'last_total_amount' => $previousbalance,
            'added_amount' => $request->amount,
            'final_amount' => $wallet->balance,
        ]);
    }

    public function debit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            $response = ['status' => false];
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $response[$field] = $messages[0];
            }
            return response()->json($response);
        }
        $user = Vendor::findOrFail(Auth::id());
        $amount = $user->walletTransactions()->sum('amount');
        $wallet = $user->wallets;
        $previousbalance = $wallet->balance;
        if ($wallet->balance < $request->amount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient balance',
            ]);
        }
        $wallet->balance -= $request->amount;
        $wallet->save();
        $transaction = $user->walletTransactions()->create([
            'last_amount' => $previousbalance,
            'amount' => $request->amount,
            'type' => 'debit',
            'wallet_id' => $wallet->id, // Store the wallet ID

        ]);
        $final = $amount - $request->amount;
        return response()->json([
            'status' => true,
            'message' => 'Wallet debit successfully',
            'last_total_amount' => $previousbalance,
            'debited_amount' => $request->amount,
            'final_amount' => $wallet->balance,
        ]);
    }

}
