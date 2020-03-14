<?php

namespace App\Http\Controllers\API;

use App\Club;
use App\EventRace;
use App\Http\Controllers\Controller;
use App\Member;
use App\Participant;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $participant->pure_race_id = $request->race['pure_race_id'];
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

        if (Auth::user()->isAdmin()) {
            $participant = Participant::leftJoin('payments', function ($join) use ($id) {
                $join->on('payments.id', DB::raw('(select max(p.id) from payments as p where p.event_id=participants.event_id and p.club_id=participants.club_id )'));
            })->with('member:id,name,gender,born_date', 'club:id,name', 'club.members', 'race:id,pure_race_id', 'race.pureRaces:id,name', 'race.rules', 'rule:id,name')->where('participants.event_id', $id)->select('participants.*', 'payments.verified as valid_payment')->get();
        } else {
            $participant = Participant::leftJoin('payments', function ($join) use ($id) {
                $join->on('payments.club_id', '=', 'participants.club_id');
                $join->on('payments.event_id', '=', 'participants.event_id');
            })->with('member:id,name,gender,born_date', 'club:id,name',  'club.members', 'race:id,pure_race_id', 'race.pureRaces:id,name', 'race.rules', 'rule:id,name')->whereHas('club', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->where('participants.event_id', $id)->select('participants.*', 'payments.verified as valid_payment')->get();
        }

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

    public function getMember($id, $club_id)
    {

        $member = Member::where('club_id', $club_id)->get();
        return response()->json($member);
    }
    public function getRace($id, $member_id, $participant_id = null)
    {
        $member = Member::find($member_id);
        $bday = new DateTime($member->born_date); // Your date of birth
        $today = new DateTime(date('m.d.y'));
        // $diff = $today->diff($bday);
        // $age = $diff->y;
        $age = $today->format('Y') - $bday->format('Y');
        $race = EventRace::with('pureRaces:name,id', 'rules:rules.id,name,min_age,max_age')->where('event_id', $id)->where('gender', $member->gender)->whereHas('rules', function ($query) use ($age) {
            $query->where('min_age', '<=', $age);
            $query->where('max_age', '>=', $age);
        })->select('id', 'pure_race_id')->whereNotIn('id', function ($query) use ($member_id, $id) {
            $query->select('race_id')->from('participants')->where('member_id', $member_id)->where('event_id', $id)->where('deleted_at', null);
        })->get();
        if ($participant_id > 0) {
            $participant = Participant::find($participant_id);
            $current_race = EventRace::with('pureRaces:name,id', 'rules:rules.id,name,min_age,max_age')->where('id', $participant->race_id)->select('id', 'pure_race_id')->first();
            $race->push($current_race);
        }

        return response()->json($race);
    }


    public function getLastRecord($member_id, $pure_race_id)
    {
        $data = DB::select('call prc_get_last_record(?,?)', [$member_id, $pure_race_id]);
        return response()->json($data);
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
        $participant->old_event = $data['old_event'];
        $participant->old_race = $data['old_race'];
        // $participant->join_date = date("Y-m-d");

        $participant->club_id = $data['club']['id'];
        $participant->member_id = $data['member']['id'];
        $participant->race_id = $data['race']['id'];
        $participant->event_id = $data['event_id'];
        $participant->category_rule_id = $data['rule_id'];
        $participant->valid_payment = $data['valid_payment'];

        $participant->update();
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
