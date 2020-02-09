@extends('adminlte::page')

@section('content_header')
    
@stop

@section('content')
 <div class="card col-md-6 col-sm-12 mx-auto">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ubah Password</p>
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
            <form action="{{route('change_pass')}}" method="post">
                       @csrf
    @method('POST')
                 
     <div class="input-group mb-3">
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
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="new-password" class="form-control {{ $errors->has('new-password') ? 'is-invalid' : '' }}" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('new-password'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('new-password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="new-password-confirm" class="form-control {{ $errors->has('new-password-confirm') ? 'is-invalid' : '' }}"
                               placeholder="Ulangi Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('new-password-confirm'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('new-password-confirm') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        {{ trans('adminlte::adminlte.reset_password') }}
                    </button>
                </form>
            </div>
        </div>
@stop
