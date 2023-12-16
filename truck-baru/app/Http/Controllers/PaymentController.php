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
        $invoice = MInvoice::with('getdetailinvoice')->where('f_lunas','0')->get();
        return view('finance.payment.listinvoice', compact('invoice'));

    }

    public function historyujo()
    {
        $invoice = MInvoice::with('getdetailinvoice')->where('f_status','paid')->get();
        return view('finance.payment.listinvoice', compact('invoice'));

    }
    public function history()
    {
        $payment = MPayment::get();
        return view('finance.payment.listpayment', compact('payment'));

    }


    public function invoice($id)
    {
        $invoice = MInvoice::with('getdetailinvoice')->where('noinvoice',$id)->get();
        return view('finance.payment.invoice', compact('invoice'));
    }
    public function formpay(Request $request)
    {
        $shipment=MInvoice::where('noinvoice',$request->id)->first();
        $shipmentid=$shipment->shipmentid;
        $debet=MJurnal::where('shipmentid',$shipmentid)->sum('debet');
        $kredit=MJurnal::where('shipmentid',$shipmentid)->sum('kredit');
        $totalpembayaran=$debet-$kredit;
        $invoice = MInvoice::with('getshipment','getdetailinvoice')->where('noinvoice',$request->id)->get();

        return view('finance.payment.formpay', compact('invoice','totalpembayaran'));
    }
    public function store(Request $request){
        MPayment::create([
            'noinvoice' => $request->noinvoice,
            'datepayment' => Carbon::now(),
            'jumlah' => $request->nominal,
            'bank' => $request->bank,
            'namarekening' => $request->namarekening,
            'norekening' => $request->norekening,
            'shipmentid' => $request->shipmentid,
        ]);

        $invoice=MInvoice::find($request->noinvoice);

        $bayar=$request->nominal+$request->totalpembayaran;
        $invoice->bayar=$bayar;
        $invoice->sisa = $invoice->total-$bayar;
        if($bayar==$invoice->total){
            $invoice->f_lunas='1';
        }
        $invoice->f_status='paid';
        $invoice->tglpayment=Carbon::now();
        $invoice->save();
        //cek rate
        $cek=MDetailinvoice::where('noinvoice',$request->noinvoice)->where('rateid','50027')->get();
        if ($cek->count()>0) {
            MJurnal::create([
                'shipmentid' => $request->shipmentid,
                'rateid'=>"50027",
                'kdakun' => "102",
                'debet' => $request->nominal,
                'kredit' => 0,
                'kodetr' => "TR001"
            ]);
        }
        else {
            MJurnal::create([
                'shipmentid' => $request->shipmentid,
                'rateid'=>"50021",
                'kdakun' => "501",
                'debet' => $request->nominal,
                'kredit' => 0,
                'kodetr' => "TR002"
            ]);
        }
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('payment.index')->with('success', 'Data berhasil diubah');

    }

}
