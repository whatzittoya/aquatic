@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">Events</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">@json($events);</p>
                </div>
            </div>
        </div>
    </div>
@stop
