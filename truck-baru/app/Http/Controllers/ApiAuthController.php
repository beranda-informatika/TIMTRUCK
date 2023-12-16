<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\M_sesionuser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            $cek = Auth::user();
            if ($cek->roles_id == '1') {
                return $data = [
                    'status' => 'success',
                    'data' => [$cek],
                ];
            }
            else if ($cek->roles_id == '6')
            {
                $datauser=User::find($cek->id);



                return $data = [
                    'status' => true,
                    'userid'=>$cek->id,
                    'username' => $cek->name,
                    'email'=>$cek->email,
                    'roles_id'=>$cek->roles_id,
                    'kddriver'=>$datauser->getdriver->kddriver,

                ];
            }


        } else { // false
            return $data = [
                'status' =>false,
                'data' => [],
            ];
        }
    }


    public function gantipassword(Request $request)
    {
        $rules = [
            'password'                 => 'required',
            'passwordbaru'              => 'required'
        ];

        $messages = [
            'password.required'     => 'Password lama wajib diisi',
            'passwordbaru.required'       => 'Password baru wajib diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'error' => false,
                'rsp' => '006',
                'message' => 'Isian password wajib di isi',
                'data' => []
            ];
        }

        $data = [
            'email'     => $request->email,
            'password'  => $request->password,
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            $passwordbaru = $request->passwordbaru;
            User::where('email', $request->email)->update(['password' => Hash::make($passwordbaru)]);
            return [
                'error' => false,
                'rsp' => '000',
                'message' => 'Sukses',
                'data' => []
            ];
        } else {
            return [
                'error' => false,
                'rsp' => '006',
                'message' => 'Password lama salah',
                'data' => []
            ];
        }
    }

}
