@extends('layout')

@section('contend')
<?php 
    $loadImg = "<img src=".URL::to('/')."/public/pixeladmin/images/plugins/bootstrap-editable/preloader.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="page-header padding-xs-vr" style="margin: -18px -18px 5px -18px;">      
    <div class="row">

        <h1 class="col-xs-12 col-sm-6 text-center text-left-sm">
            <i class="fa fa-book page-header-icon text-primary"></i>&nbsp;
            REPORTE TOTAL VENTAS / Administrador
        </h1>
        <div class="col-xs-12 col-sm-6">
            <div class="row">
                <hr class="visible-xs no-grid-gutter-h">        

                <div class="btn-group col-xs-12 pull-right col-sm-auto">
                    <button type="button" class="btn btn-primary"><span class="btn-label icon fa fa-plus"></span>&nbsp;&nbsp;Emitir documento (CPE)</button>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#" onclick="comprobante('01','-1');">Emitir Factura Electrónica</a></li>
                        <li><a href="#" onclick="comprobante('03','-1');">Emitir Boleta de Venta Electrónica</a></li>
{{--                         <li class="divider"></li> --}}
                    </ul>
                </div>&nbsp;&nbsp;
                <!-- Margin -->
                <div class="visible-xs clearfix form-group-margin"></div>

            </div>
        </div>
    </div>
</div>

 <div class="row">
    <div class="col-md-12">
        <div class="panel panel-info" style="margin-bottom: 0px;">
            <div class="panel-heading padding-xs-hr no-padding-vr">
                    <span class="panel-title">Busqueda</span>
            </div>
            <!-- / .panel-heading -->
                <div class="panel-body padding-xs-vr padding-xs-hr text-xs ">
                    <div class="row" style="padding-bottom:0px">
                        <div class="col-md-2">
                            <label class="control-label no-margin-b">Tipo Comprobante:</label>
                            <select id="tDoc" name="tDoc" class="form-control">
                                <option value="-1">[TODOS]</option>                 
                                @foreach($documentoComprobante as $documento)
                                    @if($documento->pk_tip_doc_ven_id=="1" || $documento->pk_tip_doc_ven_id=="2")
                                        <option value="{{ $documento->pk_tip_doc_ven_id }}">{{ $documento->c_des }}</option>
                                    @endif

                                @endforeach                                               
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label no-margin-b">Fecha Inicio</label>
                            <div class="input-group date" id="fecha">
                                <input type="text" class="form-control input-sm" id="fec" name="fec" autocomplete="off" />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label no-margin-b">Fecha Final</label>
                            <div class="input-group date" id="fecha">
                                <input type="text" class="form-control input-sm" id="fecFin" name="fecFin" autocomplete="off"/>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>   
                        {{--<div class="col-md-2">
                            <label class="control-label no-margin-b">Tipo Comprobante:</label>
                            <select id="tDoc" name="tDoc" class="form-control">
                                <option value="">[TODOS]</option>                 
                                @foreach($documentoComprobante as $documento)
                                        <option value="{{ $documento->pk_tip_doc_ven_id }}">{{ $documento->c_des }}</option>
                                @endforeach                                               
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="control-label no-margin-b">Denominación:</label>
                            <select id="cli" name="cli" class="form-control">
                                <option value="">[TODOS]</option>                 
                                @foreach($cliente as $cli)
                                        <option value="{{ $cli->pk_cli_id }}">{{ $cli->c_num_doc }} {{ $cli->c_raz }}</option>
                                @endforeach                                               
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="control-label no-margin-b">N° Comprobante</label>
                            <input type="text" class="form-control input-sm" id="doc" name="doc" />
                        </div> --}}                                                                     
                        
                        <div class="col-md-1">
                            <label class="control-label no-margin-b"> &nbsp; </label>
                            <button type="" class="btn btn-success btn-block" onclick="imprimir();">
                                <span class="fa fa-search"></span>
                            </button>
                        </div> 
                    </div>
            </div>
        </div>
        <!-- / .panel -->
    </div>
</div>   
<div class="row">
    <div class="col-md-12">
        <div id="reporte"></div>
    </div>
</div>

<script>
init.push(function () {        
    $('#fec').datepicker(
    {
        format: 'dd/mm/yyyy',
        autoclose: true,
        language: 'es-ES',
        todayHighlight: true,
        endDate: '+0',
        weekStart: 0
        
    });
    $('#fecFin').datepicker(
    {
        format: 'dd/mm/yyyy',
        autoclose: true,
        language: 'es-ES',
        todayHighlight: true,
        endDate: '+0',
        weekStart: 0
        
    }); 

    $("#tDoc").select2({
        allowClear: true,
        placeholder: "SELECCIONE...",
        //minimumInputLength: 3,
        //multiple: false,
    });
});

function imprimir(){
    var f = $("#fec").val();
    var fFin = $("#fecFin").val();
    var tDoc = $("#tDoc").val();   
    var fec;
    var fecFin;
    if(f!=""){
        var fields = f.split("/");
        var dia = fields[0];
        var mes = fields[1];
        var anio = fields[2];
        fec = anio+"-"+mes+"-"+dia;
    }else{
        fec="";
    }

    if(fFin!=""){
        var fields2 = fFin.split("/");
        var dia2 = fields2[0];
        var mes2 = fields2[1];
        var anio2 = fields2[2];
        fecFin = anio2+"-"+mes2+"-"+dia2;
    }else{
        fecFin="";
    }
    var data = "id="+fec+"&id2="+ fecFin+"&id3="+ tDoc
    $('#modal-{{ $nameModule }}').modal({
        show:true 
    });

    if(f!="" && fFin!=""){
        $.ajax({
            beforeSend: function(){
                $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");                                   
            },
            type: "GET",
            cache: false,
            url : '{{ url($linkBaseModule.'imprimir') }}',
            data: data,
            success: function(response){
                if (response != "false") {
                    $('#reporte').html(response);    
                }else{
                    alert("No se encontró resultados "+response.error);
                }
            },
            error: function(e){
                $.growl.error({
                    title: "Error: " + e.status + " " + e.statusText ,
                    message: "No es posible cargar el reporte! <br />Vuelva a intertarlo en un momento",
                    size: 'large'
                });
                setTimeout(function(){
                    $("#content-modal-{{ $nameModule }}").html('');
                    $('#modal-{{ $nameModule }}').modal('hide');
                }, 4000);       
            },
            dataType : 'html'
        });
    }else{
        alert("Por favor ingresar Fecha de Inicio y Fecha de Fin")
    }
    
    return false;
}


</script>
@stop