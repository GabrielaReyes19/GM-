<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus" style="font-size: 25px;"></i> <span id="titulo" style="font-size: 28px;">Agregar documento para ANULAR o COMUNCAR DE BAJA</span></span>
</div>
<div class="modal-body">
    <form id="modal-{{ $nameModule }}-form">
        <div class="alert alert-success" style="margin-top: 10px;" >
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong><span id="">Verifica la información antes de guardarla e indica el motivo de la anulación</span></strong>
        </div>
        <div class="row" style="padding-bottom:0px">
            <div class="col-md-2">
                <label class="control-label no-margin-b">Número:</label>
                <input type="text" class="form-control" maxlength="10" id="num" name="num" autocomplete="off" value="{{ $correlativo }}" readonly="" />
            </div>

            <div class="col-md-2">
                <label class="control-label no-margin-b">Fecha de emisión:</label>
                <div class="form-group has-feedback no-padding">
                    <div class="input-group date" id="fecha">
                        <input type="text" class="form-control input-sm" id="fecEmision" name="fecEmision" value=""/>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label class="control-label no-margin-b">Fecha de generación:</label>
                <div class="form-group has-feedback no-padding">
                    <div class="input-group date" id="fecha">
                        <input type="text" class="form-control input-sm" id="fecGeneracion" name="fecGeneracion" value=""/>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
        </div> 

    	<div class="row">
            <div class="col-md-12">
                <div class="panel panel-info" style="margin-bottom: 0px;">
                    <div class="panel-heading padding-xs-hr no-padding-vr">
                            <span class="panel-title">Búsqueda de Comprobantes emitidos</span>
                    </div>
                    <div class="panel-body padding-xs-vr padding-xs-hr text-xs ">
                        <div class="row" style="padding-bottom:0px">
                            <div class="col-md-2">
                                <label class="control-label no-margin-b">Fecha</label>
                                <div class="input-group date" id="fecha">
                                    <input type="text" class="form-control input-sm" id="fReferencia" name="fReferencia" autocomplete="off" />
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
                            <th ></th>
                            <th style="text-align: center;">DOCUMENTO</th>
                            <th style="text-align: center;">CLIENTE</th>            
                            <th style="text-align: center;">FECHA</th>
                            <th style="text-align: center;">TOTAL</th>     
                            <th style="text-align: center;">MOTIVO ANULACIÓN</th>       
                        </tr>   
                    </thead>
                <tbody>
                </tbody>
            </table>
        </div> 
        <input type="text" name="filas" id="filas">
    </form>
    <div class="panel-footer text-right tab-content-padding">
        <button type="submit" class="btn btn-primary btn-outline" id="{{ $btnName }}">
            <span class="btn-label icon fa fa-save"></span> Guardar
        </button>
    </div>
</div>
<script type="text/javascript">
    var ids = [];
    $(document).ready(function (){
        fechaActual();
        $('#fReferencia').datepicker(
        {
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es-ES',
            todayHighlight: true,
            endDate: '+0',
            weekStart: 0
            
        }); 

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
        {"targets": 0, 'data': 'check', 'name': 'check', 'orderable': false, 'searchable': false},
        {"targets": 1, 'data': 'documento', 'name': 'documento', "class": "col-md-2"},
        {"targets": 2, 'data': 'cliente', 'name':'cliente', "class": "col-md-2"},
        {"targets": 3, 'data': 'f_hor_fac', 'name':'f_hor_fac'},
        {"targets": 4, 'data': 'total', 'name':'total'},
        {"targets": 5, 'data': 'motivo', 'name':'motivo', "class": "col-md-4"}
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

var oTable2 = $('#jq-datatables-{{ $nameModule }}-referencia').DataTable(
    oTableOptions2
);

$('#jq-datatables-{{ $nameModule }}-referencia').on( 'draw.dt', function () {
       
});

$("#loadData2").on('click', function() {
    var f = $("#fReferencia").val();
    var fields = f.split("/");
    var dia = fields[0];
    var mes = fields[1];
    var anio = fields[2];
    var fechaReferencia = anio+"-"+mes+"-"+dia;

    oTable2.ajax.url("{{ url('api') }}.{{ $linkBaseModule }}/"+fechaReferencia).load();
 })

var num = 0;
function ckeck(id){

    // $("input[id='chk"+id+"']:checked").each(function() {
    //     ids.push($(this).val());
    //     alert($(this).val());
    // });

    if($("input[id='chk"+id+"']").is(":checked")==true){
        num++;
        $("#filas").val(num);
    }else{
        num--;
        $("#filas").val(num);
    }
}

$("#{{ $btnName }}").on('click', function() {
    $("input[id='chk']:checked").each(function() {
        ids.push($(this).val());
    });
    var data = $("#modal-{{ $nameModule }}-form").serialize();
    $.ajax({
        beforeSend: function(){
            $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardando...');
            $("#{{ $btnName }}").attr({
                'class': "btn btn-primary btn-outline disabled",
            });
        },
        type : 'POST',
        url : '{{ url('/documentos_anulados') }}',
        data : data,
        success : function(datos_json) {
            if (datos_json.success != false) {
                $("#mensaje").show();
                $("#respuesta").text("AGREGADO, NO OLVIDES CONSULTAR EL ESTADO DE LA ANULACIÓN EN LA SUNAT LUEGO DE UNOS MINUTOS.");
  
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
                $('#modal-{{ $nameModule }}').modal('hide');
                $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable()
                
                //imprimirFactura($("#idFactura").val(),$("#tipDoc").val());
            }else{
                $.growl.warning({
                    title: "Mensaje:",
                    message: "El n&uacute;mero de documento ya exite en la base de datos:<br/>N° Doc: "+$("#numSer").val()+" - "+$("#numDoc").val(),
                    size: 'large'
                });
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
            }
        },
        error : function(data) {
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo guardar comprobante!" , size: 'large' });
            $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
            $('#{{ $btnName }}').attr({
                'class': "btn btn-primary btn-outline",
            });     
        },

        dataType : 'json'
    });


})




</script>

