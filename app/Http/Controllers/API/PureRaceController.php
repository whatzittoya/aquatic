<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\PureRace;
use Illuminate\Http\Request;

class PureRaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $race = PureRace::get();
        return response()->json($race);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $race = new PureRace;
        $race->name = $request->name;
        $race->style = $request->style;
        $race->distance = $request->distance;
        $race->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PureRace  $pureRace
     * @return \Illuminate\Http\Response
     */
    public function show(PureRace $pureRace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PureRace  $pureRace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->data;
        $race =  PureRace::find($id);
        $race->name = $data['name'];
        $race->style = $data['style'];
        $race->distance = $data['distance'];
        $race->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PureRace  $pureRace
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $race = PureRace::find($id);
        $race->delete();
        return 204;
    }
}
