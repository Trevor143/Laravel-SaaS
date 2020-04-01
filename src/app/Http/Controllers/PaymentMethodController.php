<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $intent = auth()->user()->createSetupIntent();

        return view('payment-methods.create', compact('intent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            auth()->user()->addPaymentMethod($request->input('payment-method'));
            if($request->input('default') == 1){
                auth()->user()->updateDefaultPaymentMethod($request->input('payment-method'));
            }
            return redirect()->route('billing')->withMessage('Added New Payment Method');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsDefault(Request $request, $paymentMethod)
    {
        try {
                auth()->user()->updateDefaultPaymentMethod($paymentMethod);
            return redirect()->route('billing')->withMessage('Payment Method updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
