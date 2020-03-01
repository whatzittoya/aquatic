<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\payment;
use App\Payment as AppPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $payment = AppPayment::with("clubs:id,name", "events:id,name")->orderBy('verified', 'asc')->get();
        } else {
            $payment = AppPayment::with("clubs:id,name", "events:id,name")->whereHas('clubs', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->orderBy('verified', 'asc')->get();;
        }
        return response()->json($payment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'file'       => 'required|max:500|mimes:pdf,png,jpg,jpeg',

        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 500);
        } else {
            $file = $request->file('file');
            $path = Storage::putFile(
                'payments',
                $file
            );
            $payment = new Payment;

            $payment->club_id = $request->club_id;
            $payment->event_id = $request->event_id;
            $payment->bank_name = $request->bank_name;
            $payment->account_name = $request->account_name;
            $payment->account_number = $request->account_number;
            $payment->amount = $request->amount;
            $payment->pic_path = $path;
            $payment->pic_name = $file->getClientOriginalName();
            $payment->pic_type       = $file->getMimeType();
            if ($request->verified >= 0) {
                $payment->verified = $request->verified;
            }

            $payment->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->data;
        $payment = Payment::find($id);
        $file = $data->file('file');
        // store
        if ($payment->pic_name != $request->pic_name) {
            $path = Storage::putFile(
                'payments',
                $file
            );
            $payment->pic_name       = $file->getClientOriginalName();
            $payment->pic_path = $path;
            $payment->extension       = $file->getClientOriginalExtension();
            $payment->pic_type       = $file->getMimeType();
        }
        $payment->club_id       = $data['club_id'];
        $payment->event_id       = $data['event_id'];
        $payment->bank_name       = $data['bank_name'];
        $payment->account_name       = $data['account_name'];
        $payment->account_number       = $data['account_number'];
        $payment->amount       = $data['amount'];
        if ($data['verified'] >= 0) {
            $payment->verified       = $data['verified'];
        }
        $payment->update();
    }
    public function updateApi(Request $request, $id)
    {

        $payment = Payment::find($id);
        $file = $request->file('file');
        // store
        if ($payment->pic_name != $request->pic_name) {
            $path = Storage::putFile(
                'payments',
                $file
            );
            $payment->pic_name       = $file->getClientOriginalName();
            $payment->pic_path = $path;

            $payment->pic_type       = $file->getMimeType();
        }
        $payment->club_id       = $request->club_id;
        $payment->event_id       = $request->event_id;
        $payment->bank_name       = $request->bank_name;
        $payment->account_name       = $request->account_name;
        $payment->account_number       = $request->account_number;
        $payment->amount       = $request->amount;
        if ($request->verified >= 0) {
            $payment->verified       = $request->verified;
        }
        $payment->update();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        return 204;
    }
}
