<?php

namespace App\Http\Controllers;

use App\Models\MTypetruck;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;



class TypetruckController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $typetruck = MTypetruck::get();
        return view('typetruck.index', compact('typetruck'));
    }
    public function create()
    {
        return view('typetruck.create');
    }
    public function edit($id)
    {
        $typetruck = MTypetruck::find($id);
        return view('typetruck.edit', compact('typetruck'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'typetruckid' => 'required|unique:typetruck,typetruckid|regex:/^\S*$/u',
            'namatypetruck' => 'required',
        ],
        [
            'typetruckid.required' => 'Kode Type Truck tidak boleh kosong',
            'typetruckid.unique' => 'Kode Type Truck sudah ada',
            'typetruckid.regex' => 'Kode Type Truck tidak boleh ada spasi',
            'namatypetruck.required' => 'Nama Type Truck tidak boleh kosong',]
    
    );

        $typetruck = new MTypetruck;
        $typetruck->typetruckid = $request->typetruckid;
        $typetruck->namatypetruck = $request->namatypetruck;
        $simpan = $typetruck->save();

        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('typetruck.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();
            
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'typetruckid' => 'required|regex:/^\S*$/u|unique:typetruck,typetruckid,' . $id . ',typetruckid',
            'namatypetruck' => 'required',
        ],
        [
            'typetruckid.required' => 'Kode Type Truck tidak boleh kosong',
            'typetruckid.unique' => 'Kode Type Truck sudah ada',
            'typetruckid.regex' => 'Kode Type Truck tidak boleh ada spasi',
            'namatypetruck.required' => 'Nama Type Truck tidak boleh kosong',]);

        $typetruck = MTypetruck::find($id);
        $typetruck->typetruckid = $request->typetruckid;
        $typetruck->namatypetruck = $request->namatypetruck;
        $simpan = $typetruck->save();
        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('typetruck.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();
            
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            MTypetruck::where('typetruckid', '=', $id)->delete();
            Alert::success('sukses dihapus');
            return redirect()->route('typetruck.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('typetruck.index');
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
    public function gettypetruck(Request $request)
    {
        $typetruck = MTypetruck::
            where('namatypetruck', 'LIKE', '%' . $request->search . '%')->orderBy('typetruckid', 'ASC')->get();

        $response = array();
        foreach ($typetruck as $value) {
            $response[] = array(
                "id" => $value->typetruckid,
                "text" => $value->namatypetruck,
            );
        }

        return response()->json($response);
    }
}
