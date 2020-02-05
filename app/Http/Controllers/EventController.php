<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::paginate(5);
        return view('admin.event', ['events' => $events]);
    }
}
