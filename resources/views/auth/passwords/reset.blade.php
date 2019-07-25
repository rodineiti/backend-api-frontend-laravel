@extends('layouts.register')

@section('content')

<div class="row row-sm-height">
  <div class="col-sm-12 col-sm-height col-middle">
    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" data-src="{{ asset('assets/img/logo.png') }}" data-src-retina="{{ asset('assets/img/logo_2x.png') }}" width="78" height="22">
    <h3>Resetar Senha</h3>
    @if(count($errors))
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
        </div>
    @endif
    <form id="form-password" class="p-t-15" role="form" action="{{ route('password.request') }}" method="post">
        {{ csrf_field() }}
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group form-group-default">
            <label>E-mail</label>
            <input type="email" name="email" placeholder="We will send loging details to you" class="form-control" required>
          </div>
          @if ($errors->has('email'))
                <label id="position-error" class="error" for="position">{{ $errors->first('email') }}</label>
            @endif
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group form-group-default">
            <label>Nova Senha</label>
            <input type="password" name="password" placeholder="Minimum of 6 Charactors" class="form-control" required>
          </div>
            @if ($errors->has('password'))
                <label id="position-error" class="error" for="position">{{ $errors->first('password') }}</label>
            @endif
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group form-group-default">
            <label>Confirmar Nova Senha</label>
            <input type="password" name="password_confirmation" placeholder="Minimum of 6 Charactors" class="form-control" required>
          </div>
        </div>
      </div>
      <button class="btn btn-primary btn-cons m-t-10" type="submit">Resetar Senha</button>
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
