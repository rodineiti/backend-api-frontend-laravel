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
          <li><a href="#" class="active">DashBoard</a>
          </li>
        </ul>
        <!-- END BREADCRUMB -->
      </div>
    </div>
  </div>
  <!-- END JUMBOTRON -->
  <!-- START CONTAINER FLUID -->
  <div class="container-fluid container-fixed-lg">
    <!-- BEGIN PlACE PAGE CONTENT HERE -->

    @if($categoriesPay || $categoriesReceive)
    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg">
      
      <div class="row">
          <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Gráfico
                </h3>
            </div>
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
                      <h2>Totais no período: De {{$dateStart}} à {{$dateEnd}}</h2>
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
                                  <span class="glyphicon {{ $statement["type"] == "in" ? "glyphicon-plus" : "glyphicon-minus" }}">
                                      {{ $statement["date_launch"] }} - {{ $statement["name"] }}
                                  </span>
                              </h4>
                              <h4 class="text-right">
                                  <span class="label {{ $statement["type"] == "in" ? "label-success" : "label-danger" }}">
                                     R$ {{ $statement["type"] == "in" ? "+" : "-" }} {{ $statement["value"] }}
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
    <!-- END PLACE PAGE CONTENT HERE -->
  </div>
  <!-- END CONTAINER FLUID -->
</div>
<!-- END PAGE CONTENT -->
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/chartsjs/Chart.min.js') }}" type="text/javascript"></script>
<script>
$(function()
{
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
