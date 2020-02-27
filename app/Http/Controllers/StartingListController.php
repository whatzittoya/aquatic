<?php

namespace App\Http\Controllers;

use App\Exports\StartingListExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StartingListController extends Controller
{

    public function export_excel($id)
    {
        return Excel::download(new StartingListExport($id), 'starting_list.xlsx');
    }
}
