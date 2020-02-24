@extends('adminlte::page')

@section('content_header')
    
@stop

@section('content')
 <div class="card col-md-6 col-sm-12 mx-auto">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Profil Klub</p>
                @if (session('error'))
<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif
@if (session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif
            <form action="{{route('u_profile')}}" method="post">
                       @csrf
    @method('POST')
              <div class="row">
                  <div class="col-md-4">
                      <span>Nama Club</span>
                  </div>
                  <div class="col-md-8">
                 <label>{{Auth::user()->club->name}}</label>  
                  </div>
              </div>
               <div class="row">
                  <div class="col-md-4">
                      <span>Alamat</span>
                  </div>
                  <div class="col-md-8">
                <div class="input-group mb-3">
                <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" required value="{{Auth::user()->club->address}}" placeholder="Alamat"/>
                        
                        @if ($errors->has('address'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div> 
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-4">
                      <span>Kota</span>
                  </div>
                  <div class="col-md-8">
                <div class="input-group mb-3">
                <input type="text" name="city" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" required value="{{Auth::user()->club->city}}" placeholder="Kota"/>
                        
                        @if ($errors->has('city'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div> 
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-4">
                      <span>Provinsi</span>
                  </div>
                  <div class="col-md-8">
                <div class="input-group mb-3">
                <input type="text" name="province" class="form-control {{ $errors->has('province') ? 'is-invalid' : '' }}" required value="{{Auth::user()->club->province}}" placeholder="Provinsi"/>
                        
                        @if ($errors->has('province'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div> 
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-4">
                      <span>PIC</span>
                  </div>
                  <div class="col-md-8">
                <div class="input-group mb-3">
                <input type="text" name="pic" class="form-control {{ $errors->has('pic') ? 'is-invalid' : '' }}" required value="{{Auth::user()->club->pic}}" placeholder="PIC"/>
                        
                        @if ($errors->has('pic'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('pic') }}</strong>
                            </span>
                        @endif
                    </div> 
                  </div>
              </div>
               <div class="row">
                  <div class="col-md-4">
                      <span>Nomor HP</span>
                  </div>
                  <div class="col-md-8">
                <div class="input-group mb-3">
                <input type="text" name="phone_number" class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" required value="{{Auth::user()->club->phone_number}}" placeholder="Nomor HP"/>
                        
                        @if ($errors->has('phone_number'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div> 
                  </div>
              </div>
              
     {{-- <div class="input-group mb-3">
                        <input type="password" name="current-password" class="form-control {{ $errors->has('current-password') ? 'is-invalid' : '' }}" placeholder="Password Lama">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('current-password'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('current-password') }}</strong>
                            </span>
                        @endif
                    </div> --}}
                
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                       Ubah Profil
                    </button>
                </form>
            </div>
        </div>
@stop
