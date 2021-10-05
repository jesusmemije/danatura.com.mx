<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CPQ9Y78PW7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CPQ9Y78PW7');
</script>

@yield('headers')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="PICE Software">

   






    <title>@yield('title', 'Datanura')</title>
    <!-- Bootstrap CSS -->
    <link href="{{asset("assets/css/bootstrap.min.css")}}" rel="stylesheet">
    <!-- Main CSS -->
    <link href="{{asset("assets/css/styles.css")}}" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.ico')}}">
    <link rel="icon" type="image/png" href="{{asset('favicon.ico')}}"/>

 
    @yield('styles')
</head>
<body>
    
    @include('front.layout.partials.header')

    @yield('content')

    @include('front.layout.partials.footer')

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Icons FontAwesome -->
    <script src="https://kit.fontawesome.com/94880949ce.js" crossorigin="anonymous"></script>
    
    @yield('scripts')
    
    <!-- Main js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>