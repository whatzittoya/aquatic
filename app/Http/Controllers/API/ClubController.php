<?php

namespace App\Http\Controllers\API;

use App\Club;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $club = Club::orderBy('name')->get();
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
        $club = new Club;
        $club->name       = $request->name;
        $club->address       = $request->address;
        $club->city       = $request->city;
        $club->province       = $request->province;
        $club->pic       = $request->pic;

        $club->save();
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
        $club = Club::find($id);

        $club->name       = $data['name'];
        $club->address       = $data['address'];
        $club->city       = $data['city'];
        $club->province       = $data['province'];
        $club->pic       = $data['pic'];


        $club->update();
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
        $club->delete();
        return 204;
    }
}
