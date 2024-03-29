<?php

namespace App\Http\Controllers\API;

use App\Member;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserValidated;
use Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $member = Member::with('clubs:id,name')->get();
        } else {
            $member = Member::with('clubs:id,name')->whereHas('clubs', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();
        }
        return response()->json($member)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$mimetypes = new \GuzzleHttp\Mimetypes;

        // store
        // $user = new User;
        // $user->email = $request->email;
        // $user->name = $request->name;
        // $user->save();

        $rules = array(
            'file'       => 'required|max:500|mimes:pdf,png,jpg,jpeg',

        );


        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 500);
        } else {
            $file = $request->file('file');
            $path = Storage::putFile(
                'documents',
                $file
            );


            $member = new Member;
            $member->name       = $request->name;
            $member->club_id       = $request->club_id;
            $member->born_date       = $request->born_date;
            $member->valid       = $request->valid;
            $member->filename       = $file->getClientOriginalName();
            $member->path = $path;
            $member->gender = $request->gender;
            $member->extension       = $file->getClientOriginalExtension();
            $member->file_type       = $file->getMimeType();
            // $member->user_id       = $user->id;
            $member->save();
        }
        // if ($request->valid && is_null($user->username)) {
        //     $pass = mt_rand(100000, 999999);
        //     $user->username = $user->email;
        //     $user->password = Hash::make($pass);
        //     $user->update();

        //     $objUser = new \stdClass();
        //     $objUser->username = $user->username;
        //     $objUser->password = $pass;
        //     Mail::to("whosendall@gmail.com")->send(new UserValidated($objUser));
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $member = Member::where('id', $id)->select('id', 'name', 'born_date', 'best_time', 'club_id', 'filename', 'valid', 'filename')->with('clubs:id,name')->with('users:id,email')->first();

        // return response()->json($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // store
        // $member = Member::find($id);
        // $member->name       = $request->name;
        // $member->club_id       = $request->club_id;
        // $member->born_date       = $request->born_date;
        // $member->best_time       = $request->best_time;

        // $member->valid       = $request->valid;

        // $member->update();
    }

    public function updateApi(Request $request, $id)
    {
        $member = Member::find($id);
        $file = $request->file('file');
        // store

        $member->name       = $request->name;
        $member->club_id       = $request->club_id;
        $member->born_date       = $request->born_date;

        if ($member->filename != $request->filename) {
            $path = Storage::putFile(
                'documents',
                $file
            );
            $member->filename       = $file->getClientOriginalName();
            $member->path = $path;
            $member->extension       = $file->getClientOriginalExtension();
            $member->file_type       = $file->getMimeType();
        }
        $member->gender = $request->gender;
        $member->valid       = $request->valid;
        $member->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();
        return 204;
    }
}
