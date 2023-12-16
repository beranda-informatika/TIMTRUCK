<?php

namespace App\Http\Controllers;

use App\Models\MCustomer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;



class CustomerController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $customer = MCustomer::get();
        return view('customer.index', compact('customer'));
    }
    public function create()
    {
        return view('customer.create');
    }
    public function edit($id)
    {
        $customer = MCustomer::find($id);
        return view('customer.edit', compact('customer'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kdcustomer' => 'required|regex:/^\S*$/u|unique:customer,kdcustomer',
            'namacustomer' => 'required',
            'address' => 'required',
        ]);

        $customer = new MCustomer;
        $customer->kdcustomer = $request->kdcustomer;
        $customer->namacustomer = $request->namacustomer;
        $customer->address = $request->address;
        $simpan = $customer->save();

        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('customer.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kdcustomer' => 'required|regex:/^\S*$/u|unique:customer,kdcustomer,' . $id . ',kdcustomer',
            'namacustomer' => 'required',
            'address' => 'required',
        ]);

        $customer = MCustomer::find($id);
        $customer->kdcustomer = $request->kdcustomer;
        $customer->namacustomer = $request->namacustomer;
        $customer->address = $request->address;

        $simpan = $customer->save();
        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('customer.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }
    }
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            MCustomer::where('kdcustomer', '=', $id)->delete();
            Alert::success('sukses dihapus');
            DB::commit();
            return redirect()->route('customer.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            DB::rollback();
            return redirect()->route('customer.index');
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
    public function getcustomer(Request $request)
    {
        $customer = MCustomer::where('namacustomer', 'LIKE', '%' . $request->search . '%')->orderBy('kdcustomer', 'ASC')->get();

        $response = array();
        $response[] = array(
            "id" => 'all',
            "text" => 'All Customer',
        );
        foreach ($customer as $value) {
            $response[] = array(
                "id" => $value->kdcustomer,
                "text" => $value->namacustomer,
            );
        }

        return response()->json($response);
    }
}
