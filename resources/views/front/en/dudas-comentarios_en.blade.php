@extends('front.layout_en.app')

@section('title')
Dudas y comentarios
@endsection

@section('styles')
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/lightslider.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/home.css')}}" />

<style>
  .input-gris {
    background-color: white;
    height: 50px;
    opacity: 0.5;
    color: black !important;
    border-radius: 0px !important;
  }
</style>
@endsection

@section('content')

@include('front.layout_en.partials.menu')

<div class="row" style="padding:4%; background:#FFE4BB;">

  <div class="col-md-12">

    @if (\Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
      <strong>Danger!</strong> Your question could not be saved correctly, please try again.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    @if (\Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible fade show" style="margin-left:2%; margin-right:2%;" role="alert">
      <strong>Success!</strong> Your question has been sent to our team.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    <h5 style="color:#F79860; font-weight:bold; font-family:'AmasisMTStd-Bold';">Doubts and comments</h5>

    <form style="font-family:'AmasisMTStd-Bold';" action="{{route('dudas')}}" method="post">
      @csrf
      <label for="">Write us your question here and we will gladly answer you</label>
      <input name="duda" type="text" class="form-control input-gris">
      <br>
      <div class="col-md-12 d-flex justify-content-end">
        <button class="btn btn-light">Send</button>
      </div>
    </form>

  </div>
</div>

@endsection