<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus" style="font-size: 25px;"></i> <span id="titulo" style="font-size: 28px;">GENERAR RESUMEN DIARIO</span></span>
</div>
<div class="modal-body">
    <form id="modal-{{ $nameModule }}-form">
        <div class="alert alert-success" style="margin-top: 10px;" >
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong><span id="">IMPORTANTE: Con esta opción se genera uno o varios resúmenes. Es posible que tenga que usar esta opción si emite documentos con fecha pasada.</span></strong>
        </div>

        <div class="row" id="validatorCreate">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <strong>Se han detectado las siguientes validaciones</strong>
                    <div id="detalle_show"></div>
                </div>
            </div>
        </div>

    	<div class="row">
            <div class="col-md-12">
                <div class="panel panel-info" style="margin-bottom: 0px;">
                    <div class="panel-heading padding-xs-hr no-padding-vr">
                            <span class="panel-title">Selecciona cuidadosamente el día.</span>
                    </div>
                    <div class="panel-body padding-xs-vr padding-xs-hr text-xs ">
                        <div class="row" style="padding-bottom:0px">
                            <div class="col-md-2">
                                <label class="control-label no-margin-b">Fecha</label>
                                <div class="input-group date" id="fecha">
                                    <input type="text" class="form-control input-sm" id="fecEmision" name="fecEmision" autocomplete="off" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label class="control-label no-margin-b"> &nbsp; </label>
                                <button type="button" class="btn btn-success btn-block" id="loadData2">
                                    <span class="fa fa-search"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> 

        {{ csrf_field() }}
        <div class="table-light table-responsive">
            <table class="table table-bordered table-striped table-hover table-condensed dataTable no-footer" id="jq-datatables-{{ $nameModule }}-referencia" width="100%">
                    <thead>
                         <tr>
                            <th style="text-align: center;">FECHA DE DOCUMENTO</th>
                            <th style="text-align: center;">TIPO</th>
                            <th style="text-align: center;">SERIE</th>
                            <th style="text-align: center;">NÚMERO</th>
                            <th style="text-align: center;">CLIENTE</th>   
                            <th style="text-align: center;">MONEDA</th>          
                            <th style="text-align: center;">TOTAL</th>          
                        </tr>   
                    </thead>
                <tbody>
                </tbody>
            </table>
        </div> 
        <input type="hidden" name="filas" id="filas" value="0">
        <input type="hidden" name="fecGeneracion" id="fecGeneracion">
        <div class="panel-footer text-right tab-content-padding">
            <button type="submit" class="btn btn-primary btn-outline" id="{{ $btnName }}">
                <span class="btn-label icon fa fa-save"></span> Guardar
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function (){
        $("#validatorCreate").hide();
        fechaActual();
        $('#fecEmision').datepicker(
        {
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es-ES',
            todayHighlight: true,
            endDate: '+0',
            weekStart: 0
            
        }); 

        $('#fecGeneracion').datepicker(
        {
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es-ES',
            todayHighlight: true,
            endDate: '+0',
            weekStart: 0
            
        }); 

    });  

    function fechaActual(){
        var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1; //hoy es 0!
        var yyyy = hoy.getFullYear();
        if(dd<10) {
            dd='0'+dd
        } 
        if(mm<10) {
            mm='0'+mm
        } 
        hoy = dd+'/'+mm+'/'+yyyy;
        $("#fecEmision").val(hoy);
        $("#fecGeneracion").val(hoy);
    } 

