<?php 
    $loadImg = "<img src=".URL::to('/')."/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn-cli".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i class="panel-title-icon fa fa-plus"></i> <span id="titulo">Nuevo Cliente</span></span>
</div>
<div class="modal-body">
    <!-- Default -->
    <form id="modal-cli-{{ $nameModule }}-form">
        {{ csrf_field() }}
        <div class="row" id="validator2">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Se han detectado las siguientes validaciones</strong>
                    <div id="cliDoc_show"></div>
                    <div id="cliTip_show"></div>
                    <div id="razNom_show"></div>
                    <div id="cliApePat_show"></div>
                    <div id="cliApeMat_show"></div>
                    <div id="name_show"></div>
                    <div id="cliDir_show"></div>
                    <div id="cliCor_show"></div>
                </div>
            </div>
        </div>
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Tipo de Documento:</label>
                    <select id="cliTip" name="cliTip" class="form-control" onchange="muestraDni();">
                        @foreach($documents as $document)
                            @if($document->pk_tip_doc_id == 11 || $document->pk_tip_doc_id == 1)
                                @if($document->pk_tip_doc_id == 11)
                                    <option value="{{ $document->pk_tip_doc_id }}" selected="">{{ $document->c_nom }}</option>
                                @else
                                    <option value="{{ $document->pk_tip_doc_id }}">{{ $document->c_nom }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Número de Documento:</label>
                    <input type="text" class="form-control" id="cliDocSunat" name="cliDocSunat" autocomplete="off"/>
                    <input type="hidden" class="form-control" id="razNom" name="razNom" value="-" />
                </div> <!-- / .form-group -->
            </div> 
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="cliApePat" name="cliApePat" autocomplete="off">
                </div> <!-- / .form-group -->
            </div>         
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Apellido Materno:</label>
                    <input type="text" class="form-control" id="cliApeMat" name="cliApeMat" autocomplete="off">
                </div> <!-- / .form-group -->
            </div> 
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" autocomplete="off">
                </div> <!-- / .form-group -->
            </div> 
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Dirección:</label>
                    <textarea cols="" rows="2" class="form-control input-sm" name="cliDir" id="cliDir"></textarea>
                </div> <!-- / .form-group -->
            </div> 
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Teléfono:</label>
                    <input type="text" class="form-control" id="cliTel" name="cliTel" autocomplete="off" />
                    <span class="fa fa-phone form-control-feedback"></span>
                </div> 
            </div>
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Correo:</label>
                    <input type="text" class="form-control" id="cliCor" name="cliCor" autocomplete="off" />
                    <span class="fa fa-envelope form-control-feedback"></span>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Representante:</label>
                    <input type="text" class="form-control" id="cliRep" name="cliRep" autocomplete="off"/>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right tab-content-padding">
            <input type="hidden" name="est" value="1"/>
            <input type="hidden" name="departamento" value="15"/>
            <input type="hidden" name="provincia" value="1501"/>
            <input type="hidden" name="distrito" value="150101"/>
            <button type="submit" class="btn btn-primary btn-outline" id="{{ $btnName }}">
                <span class="btn-label icon fa fa-save"></span> Guardar
            </button>
            <button type="button" class="btn btn-danger btn-outline" id="cer" data-dismiss="modal">
                <span class="btn-label icon fa fa-times"></span> Cerrar
            </button>
        </div>
    </form>
</div>


<script type="text/javascript">
    $(document).ready(function (){
        otro();
        $('#cliDocSunat').attr('readonly', true); 
        $('#cliDocSunat').val("-");
        $('.add-tooltip').tooltip();
        $('#cliDocSunat').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
            //this.value = (this.value + '').replace(/\b0+/g, "");
        });
        $("#validator2").hide();

    });
    
    $("#state").select2({
        //allowClear: true,
        placeholder: "SELECCIONE...",
        //minimumInputLength: 3,
        //multiple: false,
    });
    $("#departamentoId2").select2({
        //allowClear: true,
        placeholder: "SELECCIONE...",
        //minimumInputLength: 3,
        //multiple: false,
    });
    
    $("#cliTip").select2({
        //allowClear: true,
        placeholder: "SELECCIONE...",
        //minimumInputLength: 3,
        //multiple: false,
    });
    $("#modal-cli-{{ $nameModule }}-form").validate({
        //ignore: '.ignore, .select2-input',
        focusInvalid: true,
        rules: {
            'cliTip': {
                required: true
            },
            // 'cliDocSunat': {
            //     required: true
            // },
            // 'cliCor': {
            //     ecliCor: true
            // },
            // 'cliApePat': {
            //     required: true,
            // },  
            // 'cliApeMat': {
            //     required: true,
            // },
            'name': {
                required: true,
            }, 
            // 'cliDir': {
            //     required: true,
            // },        
        },
        messages: {
            'cliTip': 'Seleccione',
            //'cliDocSunat': 'Requerido',
            // 'cliCor': 'Ingrese un correo v&aacute;lido',
            // 'cliApePat': 'Requerido',
            // 'cliApeMat': 'Requerido',
            'name': 'Requerido',
            //'cliDir': 'Requerido',
        },
        submitHandler: function(form) {
            $("#{{ $btnName }}").attr({
                'class': "btn btn-primary btn-outline disabled",
            });
            setTimeout(function(){
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
            }, 500);
            bootbox.confirm({
                title: "Seguro de guardar cliente?",
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
                        if($("#cliTip").val()=="1"){
                            if($("#cliDocSunat").val().length<8 || $("#cliDocSunat").val().length>8){
                                $.growl.warning({
                                    title: "Mensaje: Número de Documento incorrecto",
                                    message: "DNI: 8 caracteres",
                                    size: 'large'
                                });    
                            }else{
                                create{{ $nameModule }}();   
                            }
                        }else{
                            create{{ $nameModule }}();  
                        }               
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
            });
        
        }
    });

    function create{{ $nameModule }}(){
        if($("#cliTip").val()=="1"){
            if($("#cliApePat").val()=="" || $("#cliApeMat").val()==""){
                alert("El apellido paterno y materno no pueden quedar vacíos");
                return false;
            }    
        }
        var data = $("#modal-cli-{{ $nameModule }}-form").serialize();
        $.ajax({
            beforeSend: function(){
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardando...');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline disabled",
                });          
            },
            type : 'POST',
            url : "{{ url('/cliente') }}",
            data : data,
            success : function(datos_json) {  
                if (datos_json.success != false) {
                    $.growl.notice({
                        title: "Mensaje:",
                        message: "Se guard&oacute; cliente:<br />Nombre: " + $("#cliApePat").val()+" "+$("#cliApeMat").val()+" "+$("#name").val(),
                        size: 'large'
                    });
                    // $("{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                    // $("{{ $btnName }}").attr({
                    //     'class': "btn btn-primary btn-outline",
                    // });
                    $('#modal-cliente').modal('hide');
                    cboCliente(datos_json.id);           
                }else{
                    setTimeout(function () {
                            $('html, #modal-{{ $nameModule }}').animate({scrollTop:0}, 'slow')
                    }, 800);
                    $("#validator2").show();
                    cleanValidator();
                    $("#cliDoc_show").text(datos_json['validar']['cliDocSunat']);
                    $("#cliTip_show").text(datos_json['validar']['cliTip']);
                    $("#razNom_show").text(datos_json['validar']['razNom']);
                    $("#cliApePat_show").text(datos_json['validar']['cliApePat']);
                    $("#cliApeMat_show").text(datos_json['validar']['cliApeMat']);
                    $("#name_show").text(datos_json['validar']['name']);
                    $("#cliDir_show").text(datos_json['validar']['cliDir']);
                    // $("#cliTel_show").text(datos_json['validar']['cliTel']);
                    $("#cliCor_show").text(datos_json['validar']['cliCor']);
                    
                    $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                    $("#{{ $btnName }}").attr({
                        'class': "btn btn-primary btn-outline",
                    });
                }
            },
            error : function(data) {
                $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo guardar cliente!" , size: 'large' });
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });     
            },
            dataType : 'json'
        });
    }

 

    function cleanValidator(){
        $("#cliDoc_show").empty();
        $("#cliTip_show").empty();
        $("#razNom_show").empty();
        $("#cliApePat_show").empty();
        $("#cliApeMat_show").empty();
        $("#name_show").empty();
        $("#cliDir_show").empty();
        $("#cliTel_show").empty();
        $("#cliCor_show").empty();
    }

    function muestraDni(){
        if($("#cliTip").val()=="1"){
            $('#cliDocSunat').val("");
            $('#cliApePat').val("");
            $('#cliApeMat').val("");
            $('#cliApePat').attr('readonly', false); 
            $('#cliApeMat').attr('readonly', false); 
            $('#cliDocSunat').attr('readonly', false); 
        }else{
            otro();
            $('#cliDocSunat').attr('readonly', true); 
        }
    }


    function otro(){
        $('#cliApePat').val("-");
        $('#cliApeMat').val("-");
        $('#cliApePat').attr('readonly', true); 
        $('#cliApeMat').attr('readonly', true); 
        $.ajax({
            beforeSend: function(){
            },
            type : 'GET',
            url : '{{ url('cliente.otros') }}',
            // data: { 
            //     id:$("#cliDoc").val()
            // },
            success : function(datos_json) {    
                if (datos_json.success != false) {
                    $('#cliDocSunat').val(datos_json.correlativo);
                    // var rSocial=datos_json.result['razonSocial'];
                }
            },
            error : function(data) {
                $.growl.error({ title: "Error:", message: "No se pudo mostrar los datos!", size: 'large' });
            },
    
            dataType : 'json'
        }); 

   
    }
</script>

