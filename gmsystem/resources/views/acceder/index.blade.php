<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Sign In - PixelAdmin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Open Sans font from Google CDN -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

    <!-- Pixel Admin's stylesheets -->
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
  <link href="{{ url('') }}/public/pixeladmin/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
        <script src="{{ url('') }}/public/pixeladmin/javascripts/ie.min.js"></script>
    <![endif]-->


<!-- $DEMO =========================================================================================

    Remove this section on production
-->

<!-- / $DEMO -->

</head>


<!-- 1. $BODY ======================================================================================
    
    Body

    Classes:
    * 'theme-{THEME NAME}'
    * 'right-to-left'     - Sets text direction to right-to-left
-->
<body class="theme-default page-signin">

    <!-- Page background -->
    <div id="page-signin-bg">
        <!-- Background overlay -->
        <div class="overlay"></div>
        <!-- Replace this with your bg image -->
        <img src="{{ url('') }}/public/pixeladmin/demo/signin-bg-1.jpg" alt="">
    </div>
    <!-- / Page background -->

    <!-- Container -->
    <div class="signin-container">

        <div class="signin-form no-padding">
        <div class="row">
            <div class="col-md-4">
                <div class="panel" style="color: #F3FFCE;">
                    <div class="panel-heading">
                        <span class="panel-title">DATOS DEL EMPLEADO</span>
                    </div>

                            <div class="panel-heading" >
                               {{--  <div class="widget-profile-bg-icon">
                                  <i class="fa fa-flask"></i>
                                </div> --}}
                                <img src="{{ url('') }}/public/pixeladmin/demo/avatars/2.jpg" alt="" class="panel profile-photo">
                                <div class="widget-profile-header" style="color: #555;">
                                    <span>
                                        {{ $empleado->c_nom }} {{ $empleado->c_pri_ape }} {{ $empleado->c_seg_ape }}
                                    </span><br>
                                </div>
                            </div> <!-- / .panel-heading -->
                            <div class="list-group">
                                <a href="#" class="list-group-item"><i class="fa fa-envelope-o list-group-icon"></i>Documento: {{ $empleado->c_num}}</a>
                                <a href="#" class="list-group-item"><i class="fa fa-tasks list-group-icon"></i>Teléfono: {{ $empleado->c_tel }}</a>
                                <a href="#" class="list-group-item"><i class="fa fa-bell-o list-group-icon"></i>Dirección: {{ $empleado->c_dir }}</a>
                                <a href="#" class="list-group-item"><i class="fa fa-bell-o list-group-icon"></i>Email: {{ $empleado->c_ema }}</a>
                                

                            </div>
                            <div class="list-group" style="padding-top: 20px;">

                                <a href="{{ route('logout') }}" class="btn btn-danger">
                                        Cerrar Sessión
                                </a>
                            </div>
  
                </div>

            </div>
            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Acceso a las sucursales</span>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Sucursal</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach($sucursal as $datos)
                                    <tr>
                                        <td>{{ $datos->c_nom }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info" onclick="acceder({{ $datos->fk_suc_id }});">
                                                Acceder
                                            </button>
                                        </td>
                                    </tr>
                                 @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- / .row -->
        </div>
        <!-- Right side -->
    </div>
    <!-- / Container -->

    <div class="not-a-member">
        CAL. LUIS VARELA Y ORBEGOZO NRO. 247 DPTO. 202
    </div>

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
    <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
    <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- Pixel Admin's javascripts -->
<script src="{{ url('') }}/public/pixeladmin/javascripts/bootstrap.min.js"></script>
<script src="{{ url('') }}/public/pixeladmin/javascripts/pixel-admin.min.js"></script>

<script type="text/javascript">
    function acceder(id){
        $.ajax({
            beforeSend: function(){

            },
            type : 'POST',
            url : '{{ url('acceder/acceso') }}',
            data: {
            "_token": "{{ csrf_token() }}",
            "id": id
            },
            success : function(datos_json) {
                if (datos_json.success != false) {
                    $(location).attr("href", "home");                    
                }
            },
            error : function(data) {
                $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se puede acceder!" , size: 'large' });  
            },

            dataType : 'json'
        });

    }
</script>
</body>
</html>
