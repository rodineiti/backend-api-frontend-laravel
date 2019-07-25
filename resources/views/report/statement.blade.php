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
          <li><a href="#" class="active">Extrato por Perído
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
        <div class="panel-title">Extrato por Perído
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <a href="{{route('home')}}" class="btn btn-primary btn-cons">Dashboard
            </a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-body">
        <form id="form-period" class="p-t-15" role="form" action="{{ route('post.statement') }}" method="post">
	        {{ csrf_field() }}
	      <div class="row">
          <div class="col-sm-6">
            <div class="form-group form-group-default">
              <label>Data Início</label>
             <input type="date" class="form-control" name="dateStart" id="dateStart" required>
            </div>
            @if ($errors->has('dateStart'))
                  <label id="position-error" class="error" for="position">{{ $errors->first('dateStart') }}</label>
              @endif
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group form-group-default">
              <label>Data Final</label>
             <input type="date" class="form-control" name="dateEnd" id="dateEnd" required>
            </div>
            @if ($errors->has('dateEnd'))
                  <label id="position-error" class="error" for="position">{{ $errors->first('dateEnd') }}</label>
              @endif
          </div>
        </div>
	      <button class="btn btn-primary btn-cons m-t-10" type="submit">Consultar</button>
	    </form>
      </div>
    </div>
    <!-- END PANEL -->
  </div>
  <!-- END CONTAINER FLUID -->
  
  @if($statements)
  <!-- START CONTAINER FLUID -->
  <div class="container-fluid container-fixed-lg">
    
    <div class="row">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Extrato
                </h3>
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <h2>Totais no período</h2>
                    <p>
                        <strong>Recebidos:</strong>
                        R$ {{ $total_receives }}
                    </p>
                    <p>
                        <strong>Pagos:</strong>
                        R$ {{ $total_pays }}
                    </p>
                    <p>
                        <strong>Total:</strong>
                        R$ {{ ($total_receives - $total_pays) }}
                    </p>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    <div class="list-group">
                        @foreach($statements as $statement)
                          
                          <a href="#" class="list-group-item">
                              <h4 class="list-group-item-heading">
                                  <span class="glyphicon glyphicon-{{ (isset($statement['category_id'])) ? 'minus' : 'plus' }}">
                                      {{ $statement['date_launch'] }} - {{ $statement['name'] }}
                                  </span>
                              </h4>
                              <h4 class="text-right">
                                  <span class="label label-{{ (isset($statement['category_id'])) ? 'danger' : 'success' }}">
                                     R$ {{ (isset($statement['category_id'])) ? '-' : '' }} {{ $statement['value'] }}
                                  </span>
                              </h4>
                              <div class="clearfix"></div>
                          </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

  </div>
  <!-- END CONTAINER FLUID -->
  @endif

</div>
<!-- END PAGE CONTENT -->
@endsection

@section('scripts')
<script>
$(function()
{
  $('#form-period').validate();
})
</script>
@endsection