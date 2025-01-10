@extends('layout')

@section('contend')
<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/preloader.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="page-header padding-xs-vr" style="margin: -18px -18px 5px -18px;">      
    <div class="row">

        <h1 class="col-xs-12 col-sm-8 text-center text-left-sm">
            <i class="fa fa-book page-header-icon text-primary"></i>&nbsp;
            <span class="text-light-gray">RESÚMENES / </span>Resúmenes Diarios de Boletas / Administrador
        </h1>
        <div class="col-xs-12 col-sm-4">
            <div class="row">
                <hr class="visible-xs no-grid-gutter-h">        
                {{-- {!! $loadImgDt !!}  --}}                                  
                <div class="pull-right col-xs-12 col-sm-auto">
                <a href="#" class="btn btn-primary btn-labeled" id="{{ $btnCreate }}" style="width: 100%;">
                    <span class="btn-label icon fa fa-plus"></span>Generar Resumen Diario
                </a>
                </div>
                <!-- Margin -->
                <div class="visible-xs clearfix form-group-margin"></div>

            </div>
        </div>
    
    </div>
    
</div>

 <div class="row" >
    <div class="col-md-12">
        <div class="panel panel-info" style="margin-bottom: 0px;">
            <div class="panel-heading padding-xs-hr no-padding-vr">
                    <span class="panel-title">Busqueda</span>
            </div>
            <div class="panel-body padding-xs-vr padding-xs-hr text-xs ">
                <form action="" id="find-{{ $nameModule }}-form" accept-charset="UTF-8" novalidate="novalidate">
                    <div class="row" style="padding-bottom:0px">
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
                        <div class="col-md-1">
                            <label class="control-label no-margin-b"> &nbsp; </label>
                            <button type="" class="btn btn-success btn-block" >
                                <span class="fa fa-search"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>   

<div class="" style="margin-top: 10px;" id="mensaje">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong><span id="respuesta"></span></strong>
</div>

