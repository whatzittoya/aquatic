<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Race;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $race = Race::get();
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

        $rules = array(
            'name'       => 'required',
            'race_number'       => 'required|unique:races',
        );

        $messages = [
            'name.required' => 'Nama lomba tidak boleh kosong',
            'race_number.required' => 'Nomor Lomba tidak boleh kosong',
            'race_number.unique' => 'Nomor Lomba ini sudah terdaftar silahkan pilih nomor lain',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        // process the login
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 500);
        } else {
            $race = new Race;
            $race->name = $request->name;
            $race->race_number = $request->race_number;
            $race->rule_id = $request->rule;
            $race->style = $request->style;
            $race->distance = $request->distance;
            $race->gender = $request->gender;
            $race->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function show(Race $race)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->data;
        $rules = array(
            'name'       => 'required',
            'race_number'       => 'required|unique:races,race_number,' . $id,
        );

        $messages = [
            'name.required' => 'Nama lomba tidak boleh kosong',
            'race_number.required' => 'Nomor Lomba tidak boleh kosong',
            'race_number.unique' => 'Nomor Lomba ini sudah terdaftar silahkan pilih nomor lain',
        ];
        $validator = Validator::make($data, $rules, $messages);

        // process the login
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 500);
        } else {


            $race = Race::find($id);
            $race->name = $data['name'];
            $race->race_number = $data['race_number'];
            $race->rule_id = $data['rule'];
            $race->style = $data['style'];
            $race->distance = $data['distance'];
            $race->gender = $data['gender'];
            $race->update();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $race = Race::find($id);
        $race->delete();
        return 204;
    }
}
