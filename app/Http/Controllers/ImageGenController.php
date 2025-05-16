<?php

namespace App\Http\Controllers;

use App\Models\ImageHistory;
use App\Models\WalletTrans;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OpenAI\Laravel\Facades\OpenAI;

class ImageGenController extends Controller
{
    public function index(): View
    {
        return view('imageGenarationPage');
    }

    public function generateImage(Request $request): RedirectResponse
    {
        $blance = auth()->user()->wallet->balance;

        if($blance < 10){
            return back()->with('error', 'Insufficient Balance! Minimum $10 required.')->withInput();
        }

        $result = OpenAI::images()->create([
            "model"=> "gpt-image-1",
            "prompt" => $request->details,
            "n" => 1,
            "size" => "1024x1024"
        ]);

        $user = auth()->user()->id;
        $wallet = auth()->user()->wallet->id;

        WalletTrans::create([
            'wallet_id' =>  $wallet,
            'user_id'   =>  $user,
            'balance'   =>  $request->amount,
            'trans_type'=>  'out',
        ]);

        ImageHistory::create([
            'user_id'   =>  $user,
            'image_url' =>  $result->data[0]->url,
            'expense'   =>  10.00,
        ]);

        return back()->with('success', $result->data[0]->url);
    }
}
