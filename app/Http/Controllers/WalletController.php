<?php

namespace App\Http\Controllers;

use App\Models\WalletTrans;
use Stripe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function index(): View
    {
        $blance = WalletTrans::all();
        return view('walletPage')->with(['blance' => $blance]);
    }

    public function stripePost(Request $request): RedirectResponse
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $result = Stripe\Charge::create ([
            "amount" => $request->amount * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Wallet Recharge"
        ]);

        // dd($result->payment_method_details->card->last4);

        $user = auth()->user()->id;
        $wallet = auth()->user()->wallet->id;

        WalletTrans::create([
            'wallet_id' =>  $wallet,
            'user_id'   =>  $user,
            'balance'   =>  $request->amount,
            'trans_type'=>  'in',
            'name'      =>  $request->name,
            'card_number'=>  $result->payment_method_details->card->last4,
            'card_exp_date' => $result->payment_method_details->card->exp_month.'/'.$result->payment_method_details->card->exp_year,
        ]);

        return back()->with('success', 'Payment successful!');
    }
}
