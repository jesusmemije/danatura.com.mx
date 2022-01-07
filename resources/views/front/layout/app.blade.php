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
    <!-- <meta name="description" content=""> -->
    <meta name="author" content="PICE Software">
    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.ico')}}">
    <link rel="icon" type="image/png" href="{{asset('favicon.ico')}}"/>
    <title>Danatura - @yield('title', 'Comida real')</title>
    <!-- Bootstrap CSS -->
    <link href="{{asset("assets/css/bootstrap.min.css")}}" rel="stylesheet">
    <!-- Main CSS -->
    <link href="{{asset("assets/css/styles.css")}}" rel="stylesheet">
    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet" />

    @if ( env('APP_DEBUG') == false )
        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '311422277569762');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=311422277569762&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    @endif

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