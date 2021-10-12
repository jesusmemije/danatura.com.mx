@extends('front.layout.app')

@section('title')
    Historial de Pedidos
@endsection

@section('styles')
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />

    <style>

      .principal{
        background:#FFEFD6;
        padding-left:6%;
        padding-right:6%;
      }
      .contenido{
        color: #73482C;
        font-family:AmasisMTStd-Bold;
      }
      .card{
        border: 0px !important;
      }
      .card-header{
        border: 0px !important;
      }
      .direccines{
        position: relative;
      }

    </style>
@endsection

@section('content')

    <div class="principal col-sm-12 align-content-center">
        <div class="contenido container-fluid" style="padding-top:5%; padding-bottom:5%; text-align:justify;">
            @if ( session('mensaje') )
                <div class="alert alert-success" role="alert">
                    {{ session('mensaje') }}
                </div>
            @endif
            <div class="col-lg-11" style="background: #fafafa;">
                <h2>Mis Direcciones</h2>
                <hr>
                <div class="col-lg-11">
                    <table class="table table-responsive">
                        <tbody>
                            @foreach ($datosdirection as $resul)
                            <tr>
                                <td colspan="" rowspan="" headers="">
                                    <img height="45" src="{{asset('assets/icons/ICON7-13.png')}}">
                                </td>
                                <td style="width: 650px;">
                                    <label>{{$resul->empresa}}</label>
                                    <br>
                                    <p style="font-family: arial;">
                                    {{$resul->direccion1}}, {{$resul->localidad}}, {{$resul->region}}. Código postal: {{$resul->cp}}  
                                    </p>
                                </td>
                                <td>
                                    <button class="btn  btn-sm" style="border-color: yellow; border-width: 2px;" data-nombre="{{$resul->nombre}}" data-apellidos="{{$resul->apellidos}}" data-empresa="{{$resul->empresa}}" data-pais="{{$resul->pais}}" data-direccion1="{{$resul->direccion1}}" data-direccion2="{{$resul->direccion2}}" data-localidad="{{$resul->localidad}}" data-region="{{$resul->region}}" data-cp="{{$resul->cp}}" data-telefono="{{$resul->telefono}}" data-email="{{$resul->email}}" data-rfc="{{$resul->rfc}}" data-referencia="{{$resul->referencia}}" data-id="{{$resul->id}}" data-toggle="modal" data-target="#editDirection">Editar <i class="fa fa-edit"></i></button>
                                    <a class="btn  btn-sm" style="border-color: red; border-width: 2px;" href="{{ url('/destroy_historial_pedidos/'.$resul->id)}}">Eliminar <i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a data-toggle="modal" data-target="#addModal" href="#" style="color: green; text-decoration: underline;">Agregar nueva dirección</a>
                </div>
            </div>
            <br>
            <div class="col-lg-11" style="background: #fafafa;">
                <h2>Historial de Pedidos</h2>
                <hr>
                <div>
                    <table class="table table-hover">
                        <thead>
                            <th>
                                <td>Cantidad</td>
                                <td>Total</td>
                                <td>Metodo</td>
                            </th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($historialPedido as $registros){
                            ?>
                            <tr>
                                <td><?php echo $registros->Producto ?></td>
                                <td><?php echo $registros->cantidad ?></td>
                                <td>$<?php echo $registros->preciototal ?> MXN</td>
                                <td><?php echo $registros->method ?></td>
                            </tr>
                            <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
                    {{ $historialPedido->links() }}
            </div>
        </div>
    </div>


    <div id="addModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agrega la nueva dirección</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('historial_pedidos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="background: #fafafa;">
                        <div class="pb-5">
                            <div class="row">
                                <div class="col">
                                        <input hidden type="text" id="dato_id" name="dato_id">
                                        <label for="">Nombre (Requerido)<sup class="supred">*</sup></label>
                                        <input required id="nombre" name="nombre" type="text" class="form-control" placeholder="">
                                </div>
                                <div class="col">
                                    <label for="">Apellidos (Requerido)<sup>*</sup></label>
                                    <input required id="apellidos" type="text" name="apellidos" class="form-control" placeholder="">
                                </div>
                            </div>
                            <label for="">Empresa (Opcional)</label>
                            <input id="empresa" type="text" class="form-control" name="empresa" placeholder="">

                            <label for="">País (Requerido)<sup>*</sup></sup></label>
                            <input id="pais" type="text" class="form-control" name="pais" placeholder="">

                            <label for="">Dirección de la calley número (Requerido)<sup>*</sup></label>
                            <input id="direccion1" type="text" class="form-control" name="direccion1"
                                placeholder="Dirección #1- número de la casa y nombre de la calle">
                            <br>
                            <input id="direccion2" type="text" class="form-control" name="direccion2"
                                placeholder="Continuación de la dirección">

                            <label for="">Localidad/Ciudad (Requerido)<sup>*</sup></label>
                            <input id="localidad" type="text" class="form-control" name="localidad">

                            <label for="">Región/Provincia (Requerido)<sup>*</sup></label>
                            <input id="region" type="text" class="form-control" name="region">

                            <label for="">Código Postal (Requerido)<sup>*</sup></label>
                            <input id="cp" type="text" class="form-control" name="cp">

                            <label for="">Teléfono/Celular (Requerido)<sup>*</sup></label>
                            <input id="telefono" type="text" class="form-control" name="telefono">

                            <label for="">Correo electrónico (Requerido)<sup>*</sup></label>
                            <input id="email" type="text" class="form-control" name="email" placeholder="">

                            <label for="">RFC (Opcional)</label>
                            <input id="rfc" type="text" class="form-control" name="rfc" placeholder="*En caso de requerir factura">

                            <label for="">Referencia (Opcional)</label>
                            <input id="referencia" type="text" class="form-control" name="referencia" placeholder="Referencia del lugar de envío del paquete">

                        </div>
                </div>
                            <div class="modal-footer" style="background: #fafafa;">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <input class="btn btn-primary" type="submit" value="Aceptar">
                            </div>
                </form>
            </div>
        </div>
    </div>


<div id="editDirection" class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agrega la nueva dirección</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('historial_pedidos.update','test') }}">
                {{ csrf_field() }}
                {{-- {{ method_field('PATCH') }} --}}
                <div class="modal-body" style="background: #fafafa;">
                        <div class="pb-5">
                            <div class="row">
                                <div class="col">
                                        <input hidden type="text" id="dato_id" name="dato_id">
                                        <label for="">Nombre (Requerido)<sup class="supred">*</sup></label>
                                        <input required id="edit_nombre" name="edit_nombre" type="text" class="form-control" placeholder="">
                                </div>
                                <div class="col">
                                    <label for="">Apellidos (Requerido)<sup>*</sup></label>
                                    <input required id="edit_apellidos" type="text" name="edit_apellidos" class="form-control" placeholder="">
                                </div>
                            </div>
                            <label for="">Empresa (Opcional)</label>
                            <input id="edit_empresa" type="text" class="form-control" name="edit_empresa" placeholder="">

                            <label for="">País (Requerido)<sup>*</sup></sup></label>
                            <input id="edit_pais" type="text" class="form-control" name="edit_pais" placeholder="">

                            <label for="">Dirección de la calley número (Requerido)<sup>*</sup></label>
                            <input id="edit_direccion1" type="text" class="form-control" name="edit_direccion1"
                                placeholder="Dirección #1- número de la casa y nombre de la calle">
                            <br>
                            <input id="edit_direccion2" type="text" class="form-control" name="edit_direccion2"
                                placeholder="Continuación de la dirección">

                            <label for="">Localidad/Ciudad (Requerido)<sup>*</sup></label>
                            <input id="edit_localidad" type="text" class="form-control" name="edit_localidad">

                            <label for="">Región/Provincia (Requerido)<sup>*</sup></label>
                            <input id="edit_region" type="text" class="form-control" name="edit_region">

                            <label for="">Código Postal (Requerido)<sup>*</sup></label>
                            <input id="edit_cp" type="text" class="form-control" name="edit_cp">

                            <label for="">Teléfono/Celular (Requerido)<sup>*</sup></label>
                            <input id="edit_telefono" type="text" class="form-control" name="edit_telefono">

                            <label for="">Correo electrónico (Requerido)<sup>*</sup></label>
                            <input id="edit_email" type="text" class="form-control" name="edit_email" placeholder="">

                            <label for="">RFC (Opcional)</label>
                            <input id="edit_rfc" type="text" class="form-control" name="edit_rfc" placeholder="*En caso de requerir factura">

                            <label for="">Referencia (Opcional)</label>
                            <input id="edit_referencia" type="text" class="form-control" name="edit_referencia" placeholder="Referencia del lugar de envío del paquete">


                            <input class="form-control" type="hidden" id="edit_id" name="edit_id">
                        </div>
                </div>
                            <div class="modal-footer" style="background: #fafafa;">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <input class="btn btn-primary" type="submit" value="Actualizar">
                            </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('#editDirection').on('show.bs.modal', function(event){
                console.log('Model editar Materia funcionando');
                var button = $(event.relatedTarget)

                var id = button.data('id')
                var nombre = button.data('nombre')
                var apellidos = button.data('apellidos')
                var empresa = button.data('empresa')
                var pais = button.data('pais')
                var direccion1 = button.data('direccion1')
                var direccion2 = button.data('direccion2')
                var localidad = button.data('localidad')
                var region = button.data('region')
                var cp = button.data('cp')
                var telefono = button.data('telefono')
                var email = button.data('email')
                var rfc = button.data('rfc')
                var referencia = button.data('referencia')

                var modal = $(this)

                modal.find('.modal-body #edit_id').val(id);
                modal.find('.modal-body #edit_nombre').val(nombre);
                modal.find('.modal-body #edit_apellidos').val(apellidos);
                modal.find('.modal-body #edit_empresa').val(empresa);
                modal.find('.modal-body #edit_pais').val(pais);
                modal.find('.modal-body #edit_direccion1').val(direccion1);
                modal.find('.modal-body #edit_direccion2').val(direccion2);
                modal.find('.modal-body #edit_localidad').val(localidad);
                modal.find('.modal-body #edit_region').val(region);
                modal.find('.modal-body #edit_cp').val(cp);
                modal.find('.modal-body #edit_telefono').val(telefono);
                modal.find('.modal-body #edit_email').val(email);
                modal.find('.modal-body #edit_rfc').val(rfc);
                modal.find('.modal-body #edit_referencia').val(referencia);
            })
    </script>
@endsection