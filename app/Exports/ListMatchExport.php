<?php

namespace App\Exports;

use App\Participant;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;


class ListMatchExport implements FromView
{
    public function  __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {

        $startinglist = DB::select('CALL prc_get_startinglist(?)', [$this->id]);
        return view('export.ListMatch', [
            'starting_list' =>  $startinglist
        ]);
    }
}
