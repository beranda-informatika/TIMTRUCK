<?php

namespace App\Http\Controllers;

use App\Models\MQuotation;
use App\Models\MGroupquotation;
use App\Models\MShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $shipments=MShipment::orderby('shipmentid','desc')->take(5)->get();
        $quotationso=MGroupquotation::accso()->get();
        return view('index', compact('quotationso','shipments'));
    }
    public function root(Request $request)
    {

        $shipments=MShipment::orderby('shipmentid','desc')->take(5)->get();
        $quotationso=MGroupquotation::accso()->get();
        return view('index', compact('quotationso','shipments'));

    }
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }
    public function restrictpage()
    {
        return view('restrict-page');
    }
}
