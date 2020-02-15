<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participant = Participant::with('member:id,name')->with(['race' => function ($query) {
            $query->select('id', 'name', 'event_id')->with('event:id,name');
        }])->get();
        return response()->json($participant);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $participant = new Participant;
        $participant->join_date = $request->join_date;
        $participant->race_id = $request->race;
        $participant->member_id = $request->member;
        $participant->best_time = $request->best_time;
        $participant->line_number = $request->line_number;
        $participant->result = $request->result;

        $participant->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function show(Participant $participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->data;
        $participant = Participant::find($id);
        $participant->join_date = $data['join_date'];
        $participant->race_id = $data['race'];
        $participant->member_id = $data['member'];
        $participant->best_time = $data['best_time'];
        $participant->line_number = $data['line_number'];
        $participant->result = $data['result'];

        $participant->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partisipant = Participant::find($id);
        $partisipant->delete();
        return 204;
    }
}
