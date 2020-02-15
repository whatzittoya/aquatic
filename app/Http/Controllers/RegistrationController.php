<?php

namespace App\Http\Controllers;

use App\Member;
use App\User;
use App\ErrorLog;
use App\Club;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;
use Exception;
use Illuminate\Mail\Message;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $club = Club::orderBy('name')->get();

        return view('auth.register', ['club' => $club]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //// validate
        // read more on validation at http://laravel.com/docs/validation
        // $rules = array(
        //     'klub'       => 'required',
        //     'nama'       => 'required',
        //     'tanggal_lahir'       => 'required',
        //     'email'       => 'required|email|unique:users',
        //     'dokumen'       => 'required|max:500|mimes:pdf,png,jpg,jpeg',

        // );
        // $validator = Validator::make($request->all(), $rules);

        // // process the login
        // if ($validator->fails()) {
        //     return redirect()->route('register')
        //         ->withErrors($validator)
        //         ->withInput();
        // } else {
        //     //blob
        //     $file = $request->file('dokumen');

        //     $path = Storage::putFile(
        //         'documents',
        //         $request->file('dokumen')
        //     );


        //     $user = new User;
        //     $user->email = $request->email;
        //     $user->name = $request->nama;
        //     $user->save();

        //     $member = new Member;
        //     $member->name       = $request->nama;
        //     $member->club_id       = $request->klub;
        //     $member->born_date       = $request->tanggal_lahir;
        //     $member->best_time       = 3599999;
        //     $member->valid       = 0;
        //     $member->filename       = $file->getClientOriginalName();
        //     $member->path = $path;
        //     $member->extension       = $file->getClientOriginalExtension();
        //     $member->file_type       = $file->getMimeType();
        //     $member->user_id       = $user->id;
        //     $member->save();


        //     return redirect()->route('register')->with('message', 'Pendaftaran Berhasil');;
        // }

        $rules = array(
            'nama'       => 'required',
            'alamat'       => 'required',
            'kota'       => 'required',
            'provinsi'       => 'required',
            'pic'       => 'required',
            'email'       => 'required|email|unique:users',
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        } else {
            //blob



            $user = new User;
            $user->email = $request->email;
            $user->name = $request->nama;
            $user->role_id = 2;
            $user->save();

            $club = new Club;
            $club->name       = $request->nama;
            $club->address       = $request->alamat;
            $club->city       = $request->kota;
            $club->province       = $request->provinsi;
            $club->pic       = $request->pic;
            $club->valid       = 0;

            $club->user_id       = $user->id;
            $club->save();
            $objUser = new \stdClass();
            try {
                Mail::to($user->email)->send(new UserRegistered($objUser));
            } catch (Exception $ex) {

                $error = new ErrorLog;
                $error->name = "Mail registration";
                $error->type = "Sending Mail";
                $error->exception = $ex->getMessage();
                $error->table = 'user';
                $error->value = json_encode($user);
                $error->save();
            }


            return redirect()->route('register')->with('message', 'Pendaftaran Berhasil, Silahkan cek kotak masuk atau spam email anda untuk melihat email dari kami');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::findOrFail($id);
        // $fileupload = $file->data;
        // $file_contents = base64_decode($fileupload);

        $file = Storage::disk('local')->get($member->path);

        return response()->make($file, 200, [
            'Content-Type'        => $member->file_type,
            'Content-Disposition' => 'inline; filename="' . $member->filename . '"'
        ]);
    }
    // public function email($id)
    // {
    //     $pass = mt_rand(100000, 999999);;
    //     $user = User::find($id);
    //     $user->username = $user->email;
    //     $user->password = Hash::make($pass);
    //     $user->update();

    //     $objUser = new \stdClass();
    //     $objUser->username = $user->username;
    //     $objUser->password = $pass;
    //     Mail::to("whosendall@gmail.com")->send(new UserValidated($objUser));
    //     // check for failures
    //     if (Mail::failures()) {
    //         echo "error";
    //     } else {
    //         echo "success";
    //     }
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(member $member)
    {
        //
    }
}