<div class="table-light table-responsive">
    {{-- <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example"> --}}
    <table class="table table-bordered table-striped table-hover table-condensed dataTable no-footer" id="jq-datatables-{{ $nameModule }}" width="100%">
			<thead>
				 <tr>
                    <th style="text-align: center;">NÚMERO</th>
                    <th style="text-align: center;">FECHA DE GENERACIÓN</th>
                    <th style="text-align: center;">FECHA DE EMISIÓN DE DOCUMENTOS</th>      
                    <th style="text-align: center;">DOCUMENTOS</th>         
                    <th style="text-align: center;">TICKET(SUNAT)</th>      
                    <th style="text-align: center;">XML</th>      
                    <th style="text-align: center;">CDR</th>  
                    <th style="text-align: center;">ESTADO EN LA SUNAT</th>  
                    <th style="text-align: center;"></th> 
				</tr>	
			</thead>
        <tbody>
        </tbody>
    </table>
</div>
<hr class="no-grid-gutter-h">


<div id="modal-{{ $nameModule }}" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-max">
        <div class="modal-content" id="content-modal-{{ $nameModule }}">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->

<script>
    init.push(function () {        
        $("#mensaje").hide();
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

        $("#find-{{ $nameModule }}-form").validate({
            focusInvalid: true,
            // rules: {
            //     'fec': {required: true},
            //     'fecFin': {required: true},
            // },
            // messages: {
            //     'fec': 'Seleccione fecha inicio',
            //     'fecFin': 'Seleccione fecha final',
            
            // },
            submitHandler: function(form) {
                var f = $("#fec").val();
                var fFin = $("#fecFin").val();
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

                var query_string = $.param({
                    "_token": "{{ csrf_token() }}",
                    "fec": fec,
                    "fecFin": fecFin
                });
                var ajax_source = "{{ url('api.resumenRc') }}?" + query_string;
                oTable.ajax.url(ajax_source).load();
            } 
        });
    });

var oTableOptions = {
    "order": [[ 0, "ASC" ]],
    //"lengthMenu": [ [10, 20, 50], [10, 20, 50] ],
    "lengthMenu": [ [10, 15, 20, -1], [10, 15, 20, "Todos"] ],
    "pageLength": 10,
    "processing": true,
    "serverSide": true,
    "pagingType": "full_numbers",
    "stateSave": false,
    "ajax":{
        "url": "{{ url('api.resumenRc') }}",
        "data": function ( d ) {
            return $.extend( {}, d, {
                "_token": "{{ csrf_token() }}"
            });
        }, 
        "type": "POST",
    },

    "columnDefs": 
    [
        {"targets": 0, 'data': 'c_cod', 'name': 'c_cod', "class": "col-md-2", 'orderable': false },
        {"targets": 1, 'data': 'f_gen', 'name':'f_gen', "class": "col-md-2", 'orderable': false },
        {"targets": 2, 'data': 'f_emi', 'name':'f_emi', "class": "col-md-2", 'orderable': false },
        {"targets": 3, 'data': 'total_documentos', 'name':'total_documentos', 'orderable': false },
        {"targets": 4, 'data': 'c_num_tic', 'name':'c_num_tic', 'orderable': false },
        {"targets": 5, 'data': 'xml', 'name':'xml', 'orderable': false},
        {"targets": 6, 'data': 'cdr', 'name':'cdr', 'orderable': false},
        {"targets": 7, 'data': 'estado', 'name':'estado', 'orderable': false, "class": "text-right"},
        {"targets": 8, 'data': 'action', 'name':'action', 'orderable': false}
        
    ],
                                        
    "language":
    {
        "processing": "Refrescando data...",
        //"search":     "",
        "lengthMenu": "items x pág. _MENU_",
        "zeroRecords": "No se encontraron registros.",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoEmpty": "No hay registros.",
        "infoFiltered": "(filtered from _MAX_ total entries)",
        "paginate": {
            "first": "<<",
            "previous": "<",
            "next": ">",
            "last" : ">>"
        }
     },
        // "sDom": '<"table-header padding-xs-vr no-margin-hr clearfix" <"table-caption"> <"clear"T> <"DT-lf-right" <"DT-per-page"l> <"DT-search"f> > > t <"table-footer padding-xs-hr clearfix" <"DT-label"i> <"DT-pagination"p> >',
            "oTableTools": {        
        "aButtons": [
        ]           
    }    
};

var oTable = $('#jq-datatables-{{ $nameModule }}').DataTable(
    oTableOptions
);



$('#{{ $btnCreate }}').click(function() {
    var data = "";

    $('#modal-{{ $nameModule }}').modal({
        show:true 
    });

    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");
            $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span>&nbsp;Creando...');                 
            $('#{{ $btnCreate }}').attr({
                'class': "btn btn-primary btn-labeled disabled",
            });                                     
        },
        type: "GET",
        cache: false,
        url: "{{ url($linkBaseModule.'/create') }}",
        data: data,
        success: function(response){
            if (response != "false") {
                $('#content-modal-{{ $nameModule }}').html(response);
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span>&nbsp;Generar Resumen Diario');                  
                $('#{{ $btnCreate }}').attr({
                    'class': "btn btn-primary btn-labeled",
                });     
            }else{
                alert("No se cre&oacute; cliente "+response.error);
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span>&nbsp;Generar Resumen Diario');                  
                $('#{{ $btnCreate }}').attr({
                    'class': "btn btn-primary btn-labeled",
                }); 
            }
        },
        error: function(e){
            $.growl.error({
                title: "Error: " + e.status + " " + e.statusText ,
                message: "No es posible cargar el formulario! <br />Vuelva a intertarlo en un momento",
                size: 'large'
            });
            setTimeout(function(){
                $("#content-modal-{{ $nameModule }}").html('');
                $('#{{ $btnCreate }}').html('<span class="btn-label icon fa fa-plus"></span>&nbsp;Generar Resumen Diario');                  
                $('#{{ $btnCreate }}').attr({
                    'class': "btn btn-primary btn-labeled",
                });
                
                $('#modal-{{ $nameModule }}').modal('hide');
            }, 4000);       
        },
        dataType : 'html'
    });
    return false;
});


$("#loadData").on('click', function() {
    oTable.ajax.url("{{ url('api') }}.{{ $nameModule }}/"+$("#doc").val()).load();
 })

