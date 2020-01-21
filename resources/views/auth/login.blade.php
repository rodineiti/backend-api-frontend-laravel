@extends('layouts.login')

@section('content')
<!-- START Login Right Container-->
<div class="login-container bg-white">
    <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
      <img src="{{ asset('assets/img/logo.png') }}" alt="logo" data-src="{{ asset('assets/img/logo.png') }}" data-src-retina="{{ asset('assets/img/logo_2x.png') }}" width="78" height="22">
      <p class="p-t-35">Informe seus dados de acesso</p>
      
      @if($status = Session::get('status'))
        <div class="alert alert-info" role="alert">
          <button class="close" data-dismiss="alert"></button>
          {{ $status }}
        </div>
       @endif

      <!-- START Login Form -->
      <form id="form-login" class="p-t-15" role="form" action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        <!-- START Form Control-->
        <div class="form-group form-group-default">
          <label>E-mail</label>
          <div class="controls">
            <input type="text" name="email" placeholder="E-mail" class="form-control" value="{{ old('email') }}" required>            
          </div>          
        </div>
        @if ($errors->has('email'))
            <label id="position-error" class="error" for="position">{{ $errors->first('email') }}</label>
        @endif
        <!-- END Form Control-->
        <!-- START Form Control-->
        <div class="form-group form-group-default">
          <label>Senha</label>
          <div class="controls">
            <input type="password" class="form-control" name="password" placeholder="senha" required>
          </div>
        </div>
        @if ($errors->has('password'))
            <label id="position-error" class="error" for="position">{{ $errors->first('password') }}</label>
        @endif
        <!-- START Form Control-->
        <div class="row">
          <div class="col-md-6 no-padding">
            <div class="checkbox ">
              <input type="checkbox" value="1" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">Lembrar-me</label>
            </div>
          </div>
          <div class="col-md-6 text-right">
            <a class="text-info small" href="{{ route('password.request') }}">
                Esqueceu sua senha?
            </a>
          </div>
          <div class="col-md-6 text-right">
            <a class="text-info small" href="{{ route('register') }}">Criar Conta</a>
          </div>
        </div>
        <!-- END Form Control-->
        <button class="btn btn-primary btn-cons m-t-10" type="submit">Login</button>
      </form>      
      
    </div>
</div>
<!-- END Login Right Container-->
@endsection
