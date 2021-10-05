@extends('admin.layout.app')

@section('content')

@section('page-subtitle','Dashboard')

@php

@endphp

<div class="container-fluid">
<div class="row clearfix">
@section('pagina-actual','Danatura')
                @section('breadcumb')
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                   
                </ul>
    
                @endsection
            <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="{{route('productos.index')}}">
                <div class="card widget_2 big_icon traffic">

                
                    <div class="body">
                       


                        <h6>Productos</h6>
                        <h2>{{$productos->count()}} </h2>
                        <small>Total de productos registrados</small>
                        <div class="progress">
                            <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="{{route('pedidos.index')}}">
                <div class="card widget_2 big_icon sales">
                    <div class="body">
                        <h6>Pedidos</h6>
                        <h2>{{$pedidos->count()}}</h2>
                        <small>Pedidos realizados</small>
                        <div class="progress">
                            <div class="progress-bar l-blue" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="{{route('usuario.index')}}">
                <div class="card widget_2 big_icon email">
                    <div class="body">
                        <h6>Usuarios</h6>
                        <h2>{{$usuarios->count()}}</h2>
                        <small>Usuarios registrados</small>
                        <div class="progress">
                            <div class="progress-bar l-purple" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon">
                <a href="{{route('newsletter')}}">
                    <div class="body">
                        <h6>Subscriptores</h6>
                        <h2>{{$subscriptores->count()}}</h2>
                        <small>Total de subscriptores</small>
                        <div class="progress">
                            <div class="progress-bar l-purple" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
           
        </div>
</div>

@endsection