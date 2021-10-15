@extends('front.layout.app')

<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
	integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
	integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==">
</script>

@section('content')

@include('front.layout.partials.menu')

<style>
	#mapid {
		height: 600px;
	}

	.anyClass {
		height: 300px;
		overflow-y: scroll;
	}

	/* width */
	.anyClass::-webkit-scrollbar {
		width: 20px;
	}

	.anyClass::-webkit-scrollbar-track {
		margin-top: 10px;
		margin-bottom: 10px;
	}

	/* Handle */
	.anyClass::-webkit-scrollbar-thumb {
		background: black;
		border-radius: 10px;
	}

	/* Handle on hover */
	.anyClass::-webkit-scrollbar-thumb:hover {
		background: gray;
	}

	.caja-busqueda {
		background: #FFE4B8;
		border-radius: 10px;
		box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
		margin-right: 2%;
		margin-left: 10%;
	}

	.caja-resultados {
		font-family: "AmasisMTStd-Bold";
		border: 1px solid #f7e2c1;
		border-radius: 8%;
		box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
		height: calc(38vw);
		margin-right: 2%;
		margin-left: 8%;
		background: white;
	}

	.etiqueta {
		color: #F79860;
		font-family: "AmasisMTStd-Bold";
		font-size: 25px;
		padding-top: 10%;
		padding-left: 2%;
		padding-bottom: 2%;
	}

	.select {
		background: #f5e6cd;
		border: 1px solid #efd9b6;
		color: black;
		border-radius: 10px;
		box-shadow: 2px -2px #e7d5b9;
		font-family: "AmasisMTStd-Bold";
		font-size: 18px;
	}

	.rose {
		color: black;
		padding: 12px;
		background: white;
		margin-bottom: 20px;
	}

	.norose {
		color: black;
		padding: 12px;
		background: #f5e6cd;
		margin-bottom: 20px;
	}

	.rosep {
		color: #f5e6cd !important;
	}

	.norosep {
		color: white !important;
	}

	@media(max-width:768px) {
		.caja-resultados {
			font-family: "AmasisMTStd-Bold";
			border-radius: 10px;
			box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
			height: calc(100vw);
			background: white;
			margin-right: 5%;
			margin-left: 5%;
		}

		.caja-busqueda {
			margin-right: 5%;
			margin-left: 5%;
		}
	}
</style>


