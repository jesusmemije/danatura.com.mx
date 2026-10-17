@extends('front.layout.app')



@section('title')

    Resultados de busqueda

@endsection



@section('styles')

<link rel="stylesheet" href="{{asset('assets/css/productos.css')}}">

<style>

  .mybadge {

    line-height: 1.3;

    padding: 10px;

  }

</style>

@endsection



@section('content')

@include('front.layout.partials.menu')

<div class="container-fluid">
    

  <div class="row pt-5">

    <div class="col-md-12">

        <div class="text-center">

            <div style="color:#73472b; font-size:4em; font-family: COSMOPOLITAN SCRIPT MEDIUM; line-height:1;">Reultados de búsqueda</div>

            <div style="color:#fb985f; font-size:3em; font-family:AmasisMTStd-Bold; line-height:1;">"{{$palabra_busqueda}}"</div>

        </div>

    </div>

    <?php echo $output ?>

  </div>
  <br><br>
  <br><br>

  <!--main row-->

</div>



<!-- Modal -->

<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"

  aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        ...

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary">Save changes</button>

      </div>

    </div>

  </div>



</div> -->



@endsection



@section('scripts')




@endsection