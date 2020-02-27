<?php

namespace App\Exports;

use App\Participant;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class StartingListExport implements FromView
{
    public function  __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $startinglist = Participant::where('event_id', $this->id)
            ->join('members', 'members.id', '=', 'participants.member_id')
            ->with('member:id,name,born_date,club_id,gender', 'member.clubs:id,name,city,province', 'race:id,pure_race_id,race_number', 'race.pureRaces:id,name')->select('participants.id', 'member_id', 'race_id', 'old_best_time', 'members.name')->orderBy('members.name')->get();
        return view('export.startingList', [
            'starting_list' =>  $startinglist
        ]);
    }
}