var oTableOptions2 = {
    "order": [[ 0, "ASC" ]],
    //"lengthMenu": [ [10, 20, 50], [10, 20, 50] ],
    "lengthMenu": [ [10, 15, 20, -1], [10, 15, 20, "Todos"] ],
    "pageLength": 100,
    "processing": true,
    "serverSide": true,
    "pagingType": "full_numbers",
    "stateSave": false,
    
    "ajax":{
    "url": "{{ url('api') }}.{{ $linkBaseModule }}/0000-00-00",
    "type": "GET",
        /*"data": function ( d ) {
            d.extra_search = $('#extra').val();
        }*/
    },

    "columnDefs": 
    [
        {"targets": 0, 'data': 'f_hor_fac', 'name': 'f_hor_fac', "class": "col-md-2", "orderable": false},
        {"targets": 1, 'data': 'c_des', 'name':'c_des', "class": "col-md-3", "orderable": false},
        {"targets": 2, 'data': 'c_num_ser', 'name':'c_num_ser', "class": "col-md-1", "orderable": false},
        {"targets": 3, 'data': 'numero', 'name':'numero', "class": "col-md-1"},
        {"targets": 4, 'data': 'cliente', 'name':'cliente', "class": "col-md-4", "orderable": false},
        {"targets": 5, 'data': 'c_abr', 'name':'c_abr', "class": "col-md-1", "orderable": false},
        {"targets": 6, 'data': 'n_tot', 'name':'n_tot', "class": "col-md-1", "orderable": false},
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
    "sDom": ' t <"padding-xs-hr" <"table-caption no-padding"> <"clear"T> <"DT-lf-right"> > t <"table-footer padding-xs-hr clearfix" <"DT-label"i> <"DT-pagination"p> >',
            "oTableTools": {        
        "aButtons": [
        ]           
    }    
};

var oTable2 = $('#jq-datatables-{{ $nameModule }}-referencia').DataTable(
    oTableOptions2
);

$('#jq-datatables-{{ $nameModule }}-referencia').on( 'draw.dt', function () {

});

$("#loadData2").on('click', function() {
    var f = $("#fecEmision").val();
    var fields = f.split("/");
    var dia = fields[0];
    var mes = fields[1];
    var anio = fields[2];
    var fechaEmision = anio+"-"+mes+"-"+dia;

    oTable2.ajax.url("{{ url('api') }}.{{ $linkBaseModule }}/"+fechaEmision).load();
    contar(fechaEmision);
 })

function contar(fecha){
    $.ajax({
        beforeSend: function(){
        },
        type : 'GET',
        url : '{{ url($linkBaseModule.'/contar') }}/'+fecha,
        success : function(datos_json) {
            if (datos_json.success != false) {
                $("#filas").val(datos_json.result);
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


$("#modal-{{ $nameModule }}-form").validate({
    //ignore: '.ignore, .select2-input',
    focusInvalid: true,
     rules: {
        'fecEmision': {required: true},   
     },
        
     messages: {
        'fecEmision': 'Requerido',   
     },

    submitHandler: function(form) {
        $("#{{ $btnName }}").attr({
            'class': "btn btn-primary btn-outline disabled",
        });
        setTimeout(function(){
            $("#{{ $btnName }}").attr({
                'class': "btn btn-primary btn-outline",
            });
        }, 200);
        guardarResumenDiario();
    }
});



function guardarResumenDiario(){
    if($("#filas").val()!="0"){
        $("#validatorCreate").hide();
        bootbox.confirm({
            title: "Seguro(a) de generar resumen diario?",
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
                    createSend();
                }
            },
            className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
            locale: "es",
            closeButton: false,
           });
    }else{
        $("#validatorCreate").show();
        setTimeout(function () {
            $('html, #modal-{{ $nameModule }}').animate({scrollTop:0}, 'slow')
        }, 800);
        $("#detalle_show").text("- Es probable que no existan registros que generar");
    }
}


function createSend(){
    var data = $("#modal-{{ $nameModule }}-form").serialize();
    $.ajax({
        beforeSend: function(){
            $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardando...');
            $("#{{ $btnName }}").attr({
                'class': "btn btn-primary btn-outline disabled",
            });
        },
        type : 'POST',
        url : '{{ url('/resumen_diario') }}',
        data : data,
        success : function(datos_json) {
            if (datos_json.success != false) {
                $("#mensaje").show();
                var estado="alert alert-success";
                $("#mensaje").attr("class", estado);
                $("#respuesta").text(datos_json.message);
  
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
                $('#modal-{{ $nameModule }}').modal('hide');
                $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable()
            }else{
                alert("Error");
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
            }
        },
        error : function(data) {
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo generar Resumen Diario!" , size: 'large' });
            $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
            $('#{{ $btnName }}').attr({
                'class': "btn btn-primary btn-outline",
            });     
        },

        dataType : 'json'
    });
}

</script>