<div style="background: #f5e6cd;">

	<div class="container">
		<div style="padding-top:4%; padding-bottom:4%;">
			<div class="row" style="padding-bottom: 8%;">
				<div style="position:relative">
					<img src="{{asset('assets/img/marcador.png')}}" width="100" alt="">
				</div>
				<a style="padding-top:2%" href="{{route('puntos-venta')}}">
					<h3 style="color:#F79860; font-weight:bold; padding-bottom:2%; font-family:'AmasisMTStd-Bold'">
						PUNTOS DE VENTA</h3>
				</a>
			</div>

			<div class="row">
				<div class="col-md-12 d-flex justify-content-center">
					<img class="img-fluid" src="{{asset('assets/img/mapa5.png')}}" alt="">

				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div id="buscador" class="col-md-4 caja-busqueda" style="margin-bottom: 4%">
			<form action="{{route('puntos-venta')}}">
				<div class="form-row align-items-center">
					<div class="col-md-12">
						<label for="estado" class="etiqueta">ESTADO</label>
						<select class="form-control select" name="estado" id="estado"
							onchange="return get_class_sections(this.value)">
							<option value="">SELECCIONE UN ESTADO</option>
							<option value="Aguascalientes">AGUASCALIENTES</option>
							<option value="Baja California">BAJA CALIFORNIA</option>
							<option value="Baja California Sur">BAJA CALIFORNIA SUR</option>
							<option value="Campeche">CAMPECHE</option>
							<option value="Chiapas">CHIAPAS</option>
							<option value="Chihuahua">CHIHUAHUA</option>
							<option value="CDMX">CIUDAD DE MÉXICO</option>
							<option value="Coahuila">COAHUILA</option>
							<option value="Colima">COLIMA</option>
							<option value="Durango">DURANGO</option>
							<option value="Estado de México">ESTADO DE MÉXICO</option>
							<option value="Guanajuato">GUANAJUATO</option>
							<option value="Guerrero">GUERRERO</option>
							<option value="Hidalgo">HIDALGO</option>
							<option value="Jalisco">JALISCO</option>
							<option value="Michoacán">MICHOACÁN</option>
							<option value="Morelos">MORELOS</option>
							<option value="Nayarit">NAYARIT</option>
							<option value="Nuevo León">NUEVO LEÓN</option>
							<option value="Oaxaca">OAXACA</option>
							<option value="Puebla">PUEBLA</option>
							<option value="Querétaro">QUERÉTARO</option>
							<option value="Quintana Roo">QUINTANA ROO</option>
							<option value="San Luis Potosí">SAN LUIS POTOSÍ</option>
							<option value="Sinaloa">SINALOA</option>
							<option value="Sonora">SONORA</option>
							<option value="Tabasco">TABASCO</option>
							<option value="Tamaulipas">TAMAULIPAS</option>
							<option value="Tlaxcala">TLAXCALA</option>
							<option value="Veracruz">VERACRUZ</option>
							<option value="Yucatán">YUCATÁN</option>
							<option value="Zacatecas">ZACATECAS</option>
						</select>

					</div>
					<div class="col-md-12">
						<label for="ciudad" class="etiqueta">CIUDAD</label>
						<select class="form-control select" name="ciudad" id="ciudad">
							<option value="">SELECCIONE UNA CIUDAD</option>
						</select>
					</div>

					<div class="col-md-12">
						<label for="busqueda" class="etiqueta">BÚSQUEDA</label>
						<input name="busqueda" id="busqueda" type="text" class="form-control select"
							placeholder="Ciudad, Estado, Tienda o  Dirección">
					</div>
					<div class="col-12 d-flex justify-content-center">
						<button style="margin-top: 4%; background:#F79860; border:1px solid white;" type="submit"
							class="btn btn-success mb-2">BUSCAR</button>
					</div>
				</div>
			</form>
		</div>

		<div class="col-md-5 caja-resultados anyClass" id="resultados" style="margin-bottom: 4%">
			<div style="padding-top: 3%; padding-left:2%">
				<p>RESULTADOS ({{sizeof($puntos)}})</p>
			</div>

			@foreach($puntos as $i => $punto)
			@php $class = $i % 2 ? 'rose' : 'norose'; $otherclass = $i % 2 ? 'rosep' : 'norosep'; @endphp
			<div class="{{ $class }}">
				<div class="row">
					<div class="col-md-1 ">
						<h1 class="{{$otherclass}}">{{$i+1}}</h1>
					</div>
					<div class="col-md-11" style="margin-top:14px;">
						<p>{{$punto->nombre_comercial}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col">
						<div style="width: 81%; ">
							<p style="">{{$punto->direccion}}</p>
						</div>
						<p>{{$punto->telefono_contacto}}</p>
					</div>
				</div>
			</div>

			@endforeach

		</div>
	</div>
	<div class="container">
		<div class="row" style="padding-bottom: 8%;">
			<div class="ml-3 mt-5">
				<h6 style="color:black; font-weight:bold; padding-bottom:2%; font-family:'AmasisMTStd-Bold'">
					Encuéntranos también en:
				</h6>
				<a href="https://www.amazon.com.mx/s?me=A363UH1A80THI0&marketplaceID=A1AM78C64UM0Y8" target="_BLANK">
					<img src="{{asset('assets/img/amazon-logo.png')}}" width="100" alt="">
				</a>	
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function get_class_sections(nombre){

		var select = $("#estado");
 
    $('#ciudad option').remove();
    $.ajax({
      data: {
        "_token": "{{ csrf_token() }}",
        "ciudad": nombre
      },
      url: "{{ route('get-ciudades') }}",
      type: 'post',
      dataType: "json",
      success: function(response) {
		
		console.log(response);
        var bop = document.createElement("option");
        bop.value="";
        $(bop).html('Selecciona una ciudad');
        $(bop).appendTo("#ciudad");

        for (let index = 0; index < response.length; index++) {
          var option = document.createElement("option");
          $(option).html(response[index].ciudad);
          option.value = response[index].ciudad;
          $(option).appendTo("#ciudad");
        }

      },
      error: function(response) {
        alert("Ha ocurrido un error, intente de nuevo.");
        console.log(response);
      }
    });
	}

/*
	var url='{{asset('/assets/map/Sello_DANATURA.png')}}';
	console.log(url);
   //Marker icon
   var icon = L.icon({
            iconUrl: '{{asset('/assets/map/Sello_DANATURA.png')}}',
            iconSize: [20, 20], // size of the icon
        });

        var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            osmAttrib = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            osm = L.tileLayer(osmUrl, {attribution: osmAttrib }),
            bounds = new L.LatLngBounds(new L.LatLng(22.629, -103.886), new L.LatLng(18.489, -102.940));
  
        var map = new L.Map('mapid', {
            scrollWheelZoom: false,
            center: bounds.getCenter(),
            zoom: 5,
            layers: [osm],
           
        });

		const puntos = @json($puntos);
      
        puntos.forEach(function(item, index) {
			
			if(item.lat!="" &&  item.lng!="" && item.lat!=null  && item.lng!=null){
			console.log(item.lat);
			console.log(item.lng);

				L.marker( [item.lat,item.lng], {icon: icon} ).addTo(map).
				bindPopup('<div><center><img width="60" src="'+url+'"></center>'+
				'<p>' + item.nombre_comercial+'</p> <p>Telefono(s):</p>'+
				'<p>'+item.telefono_contacto+'</p>'+
				'<p>Direccion</p>'+
				'<p>'+item.direccion+'</p>'+
				'</div><center></center>');
			}
        }); */

</script>
@endsection