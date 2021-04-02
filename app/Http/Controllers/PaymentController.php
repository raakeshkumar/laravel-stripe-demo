<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Cashier\Exceptions\IncompletePayment;

class PaymentController extends Controller
{
    public function show() {
        return view('payment.form');
    }

    public function paymentAction(Request $request) {
        $user         = User::where('id', 1)->first();
        
        try {
            $stripeCharge = $user->charge(100, $request->pmethod);
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('payment')]
            );
        }

        dd($stripeCharge);
    }
}
