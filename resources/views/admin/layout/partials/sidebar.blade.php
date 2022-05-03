<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="{{route('home')}}">
            <img src="{{asset('assets/images/Sello_DANATURA.png')}}" width="25" alt="Danatura"><span class="m-l-10">Danatura</span>
        </a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href=""></a>
                    <div class="detail">
                        <h4>{{Auth::user()->name}}</h4>

                        @php
                        if(auth()->user()!=null){
                            $tipo = auth()->user()->tipo;
                            $tipos = DB::table('tiposuario')->where('id','=',$tipo)->first();
                            $thetipo = $tipos->tipo;
                        }
                        @endphp

                        <small>{{$thetipo}}</small>
                    </div>
                </div>
            </li>
            <li><a href="{{route('dashboard')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
            <li><a href="{{route('pedidos.index')}}"><i class="zmdi zmdi-money"></i><span>Pedidos</span></a></li>
            <li><a href="{{route('discounts.index')}}"><i class="zmdi zmdi-labels"></i><span>Descuentos</span></a></li>
            <li><a href="{{route('reportes.index')}}"><i class="zmdi zmdi-chart"></i><span>Reportes</span></a></li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="zmdi zmdi-assignment"></i><span>Productos</span>
                </a>
                <ul class="ml-menu">
                    <li><a href="{{route('productos.index')}}">Ver productos</a></li>
                    <li><a href="{{route('productos.create')}}">Añadir nuevo producto</a></li>
                    <li><a href="{{route('categorias')}}">Categorías</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="zmdi zmdi-accounts-add"></i><span>Usuarios</span>
                </a>
                <ul class="ml-menu">
                    <li><a href="{{route('usuario.index')}}">Listado de usuarios</a></li>
                    <li><a href="{{route('usuario.create')}}">Añadir nuevo usuario</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="zmdi zmdi-email-open"></i><span>Newsletter</span>
                </a>
                <ul class="ml-menu">
                    <li><a href="{{route('newsletter_list')}}">Listado</a></li>
                    <li><a href="{{route('newsletter')}}">Subscriptores</a></li>
                    <li><a href="{{route('newsletter_newv')}}">Añadir nuevo correo</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="zmdi zmdi-email-open"></i><span>Blog</span>
                </a>
                <ul class="ml-menu">
                    <li><a href="{{route('blogs.index')}}">Listado</a></li>
                    <li><a href="">Añadir nueva entrada</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="zmdi zmdi-notifications-paused"></i><span>Dudas y comentarios</span>
                </a>
                <ul class="ml-menu">
                    <li><a href="{{route('lista_dudas')}}">Listado</a></li>
                </ul>
            </li>
            <li>
                <a href="{{route('lista_contacto')}}" class="menu-toggle">
                    <i class="zmdi zmdi-accounts-alt"></i><span>Contacto</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
