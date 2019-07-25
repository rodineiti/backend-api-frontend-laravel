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
          <li><a href="#" class="active">Categorias de Custo</a>
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
        <div class="panel-title">Categorias
        </div>
        <div class="pull-right">
          <div class="col-xs-12">
            <a href="{{route('categories.create')}}" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Adicionar
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
              <th>Data Cadastro</th>
              <th>Editar</th>
              <th>Deletar</th>
            </tr>
          </thead>
          <tbody>
            @if($categories->count() > 0)
              @foreach($categories as $category)
                <tr>
                  <td class="v-align-middle">
                    <p>{{$category->name}}</p>
                  </td>
                  <td class="v-align-middle">
                    <p>{{$category->created_at}}</p>
                  </td>
                  <td class="v-align-middle">
                    <a href="{{ route('categories.edit', ['id' => $category->id]) }}" class="btn btn-success">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </td>
                  <td class="v-align-middle">
                    <form action="{{ route('categories.destroy', ['id' => $category->id ]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger " onclick="return confirm('Confirma a exclusão da categoria?');"><i class="fa fa-trash-o"></i></button>
                    </form>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {{ $categories->render() }}
      </div>
    </div>
    <!-- END PANEL -->
  </div>
  <!-- END CONTAINER FLUID -->
</div>
<!-- END PAGE CONTENT -->
@endsection
