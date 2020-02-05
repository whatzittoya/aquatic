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

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::select('id', 'name', 'born_date', 'best_time', 'club_id', 'filename', 'valid')->with('clubs:id,name')->get();

        return response()->json($member);
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
        $file = $request->file('file');
        $path = Storage::putFile(
            'documents',
            $file
        );


        $member = new Member;
        $member->name       = $request->name;
        $member->club_id       = $request->club_id;
        $member->born_date       = $request->born_date;
        $member->best_time       = $request->best_time;
        $member->valid       = $request->valid;
        $member->filename       = $file->getClientOriginalName();
        $member->path = $path;
        $member->extension       = $file->getClientOriginalExtension();
        $member->file_type       = $file->getMimeType();
        // $member->user_id       = $user->id;
        $member->save();

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
        $member->best_time       = $request->best_time;
        echo $request->filename;
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
