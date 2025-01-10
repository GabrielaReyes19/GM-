<?php 
    $loadImg = "<img src=".URL::to('/')."/public/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
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
                    {{-- <div id="cliTel_show"></div> --}}
                    <div id="cliCor_show"></div>
                </div>
            </div>
        </div>
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="control-label">Tipo de Documento:</label>
                    <select id="cliTip" name="cliTip" class="form-control">
                        @foreach($documents as $document)
                            @if($document->pk_tip_doc_id == 2)
                                <option value="{{ $document->pk_tip_doc_id }}">{{ $document->c_nom }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Número de RUC:</label>
                    <input type="text" class="form-control" id="cliDoc" name="cliDoc" autocomplete="off" autofocus=""> 
                </div>  
            </div>
            <div class="col-md-3">
                <label class="control-label" for="tal_nom">Acciones</label><br />
                <div id="btnBusqueda">
                    <button type="button" title="Consulta Ruc Sunat" class="btn btn-outline btn-success add-tooltip" data-placement="bottom" id="" onclick="busqueda();">
                        <span class="btn-label icon fa fa-search"></span>
                    </button>
                </div>
                <div id="preloadBuscador"></div>

{{--                 <button type="button" title="Ver Ficha Ruc Sunat" class="btn btn-outline btn-success add-tooltip" data-placement="bottom" id="" onclick="modalSunat();">
                    <span class="btn-label icon fa fa-eye"></span>
                </button> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Ruc:</label>
                    <input type="text" class="form-control" id="cliDocSunat" name="cliDocSunat" autocomplete="off" />
                </div> <!-- / .form-group -->
            </div> 
            <div class="col-md-8">
                <div class="form-group has-feedback">
                    <label class="control-label" for="tal_nom">Raz&oacute;n Social:</label>
                    <input type="text" class="form-control" id="razNom" name="razNom" autocomplete="off"/>
                </div> <!-- / .form-group -->
            </div>  
        </div>

        <div class="row" id="nomAp">
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

        <div class="row" >
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Departamento:</label>
                    <div id="cargaDepartamento">
                        <select id="departamento" name="departamento" class="form-control" onchange="cboProvincia()">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div> 
             
            <div class="col-md-4" >
                <div class="form-group no-margin" >
                    <label class="control-label" >Provincia:</label>
                    <div id="cargaProvincia">
                        <select id="provincia" name="provincia" class="form-control">
                            <option></option>
                        </select>
                    </div>          
                </div>
            </div>
            
            <div class="col-md-4 no-margin" >
                <div class="form-group">
                    <label class="control-label">Distrito:</label>
                    <div id="cargaDistrito">
                        <select id="distrito" name="distrito" class="form-control">
                            <option></option>
                        </select>
                    </div>
                </div>
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
            <input type="hidden" name="est" value="1">
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
        $("#provincia").select2({
            // allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });
        $("#distrito").select2({
            // allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });
        cboDepartamento("-1");
        $("#nomAp").hide();
        $('.add-tooltip').tooltip();
        $('#cliDoc').keyup(function (){
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
            'cliDocSunat': {
                required: true
            },
            'razNom': {
                required: true
            },
            // 'cliTip': {
            //     required: true
            // },
            // 'cliDoc': {
            //     required: true
            // },
            // 'cliCor': {
            //     ecliCor: true
            // },
            'departamento': {
                required: true,
            },  
            'provincia': {
                required: true,
            },
            'distrito': {
                required: true,
            }, 
            'cliDir': {
                required: true,
            },        
        },
        messages: {
            'cliDocSunat': 'Requerido',
            'razNom': 'Requerido',
            //'cliTip': 'Seleccione',
            //'cliDoc': 'Requerido',
            // 'cliCor': 'Ingrese un correo v&aacute;lido',
            'departamento': 'Seleccione',
            'provincia': 'Seleccione',
            'distrito': 'Seleccione',
            'cliDir': 'Requerido',
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
                        create{{ $nameModule }}();                  
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
            });
        
        }
    });

     function create{{ $nameModule }}(){
        mensaje="Se guardó; cliente:<br />Nombre: " + $("#razNom").val();

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
                        message: "Se guard&oacute; cliente:<br />Nombre: " + $("#razNom").val(),
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
                    
                    // $.growl.warning({
                    //     title: "Mensaje:",
                    //     message: "El n&uacute;mero de documento ya exite en la base de datos: <br />N° Doc: "+ $("#cliDoc").val(),
                    //     size: 'large'
                    // });
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
    
    function busqueda(){        
        if($("#cliTip").val()==""){
            $.growl.warning({
                title: "Mensaje:",
                message: "Seleccione tipo de documento",
                size: 'large'
            });
        }else if($("#cliDoc").val()==""){
            $.growl.warning({
                title: "Mensaje:",
                message: "El n&uacute;mero de documento es requerido",
                size: 'large'
            });
        }else if($("#cliTip").val()=="2"){
            if($("#cliDoc").val().length<11 || $("#cliDoc").val().length>11){
                $.growl.warning({
                    title: "Mensaje: N° de RUC incorrecto",
                    message: "RUC: 11 caracteres",
                    size: 'large'
                });     
            }else{
                sunatJson();
            }
        }else if($("#cliTip").val()=="1"){
            if($("#cliDoc").val().length<8 || $("#cliDoc").val().length>8){
                $.growl.warning({
                    title: "Mensaje: N° de DNI incorrecto",
                    message: "DNI: 8 caracteres",
                    size: 'large'
                });    
            }else{
                sunatJson();
            }
        }
    }
        
    function modalSunat(){
        if($("#cliTip").val()==""){
            $.growl.warning({
                title: "Mensaje:",
                message: "Seleccione tipo de documento",
                size: 'large'
            });
        }else if($("#cliDoc").val()==""){
            $.growl.warning({
                title: "Mensaje:",
                message: "El n&uacute;mero de documento es requerido",
                size: 'large'
            });
        }else if($("#cliTip").val()=="2"){
            if($("#cliDoc").val().length<11 || $("#cliDoc").val().length>11){
                $.growl.warning({
                    title: "Mensaje: N° de RUC incorrecto",
                    message: "RUC: 11 caracteres",
                    size: 'large'
                });     
            }else{
                sunat();
            }
        }else if($("#cliTip").val()=="1"){
            if($("#cliDoc").val().length<8 || $("#cliDoc").val().length>8){
                $.growl.warning({
                    title: "Mensaje: N° de DNI incorrecto",
                    message: "DNI: 8 caracteres",
                    size: 'large'
                });    
            }else{
                sunat();
            }
        }
    
    }
    function sunat(){
        //var data = "id="+$("#cliDoc").val();
        $('#modal-{{ $nameModule }}-sm').modal({
            show:true 
        });
        $.ajax({
            beforeSend: function(){
                $("#content-modal-{{ $nameModule }}-sm").html("{!! $loadImg !!}");                                    
            },
            type: "GET",
            cache: false,
            url: "{{ url('sunat.createSunat') }}/"+$("#cliDoc").val(),
            //data: data,
            success: function(response){
                if (response != "false") {
                    $('#content-modal-{{ $nameModule }}-sm').html(response);            
                }else{
                    alert("No se creo el cliente "+response.error);
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
    }
    
    function sunatJson(){
        $.ajax({
            beforeSend: function(){
                $('#btnBusqueda').hide(); 
                $("#preloadBuscador").html("{!! $loadImg !!}"); 
                activarCampos();
            },
            type : 'GET',
            url : '{{ url('sunat.cliente') }}/'+$("#cliDoc").val(),
            // data: { 
            //     id:$("#cliDoc").val()
            // },
            success : function(datos_json) {    
                if (datos_json.success != false) {
                    var rSocial=datos_json.result['razonSocial'];
                    $("#razNom").val(rSocial);
                    $("#cliDir").val(datos_json.result['direccion']);

                    //$("#cliTel").val(datos_json['result']['Telefono']); 
                    //$("#resultado").val(datos_json['result']['Tipo']); 
                    $("#cliDocSunat").val(datos_json.result['ruc']);  
                    if(datos_json.result['direccion']==""){
                        cboDepartamento(15);
                        cboProvincia(1501,15)
                        cboDistrito(150101,1501);
                    }else{
                        cboDepartamento(datos_json.result['departamento']);
                        cboProvincia(datos_json.result['provincia'],datos_json.result['departamento'])
                        cboDistrito(datos_json.result['distrito'],datos_json.result['provincia']);
                    }
                    desactivarCampos();
                    $('#cliDocSunat').attr('readonly', true); 
                    $("#preloadBuscador").html(""); 
                    $('#btnBusqueda').show();
                }else{
                    limpiarCampos();
                    if(datos_json.est=="0"){
                        activarCampos();
                        $("#cliDocSunat").val("");
                    }else{
                        $("#cliDocSunat").val($("#cliDoc").val());
                        $('#cliDocSunat').attr('readonly', true);  
                        desactivarCampos();
                        
                    }

                    $.growl.warning({
                        title: "Mensaje:",
                        message: datos_json.msg,
                        size: 'large'
                    });
                    $("#preloadBuscador").html(""); 
                    $('#btnBusqueda').show();
                    // $("#razNom").val("");
                    // $("#cliDir").val("");
                    // $("#cliTel").val(""); 
                    // $("#cliApePat").val(""); 
                    // $("#cliApeMat").val(""); 
                    // $("#name").val(""); 
                }
            },
            error : function(data) {
                $.growl.error({ title: "Error:", message: "No se pudo mostrar los datos del cliente!", size: 'large' });
            },
    
            dataType : 'json'
        }); 
    }

    function activarCampos(){
        $('#cliDocSunat').attr('readonly', true); 
        $('#razNom').attr('readonly', true); 
        $('#cliDir').attr('readonly', true); 
        $('#cliTel').attr('readonly', true); 
        $('#cliCor').attr('readonly', true); 
        $('#cliRep').attr('readonly', true); 
        $('#departamento').attr('disabled', true); 
        $('#provincia').attr('disabled', true); 
        $('#distrito').attr('disabled', true); 
    }

    function desactivarCampos(){
        $("#cliDocSunat").attr("readonly", false); 
        $('#razNom').attr('readonly', false); 
        $('#cliDir').attr('readonly', false); 
        $('#cliTel').attr('readonly', false); 
        $('#cliCor').attr('readonly', false); 
        $('#cliRep').attr('readonly', false); 
        $('#departamento').attr('disabled', false); 
        $('#provincia').attr('disabled', false); 
        $('#distrito').attr('disabled', false); 
    }

    function limpiarCampos(){
        $("#cliDocSunat").val(""); 
        $('#razNom').val(""); 
        $('#cliDir').val(""); 
        $('#cliTel').val(""); 
        $('#cliCor').val(""); 
        $('#cliRep').val("");
        cboDepartamento(-1);
        cboProvincia(-1,-1)
        cboDistrito(-1,-1);
    }

    function cboDepartamento(id){
        $.ajax({
            beforeSend: function(){
            },
            type: "GET",
            url : '{{ url('departamento') }}/'+id,
            success: function(response) {
                $("#cargaDepartamento").html(response);
                
            },
            error: function(e){
                $.growl.error({ title: "Error: " + e.status + " " + e.statusText, message: "No se pudo cargar departamento!" , size: 'large' });
            },            
            dataType: 'html'
        });
    }

    function cboProvincia(id,id2){
        $.ajax({
            beforeSend: function(){
            },
            type: "GET",
            url : '{{ url('provincia') }}/'+id+"/"+id2,
            success: function(response) {
                $("#cargaProvincia").html(response);
            },
            error: function(e){
                $.growl.error({ title: "Error: " + e.status + " " + e.statusText, message: "No se pudo cargar provincia!" , size: 'large' });
            },            
            dataType: 'html'
        });
    }

    function cboDistrito(id,id2){
        $.ajax({
            beforeSend: function(){
            },
            type: "GET",
            url : '{{ url('distrito') }}/'+id+"/"+id2,
            success: function(response) {
                $("#cargaDistrito").html(response);
            },
            error: function(e){
                $.growl.error({ title: "Error: " + e.status + " " + e.statusText, message: "No se pudo cargar distrito!" , size: 'large' });
            },            
            dataType: 'html'
        });
    }
    
</script>

