<?php

namespace App\Http\Controllers\API;

use App\Club;
use App\EventRace;
use App\Http\Controllers\Controller;
use App\Member;
use App\Participant;
use App\Race;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventParticipantController extends Controller
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
        $participant = new Participant;
        $participant->old_event = $request->old_event;
        $participant->old_race = $request->old_race;
        $participant->old_best_time = $request->o_best_time;
        $participant->join_date = date("Y-m-d");

        $participant->club_id = $request->club['id'];
        $participant->member_id = $request->member['id'];
        $participant->race_id = $request->race['id'];
        $participant->event_id = $request->event_id;
        $participant->category_rule_id = $request->rule_id;
        $participant->valid_payment = $request->valid_payment;

        $participant->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $participant = Participant::with('member:id,name', 'club:id,name', 'race:id,pure_race_id', 'race.pureRaces:id,name', 'rule:id,name')->where('event_id', $id)->get();
        return response()->json($participant);
    }

    public function getClubMember($id)
    {
        if (Auth::user()->isAdmin()) {
            $club = Club::with('members:id,name,club_id,born_date,gender')->select('id', 'name')->where('valid', 1)->get();
            return response()->json($club);
        } else {
            $club = Club::with('members:id,name,club_id,born_date,gender')->select('id', 'name')->where('valid', 1)->where('user_id', Auth::user()->id)->get();
        }
        return response()->json($club)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
    public function getRace($id, $member_id)
    {
        $member = Member::find($member_id);
        $bday = new DateTime($member->born_date); // Your date of birth
        $today = new DateTime(date('m.d.y'));
        $diff = $today->diff($bday);
        $age = $diff->y;
        $race = EventRace::with('pureRaces:name,id', 'rules:rules.id,name,min_age,max_age')->where('event_id', $id)->whereHas('rules', function ($query) use ($age) {
            $query->where('min_age', '<=', $age);
            $query->where('max_age', '>=', $age);
        })->select('id', 'pure_race_id')->whereNotIn('id', function ($query) use ($member_id, $id) {
            $query->select('race_id')->from('participants')->where('member_id', $member_id)->where('event_id', $id)->where('deleted_at', null);
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
        $participant = Participant::find($id);
        $participant->delete();
        return 204;
    }
}
