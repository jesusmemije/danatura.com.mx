@extends('admin.layout.app')

@section('content')

<div class="col-md-12">

  <div class="card shadow"> 

    @section('pagina-actual','Listado de publicaciones')
    @section('breadcumb')
      <ul class="breadcrumb">
        <li style="color:#F79860" class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Publicaciones</a></li>
        <li class="breadcrumb-item active">Listado</li>
      </ul>
      <a href="{{route('blogs.create')}}" style="background:#F79860" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i>Nueva publicación</a>
    @endsection
    
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">

          <thead>
            <tr>
              <th>Título</th>
              <th>Autor</th>
              <th>Fecha</th>
              <th>Estatus</th>
              <th class="text-center">Ver</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>

          <tbody>

            @foreach($blogs as $blog)

            <tr>
              <td>{{$blog->titulo}}</td>
              <td>{{$blog->autor}}</td>
              <td>{{$blog->getDateAdminList( $blog->created_at )}}</td>
              <td>
                @php
                    echo $blog->estatus == 'publicada' ? '<span class="badge badge-success">Publicada</span>' : '<span class="badge badge-warning">Pendiente</span>';
                @endphp
              </td>
              <td class="text-center">
                  <a class='btn btn-info btn-sm redondo ie' data-toggle="modal" data-target="#idModal-{{ $blog->id }}">
                    <i class='fa fa-eye'></i>
                  </a>
              </td>
              <td class="text-center">
                <a class="btn btn-warning btn-sm redondo" href="{{ url('admin/blogs/'.$blog->id.'/edit ') }}">
                  <i class="fa fa-edit"></i>
                </a>
                <a class="btn btn-sm btn-danger btn-circle shadow-sm redondo" type="submit" href="{{ url('admin/blogs/'.$blog->id) }}" onclick="return confirm('¿Seguro que desea eliminarlo?')">
                  <i class="fas fa-trash fa-sm text-white-50"></i>
                </a>
              </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="idModal-{{ $blog->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Preview - {{ $blog->titulo }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    @php
                        echo $blog->contenido;
                    @endphp
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>

            @endforeach

          </tbody>
        </table>

      </div>
    </div>

  </div>

</div>

@endsection
@section('scripts')

<!-- Page level plugins -->
<script src="{{asset('admin_assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('admin_assets/js/demo/datatables-demo.js')}}"></script>


@endsection