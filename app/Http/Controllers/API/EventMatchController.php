<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Participant;
use App\Events\MyEvent;
use Illuminate\Support\Facades\DB;

class EventMatchController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::with('races.pureRaces')->with('races.participants')->with('races.participants.member:id,name,born_date', 'races.participants.club:id,name,city', 'races.participants.rule')->select('id', 'name')->find($id);

        return response()->json($event);
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
        $participant = Participant::find($id);
        $participant->best_time = $data['int_best_time'];
        $participant->update();

        $datadone = DB::select('call prc_set_rank_ku(?,?,?)', [$participant->event_id, $participant->race_id, $participant->category_rule_id]);
        return response()->json($data);

        // broadcast(new MyEvent($participant));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
