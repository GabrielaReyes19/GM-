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
            <i class="fa fa-group page-header-icon text-primary"></i>&nbsp;
            COTIZACIÓN / Administrador
        </h1>
        <div class="col-xs-12 col-sm-6">
            <div class="row">
                <hr class="visible-xs no-grid-gutter-h">        
                {{-- {!! $loadImgDt !!}  --}}                                  
                <div class="pull-right col-xs-12 col-sm-auto">
                <a href="#" class="btn btn-primary btn-labeled" style="width: 100%;" onclick="comprobante('-1','2')">
                    <span class="btn-label icon fa fa-plus"></span>Nuevo
                </a>
                </div>
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

                        <div class="col-md-3">
                            <label class="control-label no-margin-b">Cliente:</label>
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
        <!-- / .panel -->
    </div>
</div>   
<div class="" style="margin-top: 10px;" id="mensaje">
    <button type="button" class="close" onclick="eliminaramensaje();">×</button>
    <strong><span id="respuesta"></span></strong>
</div>
<div class="table-light table-responsive">
    {{-- <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example"> --}}
    <table class="table table-bordered table-striped table-hover table-condensed dataTable no-footer" id="jq-datatables-{{ $nameModule }}" width="100%">
			<thead>
				 <tr>
                    <th style="text-align: center;">EMPLEADO</th>
                    <th style="text-align: center;">FECHA</th> 
                    <th style="text-align: center;">NUM.</th>
                    <th style="text-align: center;">RUC, DNI, ETC</th> 
                    <th style="text-align: center;">CLIENTE</th>         
                    <th style="text-align: center;">M</th> 
                    <th style="text-align: center;">TOTAL</th>
                    <th style="text-align: center;">CORREO</th>
                    <th style="text-align: center;">PDF</th>
                    <th style="text-align: center;">ACCIÓN</th>              
                    <th ></th>
				</tr>	
			</thead>
        <tbody>
        </tbody>
    </table>
</div>
<hr class="no-grid-gutter-h">
<br><br><br><br>

<div id="modal-{{ $nameModule }}" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-max">
        <div class="modal-content" id="content-modal-{{ $nameModule }}">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->

<div id="modal-{{ $nameModule }}-detalle" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-max">
        <div class="modal-content" id="content-modal-{{ $nameModule }}-detalle"">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->

<div id="modal-{{ $nameModule }}-sm" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content" id="content-modal-{{ $nameModule }}-sm">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->

<div id="modal-cliente" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="content-modal-cliente">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->

<div id="modal-reporte-comprobante" class="modal fade" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog " style="width: 800px;">
        <div class="modal-content" id="content-modal-reporte-comprobante">
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<script>
init.push(function () {        
    $("#mensaje").hide();
    $("#cli").select2({
        allowClear: true,
        placeholder: "SELECCIONE...",
        //minimumInputLength: 3,
        //multiple: false,
    });

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
                "fecFin": fecFin,
                "cli": $("#cli").val(),
                "doc": $("#doc").val()
            });
            var ajax_source = "{{ url('api') }}.{{ $nameModule }}?" + query_string;
            oTable.ajax.url(ajax_source).load();
        } 
    });
   
});

/* DataTable */
$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource ) {
    if ( typeof sNewSource != 'undefined' )
        oSettings.sAjaxSource = sNewSource;
 
    this.fnClearTable( this );
    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
 
    $.getJSON( oSettings.sAjaxSource, null, function(json) {
        for ( var i=0 ; i<json.aaData.length ; i++ ) {
            that.oApi._fnAddData( oSettings, json.aaData[i] );
        }

        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        that.fnDraw( that );
        that.oApi._fnProcessingDisplay( oSettings, false );
    });
}

