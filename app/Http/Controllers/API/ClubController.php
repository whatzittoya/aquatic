<?php

namespace App\Http\Controllers\API;

use App\Club;
use App\ErrorLog;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserValidated;
use Exception;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;


class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $club = Club::orderBy('name')->with('users:id,email')->get();
        } else {
            $club = Club::orderBy('name')->where('user_id', Auth::user()->id)->with('users:id,email')->get();
        }

        return response()->json($club);
    }
    public function indexValid()
    {
        if (Auth::user()->isAdmin()) {
            $club = Club::orderBy('name')->with('users:id,email')->where('valid', 1)->get();
        } else {
            $club = Club::orderBy('name')->where('user_id', Auth::user()->id)->where('valid', 1)->with('users:id,email')->get();
        }

        return response()->json($club);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(

            'email'       => 'required|email|unique:users',
        );
        $messages = [
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email ini sudah terdaftar silahkan pilih email lain',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()], 500);
        } else {
            $validator = Validator::make($request->all(), $rules);
            $user = new User;
            $user->email = $request->email;
            $user->name = $request->name;
            $user->save();
            $club = new Club;
            $club->name       = $request->name;
            $club->address       = $request->address;
            $club->city       = $request->city;
            $club->province       = $request->province;
            $club->pic       = $request->pic;
            $club->phone_number       = $request->phone_number;
            $club->user_id = $user->id;
            $club->save();


            if ($request->valid) {
                $pass = mt_rand(100000, 999999);
                $user->username = $user->email;
                $user->password = Hash::make($pass);
                $user->role_id = 2;
                $user->update();

                $objUser = new \stdClass();
                $objUser->username = $user->username;
                $objUser->password = $pass;
                try {
                    Mail::to($user->email)->cc(explode(',', env("MAIL_CC", "")))->bcc(explode(',', env("MAIL_BCC", "")))->send(new UserValidated($objUser));
                } catch (Exception $ex) {

                    $error = new ErrorLog;
                    $error->name = "Mail registration";
                    $error->type = "Sending Mail";
                    $error->exception = $ex->getMessage();
                    $error->table = 'user';
                    $error->value = json_encode($user);
                    $error->save();
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $club = Club::find($id);

        return response()->json($club);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->data;
        $rules = array(

            'email'       => 'required|email|unique:users,email,' . $data['user_id'],
        );
        $messages = [
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email ini sudah terdaftar silahkan pilih email lain',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 500);
        } else {
            $user = User::find($data['user_id']);


            $club = Club::find($id);

            $club->name       = $data['name'];
            $club->address       = $data['address'];
            $club->city       = $data['city'];
            $club->province       = $data['province'];
            $club->pic       = $data['pic'];
            $club->phone_number       = $data['phone_number'];
            $old_valid = $club->valid;
            $club->valid       = $data['valid'];
            $club->update();
            if ($old_valid != $club->valid && $club->valid == 1) {
                $pass = mt_rand(100000, 999999);
                $user->username = $user->email;
                $user->password = Hash::make($pass);
                $user->update();

                $objUser = new \stdClass();
                $objUser->username = $user->username;
                $objUser->password = $pass;

                try {
                    Mail::to($user->email)->send(new UserValidated($objUser));
                } catch (Exception $ex) {

                    $error = new ErrorLog;
                    $error->name = "Mail registration";
                    $error->type = "Sending Mail";
                    $error->exception = $ex->getMessage();
                    $error->table = 'user';
                    $error->value = json_encode($user);
                    $error->save();
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $club = Club::find($id);

        $user = User::find($club->user_id);

        $user->email = $user->email . "deleted#" . $user->id;
        $user->username = $user->email . "deleted#" . $user->id;
        $user->update();
        $club->delete();

        return 204;
    }
}
