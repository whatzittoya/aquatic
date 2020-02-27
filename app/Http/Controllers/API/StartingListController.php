<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Participant;

class StartingListController extends Controller
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
        $startinglist = Participant::where('event_id', $id)->join('members', 'members.id', '=', 'participants.member_id')
            ->with('member:id,name,born_date,club_id,gender', 'member.clubs:id,name,city,province', 'race:id,pure_race_id,race_number', 'race.pureRaces:id,name')->select('participants.id', 'member_id', 'race_id', 'old_best_time', 'members.name')->orderBy('members.name')->get();
        return response()->json($startinglist);
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
        //
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
