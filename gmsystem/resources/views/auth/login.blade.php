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

    <!--[if lt IE 9]>
        <script src="{{ url('') }}/public/pixeladmin/javascripts/ie.min.js"></script>
    <![endif]-->


<!-- $DEMO =========================================================================================

    Remove this section on production
-->
    <style>
        #signin-demo {
            position: fixed;
            right: 0;
            bottom: 0;
            z-index: 10000;
            background: rgba(0,0,0,.6);
            padding: 6px;
            border-radius: 3px;
        }
        #signin-demo img { cursor: pointer; height: 40px; }
        #signin-demo img:hover { opacity: .5; }
        #signin-demo div {
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding-bottom: 6px;
        }
    </style>
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

        <!-- Left side -->
        <div class="signin-info" style="background: rgba(26,170,218,.8);">
            <a href="index.html" class="logo">
                {{-- <img src="{{ url('') }}/public/pixeladmin/demo/logo-big.png" alt="" style="margin-top: -5px;">&nbsp; --}}
                SISTEMA DE COTIZACIÓN
            </a> <!-- / .logo -->
            <div class="slogan">
                Simple. Flexible. Poderoso.
            </div> <!-- / .slogan -->
            <ul>
                <li><i class="fa fa-file-text-o signin-icon"></i> Clientes </li>
                <li><i class="fa fa-file-text-o signin-icon"></i> Productos o Servicios </li>
                <li><i class="fa fa-file-text-o signin-icon"></i> Cotización </li>
                <li><i class="fa fa-file-text-o signin-icon"></i> Envio de Correo</li>
            </ul> <!-- / Info list -->
        </div>
        <!-- / Left side -->

        <!-- Right side -->
        <div class="signin-form">
            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" id="signin-form_id">
                 @csrf
                <div class="signin-text">
                    <span>Accede a tu cuenta</span>
                </div> <!-- / .signin-text -->

                <div class="form-group w-icon">
                    <input type="text" name="email" id="username_id" class="form-control is-invalid input-lg" placeholder="Username or email" value="{{ old('email') }}" >
                    <span class="fa fa-user signin-form-icon"></span>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div> <!-- / Username -->

                <div class="form-group w-icon">
                    <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} input-lg" placeholder="Password" required>
                    <span class="fa fa-lock signin-form-icon"></span>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div> 
                <!-- / Password -->
                <div class="form-actions">
                    <input type="submit" value="INGRESAR" class="signin-btn bg-primary" style="background: #3daacf!important">
<!--                     <a href="#" class="forgot-password" id="forgot-password-link">Forgot your password?</a> -->
                </div> 
                <!-- / .form-actions -->
            </form>
            <!-- / Form -->


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

</body>
</html>
