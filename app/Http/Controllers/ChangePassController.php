<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class ChangePassController extends Controller
{
    //
    public function index()
    {
        return view('admin/change_password');
    }
    public function store(Request $request)
    {
        $rules = array(
            'current-password'       => 'required',
            'new-password'       => 'required',
            'new-password-confirm'       => 'required',



        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = Auth::user();
            if (!(Hash::check($request->get('current-password'), $user->password))) {
                // The passwords matches
                return redirect()->back()->with("error", "Password lama anda tidak sesuai dengan password anda saat ini");
            }

            if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
                //Current password and new password are same
                return redirect()->back()->with("error", "Password baru tidak dapat sama dengan password lama.");
            }
            if (!(strcmp($request->get('new-password'), $request->get('new-password-confirm'))) == 0) {
                //New password and confirm password are not same
                return redirect()->back()->with("error", "Password baru harus sama dengan konfirmasi password");
            }

            $user->password = bcrypt($request->get('new-password'));

            $user->save();
            return redirect()->back()->with("success", "Password berhasil diubah.");
        }
    }
}
