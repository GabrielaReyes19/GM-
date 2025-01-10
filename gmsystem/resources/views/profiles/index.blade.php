@extends('layout')

@section('contend')
<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>
<div class="page-header padding-xs-vr" style="margin: -18px -18px 5px -18px;">      
    <div class="row">

        <h1 class="col-xs-12 col-sm-6 text-center text-left-sm">
            <i class="fa fa-book page-header-icon text-primary"></i>&nbsp;
            <span class="text-light-gray">MANTENIMIENTO / </span>Clientes / Administrador
        </h1>
        <div class="col-xs-12 col-sm-6">
            <div class="row">
                <hr class="visible-xs no-grid-gutter-h">        
                {{-- {!! $loadImgDt !!}  --}}                                  
                <div class="pull-right col-xs-12 col-sm-auto">
                <a href="#" class="btn btn-primary btn-labeled" id="{{ $btnCreate }}" style="width: 100%;">
                    <span class="btn-label icon fa fa-plus"></span>Nuevo
                </a>
                </div>
                <!-- Margin -->
                <div class="visible-xs clearfix form-group-margin"></div>

            </div>
        </div>
    
    </div>
    
</div>

<hr class="no-grid-gutter-h">
@if (session()->has('info'))
    <div class="alert alert-success">{{ session('info')}}</div>
@endif
<div class="row" style="padding-bottom:0px">
    <div class="col-md-12">
    <label class="control-label no-margin-b">Perfil:</label>
       <select id="profile" name="profile" class="form-control" onclick="permisos();">
            <option value="">[TODOS]</option>
            @foreach($profiles as $profile)
                <option value="{{ $profile->id }}">{{ $profile->profile_name }}</option>
            @endforeach                                                                                    
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="cargaPermisos"></div>
    </div>
</div>  

<script type="text/javascript">
    $("#profile").select2({
        //allowClear: true,
        placeholder: "Seleccione",
        //minimumInputLength: 3,
        //multiple: false,
    });

    function permisos(){
        //var data = "id="+$("#perfil").val();
        $.ajax({
            type : 'GET',
            url : '{{ url('profiles.permits') }}/'+$("#profile").val(),
            //data: data,
            success: function(response) {
                $("#cargaPermisos").html(response);
            },
            error: function(e){
                $.growl.error({ title: "Error: " + e.status + " " + e.statusText, message: "No se pudo cargar perfil" , size: 'large' });
            },
            dataType: 'html'
         });
    }
</script>

@stop