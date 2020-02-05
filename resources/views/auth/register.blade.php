
@extends('layouts.default')


@section('content')
<div class="container">
    <div class=" mt-2">
    <h2>Form Pendaftaran</h2>
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

  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Klub</label>
    <div class="col-sm-10">
      <select class="custom-select" name="klub" >

           @foreach ($club as $item)
          <option value="{{$item->id}}" {{ old('klub' ) == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
     @endforeach
 
    </select>

    </div>
  </div>
  <div class="form-group row">
    <label for="Nama" class="col-sm-2 col-form-label" >Nama Member</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nama" id="t_nama" value="{{ old('nama') }}" required> 
    </div>
  </div>
  <div class="form-group row">
    <label for="Nama" class="col-sm-2 col-form-label" >Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="Tanggal" class="col-sm-2 col-form-label">Tanggal Lahir</label>
    <div class="col-sm-10">
      <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
    </div>
  </div>
    {{-- <div class="form-group row">
    <label for="Waktu" class="col-sm-2 col-form-label">Waktu Tercepat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="waktu" id="waktu" value="{{ old('waktu') }}") >
    </div>
  </div> --}}
    <div class="form-group row">
    <label for="Dokumen" class="col-sm-2 col-form-label">Dokumen</label>
   
    <div class="col-sm-10">
      <div class="input-group mb-3">
        
  <div class="custom-file">
    <input type="file" class="custom-file-input" name="dokumen" accept=".jpeg,.jpg,.png,application/pdf,.pdf"  id="f_upload" required>
    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
  </div>
  
</div>
<label for="upload" id="upload_info" class="text-muted">(extension:jpg,jpeg,png,pdf max-size:500KB)</label>
<label for="upload" id="upload_msg" class="text-danger"></label>
    </div>
  </div>
  <button class="btn btn-primary btn-md active" role="button" aria-pressed="true" type="submit">Simpan</button>
<a href="{{route('register')}}" class="btn btn-secondary btn-md active" role="button" aria-pressed="true">Batal</a>
</form>

</div>
@stop

@section('js')
<script type="text/javascript" src="{{ URL::asset('vendor/adminlte/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.mask.min.js') }}"></script>
    <script>
      $(document).ready(function() {
   $('#waktu').mask('00:00:000', {placeholder: "00:00:000"});
   bsCustomFileInput.init();

$('#f_upload').bind('change', function() {

  var msg=this.files[0].size > 1000000 ? "The file size is too big":""
  
$("#upload_msg").text(msg);
});
      
});

    </script>
@stop