var oTableOptions = {
    "ordering": false,
    //"lengthMenu": [ [10, 20, 50], [10, 20, 50] ],
    "lengthMenu": [ [10, 15, 20, -1], [10, 15, 20, "Todos"] ],
    "pageLength": 10,
    "processing": true,
    "serverSide": true,
    "pagingType": "full_numbers",
    "stateSave": false,
    
    "ajax":{
        "url": "{{ url('api') }}.{{ $nameModule }}",
        "data": function ( d ) {
            return $.extend( {}, d, {
                "_token": "{{ csrf_token() }}"
            });
        }, 
        "type": "POST",
            /*"data": function ( d ) {
                d.extra_search = $('#extra').val();
            }*/
    },

    "columnDefs": 
    [
        {"targets": 0, 'data': 'empleado', 'name':'empleado'},
        {"targets": 1, 'data': 'f_hor_fac', 'name':'f_hor_fac'},
        {"targets": 2, 'data': 'correlativo', 'name':'correlativo'},
        {"targets": 3, 'data': 'c_num_doc', 'name':'c_num_doc', 'orderable': false},
		{"targets": 4, 'data': 'c_raz', 'name':'c_raz', "class": "col-md-4"},
		{"targets": 5, 'data': 'moneda', 'name':'moneda', 'orderable': false},
        {"targets": 6, 'data': 'n_tot', 'name':'n_tot', 'orderable': false},
        {"targets": 7, 'data': 'correo', 'name':'correo', 'orderable': false,'class': 'text-center'},
        {"targets": 8, 'data': 'pdf', 'name':'pdf', 'orderable': false},
        {"targets": 9, 'data': 'estado', 'name':'estado', 'orderable': false,'class': 'text-right'},
        {"targets": 10, 'data': 'action', 'name': 'action', 'orderable': false, 'searchable': false}
        
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
    "sDom": '<"table-header padding-xs-vr no-margin-hr clearfix" <"table-caption"> <"clear"T> <"DT-lf-right" <"DT-per-page"l> <"DT-search"f> > > t <"table-footer padding-xs-hr clearfix" <"DT-label"i> <"DT-pagination"p> >',
    
};

var oTable = $('#jq-datatables-{{ $nameModule }}').DataTable(
    oTableOptions
);

$('#jq-datatables-{{ $nameModule }} tbody').on( 'dblclick', 'tr', function () {
    var data = oTable.row($(this)).data(); 
    var idJson = JSON.stringify(data.pk_cpb_id);
    var id = idJson.replace(/['"]+/g, '');
    detalleComprobante(id) 
}); 
function comprobante(id,id2) {
    var data = "";

    $('#modal-{{ $nameModule }}').modal({
        show:true 
    });

    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");                                   
        },
        type: "GET",
        cache: false,
        url : '{{ url($nameModule.'/create') }}/'+id+'/'+id2,
        data: data,
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
};

function clienteConCorreo(id){
    bootbox.confirm({
        title: "¿Seguro(a) de enviar correo?",
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
                    url : '{{ url($nameModule.'/correo') }}',
                    data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                    },
                    success : function(datos_json) {
                        if (datos_json.success != false) {
                            //alert(datos_json.result["message"]);
                            $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();
                            $("#mensaje").show();
                            var estado="alert alert-success";
                            $("#mensaje").attr("class", estado);
                            $("#respuesta").text(datos_json.result);
                        }else{
                            alert("Error");
                        }
                    },
                    error : function(data) {
                        $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo enviar correo!" , size: 'large' });  
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

function correo(id,id2){
    $('#modal-{{ $nameModule }}-sm').modal({
        show:true 
    });

    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}-sm").html("{!! $loadImg !!}");                                   
        },
        type: "GET",
        cache: false,
        url: "{{ url($nameModule.'/createCorreo') }}/"+id+"/"+id2,
        success: function(response){
            if (response != "false") {
                $('#content-modal-{{ $nameModule }}-sm').html(response);    
            }else{
                alert("No se cre&oacute; correo "+response.error);
            }
        },
        error: function(e){
            $.growl.error({
                title: "Error: " + e.status + " " + e.statusText ,
                message: "No es posible cargar el formulario! <br />Vuelva a intertarlo en un momento",
                size: 'large'
            });
            setTimeout(function(){
                $("#content-modal-{{ $nameModule }}-sm").html('');
                $('#modal-{{ $nameModule }}-sm').modal('hide');
            }, 4000);       
        },
        dataType : 'html'
    });
    return false;

}

$("#loadData").on('click', function() {
    oTable.ajax.url("{{ url('api') }}.{{ $nameModule }}/"+$("#doc").val()).load();
})



function documentoAnulado(id){
    var data = "";
    $('#modal-{{ $nameModule }}').modal({
        show:true 
    });

    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");                                   
        },
        type: "GET",
        cache: false,
        url : '{{ url($nameModule.'/createAnulado') }}/'+id,
        data: data,
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

function documentoAnuladoBoleta(id){
    var data = "";
    $('#modal-{{ $nameModule }}').modal({
        show:true 
    });

    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}").html("{!! $loadImg !!}");                                   
        },
        type: "GET",
        cache: false,
        url : '{{ url($nameModule.'/createAnuladoBoleta') }}/'+id,
        data: data,
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


