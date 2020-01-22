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
        <div class="panel-title">A Receber
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <a href="{{route('bill_receives.create')}}" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Adicionar
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
              <th>Status</th>
              <th>Editar</th>
              <th>Deletar</th>
            </tr>
          </thead>
          <tbody>
            @if($bill_receives->count() > 0)
              @foreach($bill_receives as $bill_receive)
                <tr>
                  <td class="v-align-middle">
                    <p>{{$bill_receive->date_launch}}</p>
                  </td>
                  <td class="v-align-middle">
                    <p>{{$bill_receive->name}}</p>
                  </td>
                  <td class="v-align-middle">
                    <p>{{$bill_receive->value}}</p>
                  </td>
                  <td class="v-align-middle">
                    <p>{{$bill_receive->category->name ?? ''}}</p>
                  </td>
                  <td class="v-align-middle">
                    <input type="checkbox" data-init-plugin="switchery" data-id="{{ $bill_receive->id }}" data-size="small" data-color="primary" {{$bill_receive->status == '1' ? "checked='checked'" : "" }} />
                  </td>
                  <td class="v-align-middle">
                    <a href="{{ route('bill_receives.edit', ['id' => $bill_receive->id]) }}" class="btn btn-success">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </td>
                  <td class="v-align-middle">
                    <form action="{{ route('bill_receives.destroy', ['id' => $bill_receive->id ]) }}" method="post">
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
        {{ $bill_receives->render() }}
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
$(function(){
  $("#tableWithDynamicRows").on("change", "input[type=checkbox]", function() {
    var id = $(this).data("id");

    if (id) {
      $.ajax({
        url: "{{ route('bill_receives.toggle') }}",
        data: {"_token": "{{ csrf_token() }}", "id": id},
        type: "post",
        dataType: "json",
        success: function (response) {
          if (response.status === 'success') {
            $('body').pgNotification({
              style: 'bar',
              message: response.message,
              position: 'top',
              timeout: 3000,
              type: 'success'
          }).show();
          }
        }
      });
    }
    
  });
});
</script>
@endsection
