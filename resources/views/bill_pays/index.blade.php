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
          <li><a href="#" class="active">Contas a Pagar</a>
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
        <div class="panel-title">A Pagar
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <a href="{{route('bill_pays.create')}}" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Adicionar
            </a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-body">
        <table class="table table-hover demo-table-dynamic" id="tableWithDynamicRows">
          <thead>
            <tr>
              <th>Data Lançamento</th>
              <th>Nome</th>
              <th>Valor</th>
              <th>Categoria</th>
              <th>Editar</th>
              <th>Deletar</th>
            </tr>
          </thead>
          <tbody>
            @if($bill_pays->count() > 0)
              @foreach($bill_pays as $bill_pay)
                <tr>
                  <td class="v-align-middle">
                    <p>{{$bill_pay->date_launch}}</p>
                  </td>
                  <td class="v-align-middle">
                    <p>{{$bill_pay->name}}</p>
                  </td>
                  <td class="v-align-middle">
                    <p>{{$bill_pay->value}}</p>
                  </td>
                  <td class="v-align-middle">
                    <p>{{$bill_pay->category->name}}</p>
                  </td>
                  <td class="v-align-middle">
                    <a href="{{ route('bill_pays.edit', ['id' => $bill_pay->id]) }}" class="btn btn-success">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </td>
                  <td class="v-align-middle">
                    <form action="{{ route('bill_pays.destroy', ['id' => $bill_pay->id ]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger " onclick="return confirm('Confirma a exclusão da conta a receber?');"><i class="fa fa-trash-o"></i></button>
                    </form>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {{ $bill_pays->render() }}
      </div>
    </div>
    <!-- END PANEL -->
  </div>
  <!-- END CONTAINER FLUID -->
</div>
<!-- END PAGE CONTENT -->
@endsection
