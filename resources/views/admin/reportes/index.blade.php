@extends('admin.layout.app')

@section('page-title')
Reportes de ventas
@endsection

@section('styles')
<style>
    .card {
        border: 5px solid #fff;
    }
</style>
@endsection

@section('content')

<div class="col-md-12">
    <div class="card shadow">
        @section('pagina-actual','Reportes de ventas')
        @section('breadcumb')
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Reportes</li>
        </ul>
        @endsection

        <div class="col-md-12">
            <div class="card-body">
                <div class="header">
                    <div class="row">
                        <div class="col-md-6">
                            <h2><strong>Ventas</strong> totales del año 
                                <select id="year">
                                    <option value="2022">2022</option>
                                    <?php  for($i=2020; $i<=2022; $i++) { echo "<option value='".$i."'>".$i."</option>"; } ?>
                                </select>
                                <select id="month">
                                    <option value="" selected>Ningún mes</option>
                                    <option value="enero">Enero</option>
                                    <option value="febrero">Febrero</option>
                                    <option value="marzo">Marzo</option>
                                    <option value="abril">Abril</option>
                                    <option value="mayo">Mayo</option>
                                    <option value="junio">Junio</option>
                                    <option value="julio">Julio</option>
                                    <option value="agosto">Agosto</option>
                                    <option value="septiembre">Septiembre</option>
                                    <option value="octubre">Octubre</option>
                                    <option value="noviembre">Noviembre</option>
                                    <option value="diciembre">Diciembre</option>
                                </select>
                            </h2>
                            <span style="font-size: 34px" id="total">NaN</span>
                        </div>
                        <div class="col-md-6 text-right">
                            <!-- <a href="/admin/reportes/informe_ventas">Ver informe</a> -->
                            <a href="#">Ver informe</a>
                        </div>
                    </div>
                </div>
                <div class="body">
                    <canvas id="chartVentasTotales"></canvas>
                </div>
            </div>
            <div class="card-body">
                <div class="header">
                    <div class="row">
                        <div class="col-md-6">
                            <h2><strong>Productos</strong> más vendidos</h2>
                        </div>
                        <div class="col-md-6 text-right">
                            <!-- <a href="/informe_masvendidos">Ver informe</a> -->
                            <a href="#">Ver informe</a>
                        </div>
                    </div>
                </div>
                <div class="body">
                    <canvas id="chartMasVendidos"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
var meses   = [];
var valores = [];
var productos = [];
var unidades  = [];
var label = '';
var title = '';
$(document).ready(function(){

    getDataVentas();
    getDataMasVendidos();

    $('#year').on('change', function() {
        location.reload();
    });

    $('#month').on('change', function() {
        location.reload();
    });

})

function getDataVentas() {
    var year = document.getElementById("year");
    var month = document.getElementById("month");
    
    var year = year.value;
    var month = month.value;

    if ( month == '') {
        label = "Año " + year;
        title = "Ventas del año " + year;
    } else {
        label = 'Mes de ' + month + " del " + year;
        title = "Ventas de " + month + ' del ' + year;
    }

    $.ajax({
        url: '/admin/ventas/by_anio',
        method: 'POST',
        dataType: 'json',
        data: {
            anio   : year,
            month  : month,
            _token : $('input[name="_token"]').val()
        }
    }).then(function(data){
        meses   = data.meses;
        valores = data.valores;
        total   = data.total;
        total_all = data.total_all;
        total = Intl.NumberFormat('es-MX', { style : 'currency', currency : 'MXN' }).format(total);
        total_all = Intl.NumberFormat('es-MX', { style : 'currency', currency : 'MXN'}).format(total_all);

        $('#total').text(total + ' / ' + total_all);

        crearChartVentas();
    })
}

function getDataMasVendidos() {

    $.ajax({
        url: '/admin/ventas/mas_vendidos',
        method: 'GET',
        dataType: 'json'
    }).then(function(data){

        data.productos.forEach(element => {
            productos.push(element.nombre);
            unidades.push(element.cantidad);
        });

        crearChartMasVendidos();
    })
}

function crearChartVentas() {
    
    const data = {
        labels: meses,
        datasets: [{
            label: label,
            data: valores,
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 2
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: title
                }
            }
        },
    };
    const ctx = document.getElementById('chartVentasTotales').getContext('2d');
    const chartVentasTotales = new Chart(ctx, config);
}

function crearChartMasVendidos() {
    
    const data = {
        labels: productos,
        datasets: [{
            label: 'Unidades vendidas',
            data: unidades,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 2
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'PRODUCTOS MÁS VENDIDOS'
                }
            }
        },
    };
    const ctx = document.getElementById('chartMasVendidos').getContext('2d');
    const chartMasVendidos = new Chart(ctx, config);
}
</script>
@endsection