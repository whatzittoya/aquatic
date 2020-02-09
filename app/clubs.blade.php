@extends('adminlte::page')
@include('includes.vue')


@section('content_header')
    <h1 class="m-0 text-dark">Clubs</h1>
@stop

@section('content')
@can('admin')
 <div id="app">
 </div>
 @elsecan('club')
 noooo
 @endcan

@stop


