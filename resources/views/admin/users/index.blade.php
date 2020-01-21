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
        <div class="panel-title">Usuários
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <a href="{{route('users.create')}}" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Adicionar
            </a>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-body">
        <table class="table table-hover demo-table-dynamic" id="tableWithDynamicRows">
          <thead>
            <tr>
              <th>Nome</th>
              <th>E-mail</th>
              <th>Status</th>
              <th>Data Cadastro</th>
              <th>Editar</th>
              <th>Deletar</th>
            </tr>
          </thead>
          <tbody>
            @if($users->count() > 0)
              @foreach($users as $user)
                <tr>
                  <td class="v-align-middle">
                    <p>{{$user->name}}</p>
                  </td>
                  <td class="v-align-middle">
                    <p>{{$user->email}}</p>
                  </td>
                  <td class="v-align-middle">
                    <input type="checkbox" data-init-plugin="switchery" data-id="{{ $user->id }}" data-size="small" data-color="primary" {{$user->status === '1' ? "checked='checked'" : "" }} />
                  </td>
                  <td class="v-align-middle">
                    <p>{{$user->created_at}}</p>
                  </td>
                  <td class="v-align-middle">
                    <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-success">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </td>
                  <td class="v-align-middle">
                    <form action="{{ route('users.destroy', ['id' => $user->id ]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger " onclick="return confirm('Confirma a exclusão do usuário?');"><i class="fa fa-trash-o"></i></button>
                    </form>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {{ $users->render() }}
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
        url: "{{ route('users.toggle') }}",
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
