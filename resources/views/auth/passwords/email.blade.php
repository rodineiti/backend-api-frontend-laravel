@extends('layouts.login')

@section('content')
<div class="login-container bg-white">
    <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
      <img src="{{ asset('assets/img/logo.png') }}" alt="logo" data-src="{{ asset('assets/img/logo.png') }}" data-src-retina="{{ asset('assets/img/logo_2x.png') }}" width="78" height="22">
      <p class="p-t-35">Resetar Senha</p>
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
      <!-- START Login Form -->
      <form id="form-reset" class="p-t-15" role="form" action="{{ route('password.email') }}" method="post">
        {{ csrf_field() }}
        <!-- START Form Control-->
        <div class="form-group form-group-default">
          <label>Informe seu e-mail</label>
          <div class="controls">
            <input type="text" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}" required>            
          </div>          
        </div>
        @if ($errors->has('email'))
            <label id="position-error" class="error" for="position">{{ $errors->first('email') }}</label>
        @endif
        <!-- END Form Control-->
        <!-- END Form Control-->
        <button class="btn btn-primary btn-cons m-t-10" type="submit">Enviar link para resetar senha</button>
      </form>
      <br>
      <div class="row">
          <div class="col-md-12 text-right">
            <a class="text-info small" href="{{ route('login') }}">
                Login
            </a>
          </div>
          <div class="col-md-12 text-right">
            <a class="text-info small" href="{{ route('register') }}">Criar Conta</a>
          </div>
      </div>
      
    </div>
</div>
@endsection
