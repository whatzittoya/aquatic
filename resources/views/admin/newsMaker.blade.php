<!DOCTYPE html>

@extends('adminlte::page')
@include('includes.vue')
@section('content_header')
    
@stop

@section('content')
 @if ( Auth::user()->isAdmin())
 <div id="app">
 </div>
 @else
<h2>Sorry, you don't have access on this page</h2>
 @endif
@stop   

