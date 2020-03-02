
@extends('layouts.default')


@section('content')
<div class="container">
    <div class=" mt-2">
    <h2>Form Pendaftaran Klub</h2>
    </div>
    <hr>

<ul>
@if ($errors->any())
     @foreach ($errors->all() as $error)
         <li><label class="text-danger">{{$error}}</label></li>
     @endforeach
 @endif
 @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
</ul>

<form action="{{route('register')}}" method="POST" enctype="multipart/form-data">
   @csrf
    @method('POST')


  <div class="row">
    <label for="Nama" class="col-sm-2 col-form-label" >Nama Klub</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nama" id="t_nama" value="{{ old('nama') }}" required> 
    </div>
  </div>
  <div class="row">
    <label for="Nama" class="col-sm-2 col-form-label" >Alamat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="alamat" id="t_alamat" value="{{ old('alamat') }}" required> 
    </div>
  </div>
  <div class="row">
    <label for="Nama" class="col-sm-2 col-form-label" >Kota</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="kota" id="t_kota" value="{{ old('kota') }}" required> 
    </div>
  </div>
  <div class="row">
    <label for="Nama" class="col-sm-2 col-form-label" >Provinsi</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="provinsi" id="t_provinsi" value="{{ old('provinsi') }}" required> 
    </div>
  </div>
  <div class="row">
    <label for="Nama" class="col-sm-2 col-form-label" >PIC</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="pic" id="t_pic" value="{{ old('pic') }}" required> 
    </div>
  </div>
    <div class="row">
    <label for="Nama" class="col-sm-2 col-form-label" >No HP</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required> 
    </div>
  </div>
  <div class="row">
    <label for="Nama" class="col-sm-2 col-form-label" >Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
    </div>
  </div>
  {{-- <div class="row">
    <label for="Tanggal" class="col-sm-2 col-form-label">Tanggal Lahir</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
    </div>
  </div> --}}
    {{-- <div class="row">
    <label for="Waktu" class="col-sm-2 col-form-label">Waktu Tercepat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="waktu" id="waktu" value="{{ old('waktu') }}") >
    </div>
  </div> --}}

  <button class="btn btn-primary btn-md active" role="button" aria-pressed="true" type="submit">Simpan</button>
<a href="{{route('register')}}" class="btn btn-secondary btn-md active" role="button" aria-pressed="true">Batal</a>
</form>

</div>
@stop

@section('js')
<script type="text/javascript" src="{{ URL::asset('vendor/adminlte/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.mask.min.js') }}"></script>
    <script>
     

    </script>
@stop
