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
                <label class="control-label no-margin-b">Fecha de anulación:</label>
                <div class="form-group has-feedback no-padding">
                    <div class="input-group date" id="fecha">
                        <input type="text" class="form-control input-sm" id="fecAnulacion" name="fecAnulacion" value=""/>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <label class="control-label no-margin-b">Fecha de comprobante:</label>
                <div class="form-group has-feedback no-padding">
                    <div class="input-group date" id="fecha">
                        <input type="text" class="form-control input-sm" id="fecComprobante" name="fecComprobante" value="{{ $ComprobanteCabecera[0]->f_hor_fac }}"/>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="control-label no-margin-b">MOTIVO ANULACIÓN:</label>
                <div class="form-group has-feedback no-padding">
                    <textarea cols="" rows="2" class="form-control input-sm" name="mot" id="mot"></textarea>
                </div>
            </div>
        </div> 

        {{ csrf_field() }}

        <div class="table-light">
            <div class="table-header">
                <div class="table-caption">
                    Debes agregar el motivo
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>FECHA DE DOCUMENTO</th>
                        <th>TIPO</th>
                        <th>SERIE</th>
                        <th>NÚMERO</th>
                        <th>CLIENTE</th>
                        <th>MONEDA</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $ComprobanteCabecera[0]->f_hor_fac }}</td>
                        <td>{{ $ComprobanteCabecera[0]->c_des }}</td>
                        <td>{{ $ComprobanteCabecera[0]->c_num_ser }}</td>
                        <td><?php echo str_pad($ComprobanteCabecera[0]->c_doc,7,"0",STR_PAD_LEFT); ?></td>
                        <td>{{ $ComprobanteCabecera[0]->cliente }}</td>
                        <td>{{ $ComprobanteCabecera[0]->c_abr }}</td>
                        <td>{{ $ComprobanteCabecera[0]->n_tot }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    <div class="panel-footer text-right tab-content-padding">
        <input type="hidden" name="id" value="{{ $ComprobanteCabecera[0]->pk_cpb_id }}">
        <button type="submit" class="btn btn-primary btn-outline" id="{{ $btnName }}">
            <span class="btn-label icon fa fa-save"></span> Guardar
        </button>
    </div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function (){
    fechaActual();
    $('#fecComprobante').datepicker(
    {
        format: 'dd/mm/yyyy',
        autoclose: true,
        language: 'es-ES',
        todayHighlight: true,
        endDate: '+0',
        weekStart: 0
        
    }); 

    $('#fecAnulacion').datepicker(
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
    $("#fecAnulacion").val(hoy);
} 

$("#modal-{{ $nameModule }}-form").validate({
    //ignore: '.ignore, .select2-input',
    focusInvalid: true,
     rules: {
        'fecAnulacion': {required: true},
        'fecComprobante': {required: true},    
        'mot': {required: true},     
     },
        
     messages: {
        'fecAnulacion': 'Requerido',   
        'fecComprobante': 'Requerido',
        'mot': 'Requerido',     
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
        guardarDocumentoAnulado();
    }
});

function guardarDocumentoAnulado(){
    bootbox.confirm({
        title: "Seguro(a) de anular comprobante?",
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
               createSend()
            }
        },
        className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
        locale: "es",
        closeButton: false,
    });
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
        url : '{{ url('documentos_anulados') }}',
        data : data,
        success : function(datos_json) {
            if (datos_json.success != false) {
                $("#mensaje").show();
                var estado="alert alert-success";
                $("#mensaje").attr("class", estado);
                $("#respuesta").text("EL COMPROBANTE N° {{ $ComprobanteCabecera[0]->c_num_ser }} - {{ $ComprobanteCabecera[0]->c_doc }} FUE ANULADO SATISFACTORIAMENTE");
  
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
            $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo guardar comprobante!" , size: 'large' });
            $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
            $('#{{ $btnName }}').attr({
                'class': "btn btn-primary btn-outline",
            });   
        },

        dataType : 'json'
    });
}

</script>