function detalleComprobante(id){
    var data = "";
    $('#modal-{{ $nameModule }}-detalle').modal({
        show:true 
    });
    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}-detalle").html("{!! $loadImg !!}");                 
        },
        type: "GET",
        cache: false,
        url : '{{ url($nameModule.'/detalleComprobante/') }}/'+id,
        data: data,
        success: function(response){
            if (response != "false") {
                $('#content-modal-{{ $nameModule }}-detalle').html(response);
            }else{
                alert("No se pudo mostrar el formulario");
            }
        },
        error: function(e){
            $.growl.error({
                title: "Error: " + e.status + " " + e.statusText ,
                message: "No es posible cargar el formulario! <br />Vuelva a intertarlo en un momento",
                size: 'large'
            });
            setTimeout(function(){
                $("#content-modal-{{ $nameModule }}-detalle").html('');
                $('#modal-{{ $nameModule }}-detalle').modal('hide');
            }, 4000);       
        },
        dataType : 'html'
    });
    return false;    
}

function actualizarComprobante(id,id2){
    var data = "";
    $('#modal-{{ $nameModule }}-detalle').modal({
        show:true 
    });
    $.ajax({
        beforeSend: function(){
            $("#content-modal-{{ $nameModule }}-detalle").html("{!! $loadImg !!}");                 
        },
        type: "GET",
        cache: false,
        url: "{{ url('/comprobante') }}/"+id+"/"+id2+"/edit",
        data: data,
        success: function(response){
            if (response != "false") {
                $('#content-modal-{{ $nameModule }}-detalle').html(response);
            }else{
                alert("No se pudo mostrar el formulario");
            }
        },
        error: function(e){
            $.growl.error({
                title: "Error: " + e.status + " " + e.statusText ,
                message: "No es posible cargar el formulario! <br />Vuelva a intertarlo en un momento",
                size: 'large'
            });
            setTimeout(function(){
                $("#content-modal-{{ $nameModule }}-detalle").html('');
                $('#modal-{{ $nameModule }}-detalle').modal('hide');
            }, 4000);       
        },
        dataType : 'html'
    });
    return false; 
}

function eliminaramensaje(){
    $("#mensaje").hide();
}

function cerrar(){
    $("#content-modal-{{ $nameModule }}").html("");  
    $('#modal-{{ $nameModule }}').modal('toggle');

}

function deleteComprobante(id, id2){
    bootbox.confirm({
    title: "Seguro de eliminar borrador?",
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
            eliminarComprobante(id, id2);
        }
    },
    className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
    locale: "es",
    closeButton: false,
   });
}
    
function eliminarComprobante(id, id2){
    var token = "{{ csrf_token() }}";
    $.ajax({
        beforeSend: function(){
        },
        headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        url: "{{ url('/comprobante') }}/"+id,
        //data : data,
        success : function(datos_json) {             
            if (datos_json.success != false) {
                $.growl.notice({
                    title: "Mensaje:",
                    message: "Se eliminó; comprobante:<br />NÚMERO: "+id2,
                    size: 'large'
                });
                 
            }else{
                $.growl.warning({
                    title: "Mensaje:",
                    message: "No se puede eliminar el registro porque tiene relacion con otras tablas",
                    size: 'large'
                });
            }
            $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();   
        },
        error : function(data) {
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo eliminar borrador!" , size: 'large' });     
        },

        dataType : 'json'
    });
}





</script>
@stop
