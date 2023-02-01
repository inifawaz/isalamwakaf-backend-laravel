<?php

namespace App\Http\Controllers;

use App\Models\ManualPayment;
use App\Http\Requests\StoreManualPaymentRequest;
use App\Http\Requests\UpdateManualPaymentRequest;
use App\Http\Resources\ManualPaymentItemResource;
use App\Mail\PaymentRejectedMail;
use App\Mail\PaymentSuccessMail;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ManualPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('Admin')) {
            if ($request->has('search')) {
                return response()->json([
                    "data" => ManualPaymentItemResource::collection(ManualPayment::where('reference', $request->search)->latest('updated_at')->get())
                ]);
            }
            if ($request->has('status')) {
                return response()->json([
                    "data" => ManualPaymentItemResource::collection(ManualPayment::where('status_code', $request->status)->latest('updated_at')->get())
                ]);
            }
        }
        return response()->json([
            "data" => ManualPaymentItemResource::collection(ManualPayment::where('payer_id', Auth::user()->id)->where('status_code', $request->status)->latest('updated_at')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreManualPaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreManualPaymentRequest $request)
    {
        $manualPayment = new ManualPayment();
        $manualPayment->reference = now()->format("ymdHis") . random_int(100, 999);
        $manualPayment->payer_id = Auth::user()->id;
        $manualPayment->campaign_id = $request->campaign_id;
        $manualPayment->amount = $request->amount;
        $manualPayment->maintenance_fee = $request->maintenance_fee;
        $manualPayment->on_behalf = $request->on_behalf;
        $manualPayment->wos = $request->wos;
        $manualPayment->is_anonim = $request->is_anonim;
        $manualPayment->save();

        return response()->json([
            "message" => "Berhasil membuat pembayaran",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ManualPayment  $manualPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ManualPayment $manualPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateManualPaymentRequest  $request
     * @param  \App\Models\ManualPayment  $manualPayment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateManualPaymentRequest $request, ManualPayment $manualPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ManualPayment  $manualPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManualPayment $manualPayment)
    {
        //
    }

    public function uploadReceipt(Request $request)
    {
        if ($request->hasFile('receipt_file')) {
            $file = $request->file('receipt_file');
            $fileName = $request->reference . '.' . $file->extension();
            $file->storeAs('receipt-images/campaign', $fileName, ['disk' => 'public']);
            $payment = ManualPayment::where('reference', $request->reference)->first();

            $payment->receipt_url = $fileName;
            $payment->update([
                "status_code" => 1,
                "receipt_url" => $fileName
            ]);


            return response()->json([
                "message" => "berhasil mengirim bukti pembayaran",
                "data" => $payment
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        if ($request->status_code == 2) {
            $payment = ManualPayment::findOrFail($request->reference);
            $payment->status_code = $request->status_code;
            $payment->comment = $request->comment;
            $payment->update();
            Mail::to($payment->payer->email)->send(new PaymentSuccessMail($payment));
            return response()->json([
                'message' => 'Berhasil merubah status pembayaran'
            ]);
        }
        if ($request->status_code == 3) {
            $payment = ManualPayment::findOrFail($request->reference);
            $payment->status_code = $request->status_code;
            $payment->comment = $request->comment;
            $payment->update();
            Mail::to($payment->payer->email)->send(new PaymentRejectedMail($payment));
            return response()->json([
                'message' => 'Berhasil merubah status pembayaran'
            ]);
        }
    }
}
