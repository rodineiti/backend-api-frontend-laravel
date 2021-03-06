@extends('layouts.dashboard')

@section('content')
<!-- START PAGE CONTENT -->
<div class="content ">
  <!-- START JUMBOTRON -->
  <div class="jumbotron" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
      <div class="inner">
        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
          <li>
            <p>Pages</p>
          </li>
          <li><a href="#" class="active">Usuários</a>
          </li>
        </ul>
        <!-- END BREADCRUMB -->
      </div>
    </div>
  </div>
  <!-- END JUMBOTRON -->
  <!-- START CONTAINER FLUID -->
  <div class="container-fluid container-fixed-lg">
    <!-- START PANEL -->
    <div class="panel panel-transparent">
      <div class="panel-heading">
        <div class="panel-title">Editar Usuário
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <a href="{{route('users.index')}}" class="btn btn-primary btn-cons">Usuários
            </a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-body">
        <form id="form-user" class="p-t-15" role="form" action="{{ route('users.update', ['id' => $user->id]) }}" method="post">
	        {{method_field('PUT')}}
			   {{ csrf_field() }}
	      <div class="row">
	        <div class="col-sm-6">
	          <div class="form-group form-group-default">
	            <label>Nome</label>
	            <input type="text" name="name" id="name" placeholder="Nome" class="form-control" value="{{ $user->name }}" required>
	          </div>
	          @if ($errors->has('name'))
	                <label id="position-error" class="error" for="position">{{ $errors->first('name') }}</label>
	            @endif
	        </div>
	      </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group form-group-default">
              <label>E-mail</label>
              <input type="text" name="email" id="email" placeholder="E-mail" class="form-control" value="{{ $user->email }}" required>
            </div>
            @if ($errors->has('email'))
                  <label id="position-error" class="error" for="position">{{ $errors->first('email') }}</label>
              @endif
          </div>
        </div>
	      <button class="btn btn-primary btn-cons m-t-10" type="submit">Atualizar</button>
	    </form>
      </div>
    </div>
    <!-- END PANEL -->
  </div>
  <!-- END CONTAINER FLUID -->
</div>
<!-- END PAGE CONTENT -->
@endsection

@section('scripts')
<script>
$(function()
{
  $('#form-user').validate();
})
</script>
@endsection