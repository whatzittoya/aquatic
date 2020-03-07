@extends('adminlte::page')
@include('includes.vue')
@section('content_header')
 <link rel="icon" href="{{ URL::asset('/favicons/favicon.ico') }}" type="image/x-icon"/>   
@stop

@section('content')
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
 @if ( Auth::user()->isAdmin())
 <div id="app">
 </div>
 @else
<h2>Sorry, you don't have access on this page</h2>
 @endif
@stop
