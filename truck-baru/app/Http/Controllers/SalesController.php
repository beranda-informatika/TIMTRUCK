<?php

namespace App\Http\Controllers;

use App\Models\MSales;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;



class SalesController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sales = MSales::get();
        return view('sales.index', compact('sales'));
    }
    public function create()
    {
        return view('sales.create');
    }
    public function edit($id)
    {
        $sales = MSales::find($id);
        return view('sales.edit', compact('sales'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kdsales' => 'required|regex:/^\S*$/u|unique:sales,kdsales',
            'namasales' => 'required',
        ]);

        $sales = new MSales;
        $sales->kdsales = $request->kdsales;
        $sales->namasales = $request->namasales;
        $simpan = $sales->save();

        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('sales.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();
            
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kdsales' => 'required|regex:/^\S*$/u|unique:sales,kdsales,' . $id . ',kdsales',
            'namasales' => 'required',
        ]);

        $sales = MSales::find($id);
        $sales->kdsales = $request->kdsales;
        $sales->namasales = $request->namasales;
        $simpan = $sales->save();
        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('sales.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();
            
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            MSales::where('kdsales', '=', $id)->delete();
            Alert::success('sukses dihapus');
            return redirect()->route('sales.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('sales.index');
        }
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
    public function getsales(Request $request)
    {
        $sales = MSales::
            where('namasales', 'LIKE', '%' . $request->search . '%')->orderBy('kdsales', 'ASC')->get();

        $response = array();
        foreach ($sales as $value) {
            $response[] = array(
                "id" => $value->kdsales,
                "text" => $value->namasales,
            );
        }

        return response()->json($response);
    }
}
