<?php

namespace App\Http\Controllers;

use App\Models\MDetailshipment;
use App\Models\MKategori;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MShipment;
use App\Models\MInvoice;
use App\Models\MPayment;
use App\Models\MJurnal;
use App\Models\MDetailinvoice;
use App\Models\MUjo;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{

    public function index()
    {
        $invoice = MInvoice::where('f_status','notpaid')->get();
        return view('finance.payment.listinvoice', compact('invoice'));

    }

    public function historyujo()
    {
        $invoice = MInvoice::where('f_status','paid')->get();
        return view('finance.payment.listinvoice', compact('invoice'));

    }
    public function history()
    {
        $payment = MPayment::get();
        return view('finance.payment.listpayment', compact('payment'));

    }


    public function invoice($id)
    {
        $invoice = MInvoice::where('noinvoice',$id)->get();
        return view('finance.payment.invoice', compact('invoice'));
    }
    public function formpay(Request $request)
    {
        $invoice = MInvoice::with('getujo')->where('noinvoice',$request->id)->get();
        return view('finance.payment.formpay', compact('invoice'));
    }
    public function store(Request $request){
        MPayment::create([
            'noinvoice' => $request->noinvoice,
            'datepayment' => Carbon::now(),
            'jumlah' => $request->total,
            'bank' => $request->bank,
            'namarekening' => $request->namarekening,
            'norekening' => $request->norekening,
            'noujo' => $request->noujo,
        ]);
        $ujo=MUjo::find($request->noujo);
        $shipmentid=$ujo->shipmentid;
        $terbayar=$ujo->terbayar+$request->total;
        $ujo->terbayar=$terbayar;
        if($ujo->nominalujo==$terbayar){
            $ujo->f_lunas='1';
        }
        $ujo->save();
        $shipment=MShipment::find($shipmentid);
        $statusshipment=$shipment->f_status;
        if($statusshipment=='New'){
            $shipment->f_status='Payout';
            $shipment->save();
        }
        $invoice=MInvoice::find($request->noinvoice);

        $invoice->f_status='paid';
        $invoice->tglpayment=Carbon::now();
        $invoice->save();
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('payment.index')->with('success', 'Data berhasil diubah');

    }

}
