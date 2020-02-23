<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\EventRace;
use App\Http\Controllers\Controller;
use App\PureRace as AppPureRace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as ValidationRule;
use App\PureRace;
use Illuminate\Support\Facades\DB;

class EventRaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $uniqueRule =  ValidationRule::unique('races')->where(function ($query) use ($request) {
            $query->where('race_number', $request->race_number);
            $query->where('event_id', $request->event_id);
        });
        $rules = array(
            'race_number'       => ['required', $uniqueRule]
        );

        $messages = [
            'race_number.required' => 'Nomor Lomba tidak boleh kosong',
            'race_number.unique' => 'Nomor Lomba ini sudah terdaftar silahkan pilih nomor lain',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        // process the login
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 500);
        } else {
            $event_race = new EventRace;
            $event_race->pure_race_id = $request->pure_race;
            $event_race->event_id = $request->event_id;
            $event_race->race_number = $request->race_number;
            $event_race->gender = $request->gender;
            $event_race->save();
            $event_race->rules()->attach($request->rules);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event_race = Event::with('races', 'races.pureRaces:pure_races.id,name,style,distance', 'races.rules:rules.id')->where('id', $id)->first();
        return response()->json($event_race->races);
    }
    public function available($id)
    {
        $race = PureRace::with(['races' => function ($query) use ($id) {
            $query->where('event_id', $id)->select('pure_race_id', 'gender');
        }])->whereNotIn('id', function ($query) use ($id) {
            $query->select('pure_race_id')->from('races')->where('event_id', $id)->where('deleted_at', null)->whereRaw('(gender = ? or gender=?)', ['PA', 'PI'])->groupBy('pure_race_id')->havingRaw('count(pure_race_id)>1');
        })->get();

        return response()->json($race);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->data;

        $uniqueRule =  ValidationRule::unique('races')->where(function ($query) use ($data) {
            $query->where('race_number', $data['race_number']);
            $query->where('event_id', $data['event_id']);
            $query->where('id', '!=', $data['id']);
        });
        $rules = array(
            'race_number'       => ['required', $uniqueRule]
        );

        $messages = [
            'race_number.required' => 'Nomor Lomba tidak boleh kosong',
            'race_number.unique' => 'Nomor Lomba ini sudah terdaftar silahkan pilih nomor lain',
        ];
        $validator = Validator::make($data, $rules, $messages);

        // process the login
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 500);
        } else {
            $event_race = EventRace::find($id);
            $event_race->pure_race_id = $data['pure_race'];

            $event_race->race_number = $data['race_number'];
            $event_race->gender = $data['gender'];
            $event_race->update();

            try {
                $event_race->rules()->sync($data['rules']);
            } catch (\Throwable $th) {
                $rules_id = [];
                foreach ($data['rules'] as $row) {
                    array_push($rules_id, $row['id']);
                }
                // return response()->json($data['rules']);
                $event_race->rules()->sync($rules_id);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $race = EventRace::find($id);
        $race->delete();
        return 204;
    }
}
