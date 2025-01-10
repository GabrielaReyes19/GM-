<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btnCorreo".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus"></i> <span id="titulo">Envio de Corrro electronico</span></span>
</div>
<div class="modal-body">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <form class="panel form-horizontal" id="modal-{{ $nameModule }}-form-correo">
        {{ csrf_field() }}
{{--         <div class="panel-heading">
            <span class="panel-title">Envio de Corrro electronico</span>
        </div> --}}
        <div class="panel-body">
            <div class="form-group">
                <label for="inputEmail2" class="col-sm-2 control-label">Correos Enviados</label>
                <div class="col-sm-10">
                    @foreach($datosCorreos as $dato)
                        <span>{{ $dato->c_cor }}</span><br>
                    @endforeach 
                </div>
            </div> <!-- / .form-group -->
            <hr>
            <div class="form-group">
                <label for="inputEmail2" class="col-sm-2 control-label">De</label>
                <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control"  value="ventas@gmsystemperu.com">
                </div>
            </div> <!-- / .form-group -->
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Destinatario</label>
                <div class="col-sm-10">
                    @if($id2=="1")
                        <input type="text" readonly="" id="email" name="email" class="form-control" value="{{$comprobante->c_cor}}">
                    @else
                        <input type="text" class="form-control" id="email" name="email">
                    @endif
                </div>
            </div> <!-- / .form-group -->
            <div class="form-group">
                <label for="asdasdas" class="col-sm-2 control-label">Dirigido a</label>
                <div class="col-sm-10">
                    <textarea name="dirigido" class="form-control">Estimad@ {{$comprobante->c_raz}}</textarea>
                </div>
            </div> <!-- / .form-group -->
            <div class="form-group">
                <label for="asdasdas" class="col-sm-2 control-label">Asunto</label>
                <div class="col-sm-10">
                    <textarea name="asunto" class="form-control"></textarea>
                </div>
            </div> <!-- / .form-group -->
            <div class="panel-footer text-right tab-content-padding">
                <input type="hidden" name="id" value="{{ $id }}">
                <button type="submit" class="btn btn-primary btn-outline" id="{{ $btnName }}">
                    <span class="btn-label icon fa fa-save"></span> Enviar
                </button>
            </div>
        </div>
    </form>
</div>


<script type="text/javascript">
    $("#modal-{{ $nameModule }}-form-correo").validate({
        //ignore: '.ignore, .select2-input',
        focusInvalid: true,
         rules: {
            'email': {required: true}      
         },
            
         messages: {
            'email': 'Requerido'  
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
            guardarCorreo();
            //createSend();
        }
    });

     function guardarCorreo(){
        bootbox.confirm({
            title: "Seguro(a) de enviar correo?",
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
                    $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline disabled",
                    });
                   createSend();
                }
            },
            className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
            locale: "es",
            closeButton: false,
        });
    }

    function createSend(){
        var data = $("#modal-{{ $nameModule }}-form-correo").serialize();
        $.ajax({
            beforeSend: function(){
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Enviando...');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline disabled",
                });
            },
            type : 'POST',
            url : '{{ url('/correo') }}',
            data : data,
            success : function(datos_json) {
                if (datos_json.success != false) {
                    $('#modal-{{ $nameModule }}-sm').modal('hide');
                    $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();
                    $("#mensaje").show();
                    var estado="alert alert-success";
                    $("#mensaje").attr("class", estado);
                    $("#respuesta").text(datos_json.result);
                }else{
                   alert("Error al enviar correo"); 
                }
            },
            error : function(data) {
                $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo enviar correo!" , size: 'large' });
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Enviar');
                $('#{{ $btnName }}').attr({
                    'class': "btn btn-primary btn-outline",
                });     
            },

            dataType : 'json'
        });
        
    }

</script>
