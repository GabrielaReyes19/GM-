<!DOCTYPE html>
<!--

TABLE OF CONTENTS.

Use search to find needed section.

=====================================================

|  1. $BODY                 |  Body                 |
|  2. $MAIN_NAVIGATION      |  Main navigation      |
|  3. $NAVBAR_ICON_BUTTONS  |  Navbar Icon Buttons  |
|  4. $MAIN_MENU            |  Main menu            |
|  5. $CONTENT              |  Content              |

=====================================================

-->


<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Blank - Pages - PixelAdmin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

  <!-- Open Sans font from Google CDN -->
 {{--  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css"> --}}

  <!-- Pixel Admin's stylesheets -->
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

  <!--[if lt IE 9]>
    <script src="{{ url('') }}/pixeladmin/javascripts/ie.min.js"></script>
  <![endif]-->


<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
  <script type="text/javascript"> window.jQuery || document.write('<script src="{{ url('') }}/public/pixeladmin/javascripts/jquery-2.0.3.min.js">'+"<"+"/script>"); </script>
  <!-- <![endif]-->
  <!--[if lte IE 9]>
    <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
  <![endif]-->

  {{-- <script src="jquery.transit.js"></script> --}}

  <!-- Pixel Admin's javascripts -->
  <script src="{{ url('') }}/public/pixeladmin/javascripts/bootstrap.min.js"></script>
  <script src="{{ url('') }}/public/pixeladmin/javascripts/pixel-admin.min.js"></script>
</head>


<!-- 1. $BODY ======================================================================================
  
  Body

  Classes:
  * 'theme-{THEME NAME}'
  * 'right-to-left'      - Sets text direction to right-to-left
  * 'main-menu-right'    - Places the main menu on the right side
  * 'no-main-menu'       - Hides the main menu
  * 'main-navbar-fixed'  - Fixes the main navigation
  * 'main-menu-fixed'    - Fixes the main menu
  * 'main-menu-animated' - Animate main menu
-->
<body class="theme-default main-menu-animated">

<script>var init = [];</script>
<!-- Demo script --> <script src="{{ url('') }}/public/pixeladmin/demo/demo.js"></script> <!-- / Demo script -->

<script>
    $(window).load(function() {
        $("#page_loading").fadeOut("slow");
    })
</script>

<div id="page_loading"></div>
<div id="main-wrapper">


<!-- 2. $MAIN_NAVIGATION ===========================================================================

  Main navigation
-->
 <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
      <!-- Main menu toggle -->
      <button type="button" id="main-menu-toggle">
        <i class="navbar-icon fa fa-bars icon"></i><span
          class="hide-menu-text">HIDE MENU</span>
      </button>

      <div class="navbar-inner">
        <!-- Main navbar header -->
        <div class="navbar-header">

          <!-- Logo -->
          <a href="#" class="navbar-brand">
            <div>
              <!-- <img alt="" src="< ?php echo base_url()?>/pixel/images/pixel-admin/inpexxx.png"> -->
            </div> FACT PRO
          </a>

          <!-- Main navbar toggle -->
          <button type="button" class="navbar-toggle collapsed"
            data-toggle="collapse" data-target="#main-navbar-collapse">
            <i class="navbar-icon fa fa-bars"></i>
          </button>

        </div>
        <!-- / .navbar-header -->

        <div id="main-navbar-collapse"
          class="collapse navbar-collapse main-navbar-collapse">
          <div>
            <div class="right clearfix">
              <ul class="nav navbar-nav pull-right right-navbar-nav">  
                <li class="dropdown">                                                               
                    <a href="#" accesskey=""class="dropdown-toggle user-menu" data-toggle="dropdown">
                        <span style="text-transform: uppercase;">Sucursal {{ session('nomSucursal') }}</span>
                     </a>
                </li>                                                         
                <li class="dropdown">                                                               
                      <a href="#"
                          accesskey=""class="dropdown-toggle user-menu" data-toggle="dropdown"> 
                          <img src="{{ url('') }}/public/pixeladmin/demo/avatars/1.jpg" accesskey=""alt=""/> 
                          <span style="text-transform: uppercase;">{{ session('nomEmppleado') }}</span>
                       </a>
                      <ul class="dropdown-menu">
                          <li>
                              <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                  <i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Cerrar Sesi&oacute;n
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </li>
                      </ul>
                  </li>
              </ul>
              <!-- / .navbar-nav -->
            </div>
            <!-- / .right -->
          </div>
        </div>
        <!-- / #main-navbar-collapse -->
      </div>
      <!-- / .navbar-inner -->
    </div>
<!-- /2. $END_MAIN_NAVIGATION -->


<!-- 4. $MAIN_MENU =================================================================================

    Main menu
    
    Notes:
    * to make the menu item active, add a class 'active' to the <li>
      example: <li class="active">...</li>
    * multilevel submenu example:
      <li class="mm-dropdown">
        <a href="#"><span class="mm-text">Submenu item text 1</span></a>
        <ul>
        <li>...</li>
        <li class="mm-dropdown">
          <a href="#"><span class="mm-text">Submenu item text 2</span></a>
          <ul>
          <li>...</li>
          ...
          </ul>
        </li>
        ...
        </ul>
      </li>
-->
  <div id="main-menu" role="navigation">
    <div id="main-menu-inner">
      <div class="menu-content top" id="menu-content-demo">
        <!-- Menu custom content demo
           CSS:        styles/pixel-admin-less/demo.less or styles/pixel-admin-scss/_demo.scss
           Javascript: html/{{ url('') }}/pixeladmin/demo/demo.js
         -->
        <div>
          <div class="text-bg"><span class="text-semibold">{{ auth()->user()->name }}</span></div>

          <img src="{{ url('') }}/public/pixeladmin/demo/avatars/1.jpg" alt="" class="">
          <div class="btn-group">
            <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-envelope"></i></a>
            <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
            <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </div>
          <a href="#" class="close">&times;</a>
        </div>
      </div>
      <ul class="navigation">
<!--         <li>
          <a href="index.html"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">Dashboard</span></a>
        </li> -->
        <li>
          <a href="{{ url('/producto') }}"><i class="menu-icon fa fa-shopping-cart"></i><span class="mm-text">PRODUCTOS Y SERVICIOS</span></a>
        </li>
        <li>
          <a href="{{ url('/cliente') }}"><i class="menu-icon fa fa-group"></i><span class="mm-text">CLIENTES</span></a>
        </li>
        <li>
          <a href="{{ url('/comprobante') }}"><i class="menu-icon fa fa-book"></i><span class="mm-text">COTIZACIÓN</span></a>
        </li>

<!--         <li class="mm-dropdown">
          <a href="#"><i class="menu-icon fa fa-check-square"></i><span class="mm-text">GUÍAS</span></a>
          <ul>
            <li>
              <a tabindex="-1" href="#"><span class="mm-text">Guías de Remisión Remitente</span></a>
            </li>
          </ul>
        </li> -->

<!--         <li>
          <a href="tables.html"><i class="menu-icon fa fa-table"></i><span class="mm-text">COMPRAS</span></a>
        </li> -->

 <!--        <li class="mm-dropdown">
          <a href="#"><i class="menu-icon fa fa-sitemap"></i><span class="mm-text">RETENCIONES</span></a>
          <ul>
            <li>
              <a tabindex="-1" href="#"><span class="mm-text">Comprobantes de Retención</span></a>
            </li>
          </ul>
          <ul>
            <li class="mm-dropdown">
              <a tabindex="-1" href="#"><span class="mm-text">Reportes</span></a>
              <ul>
                <li>
                  <a tabindex="-1" href="#"><span class="mm-text"></span></a>
                </li>
              </ul>
            </li>
          </ul>
        </li> -->
      
<!--         <li class="mm-dropdown">
          <a href="#"><i class="menu-icon fa fa-sitemap"></i><span class="mm-text">PERCEPCIONES</span></a>
          <ul>
            <li>
              <a tabindex="-1" href="#"><span class="mm-text">Comprobantes de Persepción</span></a>
            </li>
          </ul>
          <ul>
            <li class="mm-dropdown">
              <a tabindex="-1" href="#"><span class="mm-text">Reportes</span></a>
              <ul>
                <li>
                  <a tabindex="-1" href="#"><span class="mm-text"></span></a>
                </li>
              </ul>
            </li>
          </ul>
        </li> -->
{{--         <li class="mm-dropdown">
          <a href="#"><i class="menu-icon fa fa-check-square"></i><span class="mm-text">ANULACIONES</span></a>
          <ul>
            <li>
              <a tabindex="-1" href="{{ url('/documentos_anulados') }}"><span class="mm-text">Anulación de Facturas y Notas</span></a>
            </li>
            <li>
              <a tabindex="-1" href="{{ url('/resumen_anulado') }}"><span class="mm-text">Anulación de Boletas y Notas</span></a>
            </li>
<!--             <li>
              <a tabindex="-1" href="#"><span class="mm-text">Anulación de Retenciones</span></a>
            </li>
            <li>
              <a tabindex="-1" href="#"><span class="mm-text">Anulación de Percepciones</span></a>
            </li> -->
          </ul>
        </li> --}}
{{--         <li class="mm-dropdown">
          <a href="#"><i class="menu-icon fa fa-check-square"></i><span class="mm-text">RESÚMENES</span></a>
          <ul>
            <li>
              <a tabindex="-1" href="{{ url('/resumen_diario') }}"><span class="mm-text">Resúmenes Diarios de Boletas</span></a>
            </li>
          </ul>
        </li> --}}
       
      </ul> <!-- / .navigation -->
    </div> <!-- / #main-menu-inner -->
  </div> <!-- / #main-menu -->
<!-- /4. $MAIN_MENU -->


  <div id="content-wrapper">
<!-- 5. $CONTENT ===================================================================================

    Content
-->

    <!-- Content here -->
    @yield('contend')

  </div> <!-- / #content-wrapper -->
  <div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->


<script type="text/javascript">

  window.PixelAdmin.start(init);
</script>

</body>
</html>