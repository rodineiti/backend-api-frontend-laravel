@extends('layouts.register')

@section('content')
<div class="row row-sm-height">
  <div class="col-sm-12 col-sm-height col-middle">
    <h1>Controle de finanças pessoal - Registro</h1>
    <h3>Tenha controle sobre suas finanças</h3>
    <form id="form-register" class="p-t-15" role="form" action="{{ url('/register') }}" method="post">
        {{ csrf_field() }}
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group form-group-default">
            <label>Nome</label>
            <input type="text" name="name" placeholder="Informe seu nome" class="form-control" required>
          </div>
          @if ($errors->has('name'))
                <label id="position-error" class="error" for="position">{{ $errors->first('name') }}</label>
            @endif
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group form-group-default">
            <label>E-mail</label>
            <input type="email" name="email" placeholder="Informe seu e-mail" class="form-control" required>
          </div>
          @if ($errors->has('email'))
                <label id="position-error" class="error" for="position">{{ $errors->first('email') }}</label>
            @endif
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group form-group-default">
            <label>Senha</label>
            <input type="password" name="password" placeholder="Mínimo de 6 caracteres" class="form-control" required>
          </div>
            @if ($errors->has('password'))
                <label id="position-error" class="error" for="position">{{ $errors->first('password') }}</label>
            @endif
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group form-group-default">
            <label>Confirmar Senha</label>
            <input type="password" name="password_confirmation" placeholder="Mínimo de 6 caracteres" class="form-control" required>
          </div>
        </div>
      </div>
      <div class="row m-t-10">
        <div class="col-md-12 text-right">
          <a href="{{ route('login') }}" class="text-info small">Login</a>
        </div>
      </div>
      <button class="btn btn-primary btn-cons m-t-10" type="submit">Criar Conta</button>
    </form>
  </div>
</div>
@endsection
