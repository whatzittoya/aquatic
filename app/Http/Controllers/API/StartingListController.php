<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Participant;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::user()->isAdmin()) {
            $startinglist = Participant::leftJoin('payments', function ($join) use ($id) {
                $join->on('payments.club_id', '=', 'participants.club_id');
                $join->on('payments.event_id', '=', 'participants.event_id');
            })->where('participants.event_id', $id)->where('payments.verified', 1)->join('clubs', 'clubs.id', '=', 'participants.club_id')
                ->with('member:id,name,born_date,club_id,gender', 'member.clubs:id,name,city,province', 'race:id,pure_race_id,race_number', 'race.pureRaces:id,name')->select('participants.id', 'member_id', 'race_id', 'old_best_time')->orderBy('clubs.name')->get();
        } else {
            $startinglist = Participant::leftJoin('payments', function ($join) use ($id) {
                $join->on('payments.club_id', '=', 'participants.club_id');
                $join->on('payments.event_id', '=', 'participants.event_id');
            })->where('participants.event_id', $id)->where('payments.verified', 1)->join('clubs', 'clubs.id', '=', 'participants.club_id')
                ->with('member:id,name,born_date,club_id,gender', 'member.clubs:id,name,city,province', 'race:id,pure_race_id,race_number', 'race.pureRaces:id,name')->whereHas('member.clubs', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })->select('participants.id', 'member_id', 'race_id', 'old_best_time')->orderBy('clubs.name')->get();
        }
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
