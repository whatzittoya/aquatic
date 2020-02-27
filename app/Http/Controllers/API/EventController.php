<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\EventRace;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::get();

        return response()->json($events);
    }
    public function showLock()
    {
        $events = Event::get();

        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event;
        $event->name = $request->name;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->save();
    }
    public function raceStore(Request $request)
    {
        $race = new EventRace();
        $race->event_id = $request->event_id;
        $race->race_id = $request->race_id;

        $race->save();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    public function generateMatch($id)
    {
        $data = DB::select('call prc_swm_gen_matches(?)', [$id]);
        return response()->json($data);
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
        //
        $data = $request->data;

        $event = Event::find($id);
        $event->name = $data['name'];
        $event->start_date = $data['start_date'];
        $event->end_date = $data['end_date'];
        $event->update();
    }

    public function raceUpdate(Request $request, $id)
    {
        //

        $race = EventRace::find($id);
        $race->event_id = $request->event_id;
        $race->race_id = $request->race_id;

        $race->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return 204;
    }
}
