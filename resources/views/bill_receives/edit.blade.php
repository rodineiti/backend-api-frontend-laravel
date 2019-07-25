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
          <li><a href="#" class="active">Contas a Receber</a>
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
        <div class="panel-title">Editar Conta a Receber
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <a href="{{route('bill_receives.index')}}" class="btn btn-primary btn-cons">Contas a Receber
            </a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-body">
        <form id="form-bill_receive" class="p-t-15" role="form" action="{{ route('bill_receives.update', ['id' => $bill_receive->id]) }}" method="post">
	        {{method_field('PUT')}}
			{{ csrf_field() }}
	      <div class="row">
          <div class="col-sm-6">
            <div class="form-group form-group-default">
              <label>Data de Lançamento</label>
             <input type="date" class="form-control" name="date_launch" id="date_launch" value="{{$bill_receive->date_launch}}" required>
            </div>
            @if ($errors->has('date_launch'))
                  <label id="position-error" class="error" for="position">{{ $errors->first('date_launch') }}</label>
              @endif
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group form-group-default">
              <label>Nome</label>
              <input type="text" name="name" id="name" placeholder="Nome" class="form-control" value="{{$bill_receive->name}}" required>
            </div>
            @if ($errors->has('name'))
                  <label id="position-error" class="error" for="position">{{ $errors->first('name') }}</label>
              @endif
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group form-group-default">
              <label>Valor</label>
              <input type="text" name="value" id="value" class="form-control" placeholder="0.000,00" value="{{$bill_receive->value}}" required>
            </div>
            @if ($errors->has('value'))
                  <label id="position-error" class="error" for="position">{{ $errors->first('value') }}</label>
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
  $('#form-bill_receive').validate();
})
</script>
@endsection