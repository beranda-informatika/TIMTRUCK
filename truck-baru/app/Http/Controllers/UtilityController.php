<?php

namespace App\Http\Controllers;

use App\Models\MLoglogin;
use App\Models\MSitename;
use App\Models\User;
use App\Models\MMekanik;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UtilityController extends Controller
{
    public function userpassword(){
        $users=User::with('role')->get();
        return view ('utility.listuserpassword')->with('users',$users);

    }
    public function edituser($id){
        $role=Role::orderby('id')->get();
        $users=User::where('id',$id)->first();
        return view ('utility.edituser',compact('users','role'));

    }
    public function userlog(){
        $logs=MLoglogin::orderby('created_at')->get();
        return view ('utility.loghistory')->with('logs',$logs);

    }
    public function register(){
        $role=Role::orderby('id')->get();
        return view ('utility.register',compact('role'));
    }
    public function postregister(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed'

        ];

        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->roles_id = $request->role;
        $user->password = Hash::make($request->password);

        $simpan = $user->save();

        if ($simpan) {
            Alert::success('Berhasil', 'User berhasil ditambahkan');
            return redirect()->route('utility.userpassword');
        } else {
            Alert::error('Gagal', 'User gagal ditambahkan');
            return redirect()->route('utility.userpassword');
        }
    }
    public function userdelete($id){
        $user=User::find($id);
        $level=$user->roles_id;
        $user->delete();
        Alert::success('Berhasil', 'User berhasil dihapus');
        return redirect()->back();
    }
    public function gantipassword(){
        return view ('utility.updatepassword');
    }
    public function userpasswordupdate(Request $request){
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|confirmed'

        ];

        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $user=User::where('email',$request->email)->first();
        $user->password=bcrypt($request->password);
        $user->save();
        Alert::success('Berhasil', 'Password berhasil diubah');
        Auth::logout();
        return redirect()->route('login');
    }
    public function updateuser(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$request->id,
            'role'=>'required',
        ]);
        $user = User::find($request->id);
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->roles_id = $request->role;
        $user->save();
       
        return redirect()->route('utility.userpassword')->with('success','User berhasil diupdate');
    }
}
