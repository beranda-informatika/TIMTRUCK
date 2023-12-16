<?php

namespace App\Http\Controllers;

use App\Models\MDriver;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;



class DriverController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $driver = MDriver::get();
        return view('driver.index', compact('driver'));
    }
    public function create()
    {
        return view('driver.create');
    }
    public function edit($id)
    {
        $driver = MDriver::find($id);
        return view('driver.edit', compact('driver'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kddriver' => 'required|regex:/^\S*$/u|unique:driver,kddriver',
            'namadriver' => 'required',
            'nohp' => 'required',
            'bank' => 'required',
            'norekening' => 'required',
            'namarekening' => 'required',

        ]);

        $driver = new MDriver;
        $driver->kddriver = $request->kddriver;
        $driver->namadriver = $request->namadriver;
        $driver->nohp = $request->nohp;
        $driver->bank = $request->bank;
        $driver->norekening = $request->norekening;
        $driver->namarekening = $request->namarekening;
        $simpan = $driver->save();

        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('driver.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kddriver' => 'required|regex:/^\S*$/u|unique:driver,kddriver,' . $id . ',kddriver',
            'namadriver' => 'required',
            'nohp' => 'required',
            'bank' => 'required',
            'namarekening' => 'required',
            'norekening' => 'required',
        ]);

        $driver = MDriver::find($id);
        $driver->kddriver = $request->kddriver;
        $driver->namadriver = $request->namadriver;
        $driver->nohp = $request->nohp;
        $driver->bank = $request->bank;
        $driver->norekening = $request->norekening;
        $driver->namarekening = $request->namarekening;
        $simpan = $driver->save();
        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('driver.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }
    }
    public function destroy(Request $request)
    {
        try {
            $id = $request->kddriver;
            MDriver::where('kddriver', '=', $id)->delete();
            Alert::success('sukses dihapus');
            return redirect()->route('driver.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('driver.index');
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
    public function getdriver(Request $request)
    {
        $driver = MDriver::
            where('namadriver', 'LIKE', '%' . $request->search . '%')->orderBy('kddriver', 'ASC')->get();

        $response = array();
        foreach ($driver as $value) {
            $response[] = array(
                "id" => $value->kddriver,
                "text" => $value->namadriver,
            );
        }

        return response()->json($response);
    }
}
