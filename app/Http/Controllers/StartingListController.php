<?php

namespace App\Http\Controllers;

use App\Exports\StartingListExport;
use App\Exports\ListMatchExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StartingListController extends Controller
{

    public function export_excel_slist($id)
    {
        return Excel::download(new StartingListExport($id), 'starting_list.xlsx');
    }
    public function export_excel_match($id)
    {
        return Excel::download(new ListMatchExport($id), 'list_match.xlsx');
    }
}