function consultarEstadoSunat(id,id2,id3,id4){
 bootbox.confirm({
        title: "¿Seguro(a) de consultar estado a la SUNAT",
        message: " ",
        buttons: {
            confirm: {
                label: 'OK',
                className: 'btn btn-success'
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn '
            }
        },
        callback: function(result) {
            if(result){ 
                $.ajax({
                    beforeSend: function(){
                    },
                    type : 'POST',
                    url : '{{ url($linkBaseModule.'/procesar_ticket') }}',
                    data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "id2": id2,
                    "id3": id3,
                    "id4": id4
                    },
                    success : function(datos_json) {
                        if (datos_json.success != false) {
                            $("#mensaje").show();
                            var codigo=datos_json.codigo;
                            var estado;
                            if(codigo=="0"){
                                estado="alert alert-success";
                            }else if(codigo=="99"){
                                estado="alert alert-danger";
                            }else if(codigo=="0127"){
                                estado="alert alert-warning";
                            }
                            $("#mensaje").attr("class", estado);
                            $("#respuesta").text(datos_json.result);
                            $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();
                        }else{
                            alert("Error");
                        }
                    },
                    error : function(data) {
                        $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo consultar ticket!" , size: 'large' });  
                    },

                    dataType : 'json'
                });
            }
        },
        className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
        locale: "es",
        closeButton: false,
    });    
}

function consultarXml(id, id2){

    $.ajax({
        beforeSend: function(){
            $("#preload"+id2).html("{!! $loadImg !!}");
            $("#carga"+id2).hide();
        },
        type : 'POST',
        url : '{{ url('archivo_sunat/xml') }}',
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        success : function(datos_json) {
            if (datos_json.success != false) {
                $("#preload"+id2).html("");
                $("#carga"+id2).show();
                $("#xml"+id2).attr({
                    class: 'btn btn-primary btn-rounded btn-xs',
                    target: '_blank',
                    href: datos_json.result["message"]
                });
                $("#texto"+id2).text("DESCARGAR");

                // window.open(
                // datos_json.result["message"]
                // );

            }else{
                $("#preload"+id2).html("");
                $("#carga"+id2).show();
                alert("Error");
            }
        },
        error : function(data) {
            $("#preload"+id2).html("");
            $("#carga"+id2).show();
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo enviar correo!" , size: 'large' });  
        },

        dataType : 'json'
    });
}

function consultarCdr(id, id2){
    $.ajax({
        beforeSend: function(){
            $("#preload2"+id2).html("{!! $loadImg !!}");
            $("#carga2"+id2).hide();
        },
        type : 'POST',
        url : '{{ url('archivo_sunat/cdrProcessed') }}',
        data: {
        "_token": "{{ csrf_token() }}",
        "id": id
        },
        success : function(datos_json) {
            if (datos_json.success != false) {
                $("#preload2"+id2).html("");
                $("#carga2"+id2).show();
                $("#cdr2"+id2).attr({
                    class: 'btn btn-primary btn-rounded btn-xs',
                    target: '_blank',
                    href: datos_json.result["message"]
                });
                $("#texto2"+id2).text("DESCARGAR");

                // window.open(
                // datos_json.result["message"]
                // );

            }else{
                $("#preload2"+id2).html("");
                $("#carga2"+id2).show();
                alert("Error");
            }
        },
        error : function(data) {
            $("#preload2"+id2).html("");
            $("#carga2"+id2).show();
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo enviar correo!" , size: 'large' });  
        },

        dataType : 'json'
    });
}

function verResumen(id, id2){

    $('#modal-{{ $nameModule }}').modal({
        show:true 
    });

    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");                                   
        },
        type: "GET",
        cache: false,
        url: '{{ url('resumen_diario') }}/'+id+"/"+id2+"/show",

        success: function(response){
            if (response != "false") {
                $('#content-modal-{{ $nameModule }}').html(response);   
            }else{
                alert("No se cre&oacute; cliente "+response.error); 
            }
        },
        error: function(e){
            $.growl.error({
                title: "Error: " + e.status + " " + e.statusText ,
                message: "No es posible cargar el formulario! <br />Vuelva a intertarlo en un momento",
                size: 'large'
            });
            setTimeout(function(){
                $("#content-modal-{{ $nameModule }}").html('');
                $('#modal-{{ $nameModule }}').modal('hide');
            }, 4000);       
        },
        dataType : 'html'
    });
    return false;
}
</script>
@stop