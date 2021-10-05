<!doctype html>
<html class="no-js " lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">


<title>@yield('page-title','Danatura')</title>
   <link href="{{asset('admin_assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link
href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
rel="stylesheet">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- Favicon-->
<link rel="stylesheet" href="{{asset('aero/plugins/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('aero/plugins/dropify/css/dropify.min.css')}}">

<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('aero/css/style.min.css')}}">

</head>

<style>

.btn-primary{

    background: #F79860;
}    
a{
    color:#F79860;
}
.redondo {
  justify-content: center;


border-radius: 50%;
  
  width: 32px;
    height: 32px;

    padding-top: 8px !important;
    padding-left: 10px !important;
}

.ie{
  padding-left: 8px !important;
}


</style>

<body class="theme-orange">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('assets/images/Sello_DANATURA.png')}}" width="48" height="48" alt="Aero"></div>
        <p>Please wait...</p>
    </div>
</div>


<!-- Right Icon menu Sidebar -->
<div class="navbar-right">
    <ul class="navbar-nav">
      
        <li><a data-toggle="modal" data-target="#logoutModal" class="mega-menu" title="Sign Out"><i class="zmdi zmdi-power"></i></a></li>
    </ul>
</div>

@include('admin.layout.partials.sidebar')


<section class="content">
     <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>@yield('pagina-actual')</h2>
                    @yield('breadcumb')
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button style="background:#F79860" class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
             
                    <!-- Content Row -->
                    @yield('content')


            </div>
        </div>
    </div>

  <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Seguro que desea salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Presiona en "salir" si realmente estás seguro de  cerrar tu sesión.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST"">
                        {{ csrf_field() }}
                        <button type="submit">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</section>
<!-- Jquery Core Js --> 
<script src="{{asset('aero/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
<script src="{{asset('aero/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 

<script src="{{asset('aero/plugins/dropify/js/dropify.min.js')}}"></script>

<script src="{{asset('aero/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{asset('aero/js/pages/forms/dropify.js')}}"></script>

@yield('scripts')

</body>
</html>