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
          <li><a href="#" class="active">Gráfico por Período
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
        <div class="panel-title">Gráfico por Perído
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
        <form id="form-period" class="p-t-15" role="form" action="{{ route('post.charts') }}" method="post">
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

  @if($categoriesPay || $categoriesReceive)
  <!-- START CONTAINER FLUID -->
  <div class="container-fluid container-fixed-lg">
    
    <div class="row">
        <div class="panel panel-primary">
            <div class="row">
              <div class="col-sm-6 text-center">
                  <fieldset>
                    <legend>Pagamentos Pagos</legend>
                    <canvas id="billPay" width="400" height="200"></canvas>
                  </fieldset>
                </div>
                <div class="col-sm-6 text-center">
                  <fieldset>
                    <legend>Pagamentos Recebidos</legend>
                    <canvas id="billReceive" width="400" height="200"></canvas>
                  </fieldset>
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
<script src="{{ asset('assets/plugins/chartsjs/Chart.min.js') }}" type="text/javascript"></script>
<script>
$(function()
{
  $('#form-period').validate();
  var poolColors = function (a) {
      var pool = [];
      for(i=0;i<a;i++){
          pool.push(dynamicColors());
      }
      return pool;
  }
  var dynamicColors = function() {
      var r = Math.floor(Math.random() * 255);
      var g = Math.floor(Math.random() * 255);
      var b = Math.floor(Math.random() * 255);
      return "rgb(" + r + "," + g + "," + b + ")";
  }
  function pay() {
    var ctx = document.getElementById("billPay").getContext('2d');
    var total = <?php echo count($categoriesPay); ?>;
    var billPay = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [
              <?php foreach ($categoriesPay as $value) {
                    echo "'$value->name',";
              } ?>
            ],
            datasets: [{
                label: '# of Votes',
                data: [
                  <?php foreach ($categoriesPay as $value) {
                    echo $value->value . ",";
                  } ?>
                ],
                backgroundColor: poolColors(total),
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
  }

  function receive() {
    var ctx = document.getElementById("billReceive").getContext('2d');
    var total = <?php echo count($categoriesReceive); ?>;
    var billReceive = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [
              <?php foreach ($categoriesReceive as $value) {
                    echo "'$value->name',";
              } ?>
            ],
            datasets: [{
                label: '# of Votes',
                data: [
                  <?php foreach ($categoriesReceive as $value) {
                    echo $value->value . ",";
                  } ?>
                ],
                backgroundColor: poolColors(total),
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
  }

  pay();
  receive();
});
</script>
@endsection