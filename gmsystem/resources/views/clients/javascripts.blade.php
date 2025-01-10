<input type="hidden" id="btnText" value="{{$btnText or 'Guardar'}}">
<script type="text/javascript">
    $(document).ready(function (){

        if($("#btnText").val()=="Guardar"){
            cboDepartamento("-1");
        }else{

            cboDepartamento("{{ $cliente->fk_dep_id or -1}}");
            cboProvincia({{ $cliente->fk_pvi_id or -1}}, {{ $cliente->fk_dep_id or -1}})
            cboDistrito({{ $cliente->fk_dis_id or -1}}, {{ $cliente->fk_pvi_id or -1}});
        }
        $('.add-tooltip').tooltip();
        $('#cliDoc').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
            //this.value = (this.value + '').replace(/\b0+/g, "");
        });
        $('#cliDocSunat').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
            //this.value = (this.value + '').replace(/\b0+/g, "");
        });

        $('#cliDoc').focus();
        $("#validator").hide();
    });
    
    $("#est").select2({
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
    $("#modal-{{ $nameModule }}-form").validate({
        //ignore: '.ignore, .select2-input',
        focusInvalid: true,
        rules: {
            'cliTip': {
                required: true
            },
            'cliDocSunat': {
                required: true
            },
            'razNom': {
                required: true
            },   
            'cliDir': {
                required: true
            },
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
            'cliTip': 'Requerido',
            'cliDocSunat': 'Requerido',
            'razNom': 'Requerido',
            'cliDir': 'Requerido',
            'departamento': 'Seleccione',
            'provincia': 'Seleccione',
            'distrito': 'Seleccione',
        },
        submitHandler: function(form) {
            var confirmacion;
            if($("#btnText").val()=="Guardar"){
                confirmacion="Seguro de guardar cliente?";
            }else{
                confirmacion="Seguro de actualizar cliente?";
            }
            $("#{{ $btnName }}").attr({
                'class': "btn btn-primary btn-outline disabled",
            });
            setTimeout(function(){
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
            }, 500);
            bootbox.confirm({
                title: confirmacion,
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
                        if($("#cliTip").val()=="2"){
                            if($("#cliDocSunat").val().length<11 || $("#cliDocSunat").val().length>11){
                                $.growl.warning({
                                    title: "Mensaje: Número de Documento incorrecto",
                                    message: "RUC: 11 caracteres",
                                    size: 'large'
                                });     
                            }else{
                                create{{ $nameModule }}();  
                            }
                        }else if($("#cliTip").val()=="1"){
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
        var url;
        var mensaje;
        if($("#btnText").val()=="Guardar"){
            url="{{ url('/cliente') }}";
            mensaje="Se guard&oacute; cliente:<br />N° Doc: " + $("#cliDoc").val();
        }else{
            url="{{ route('cliente.edit', '-1')}}";
            mensaje="Se actualiz&oacute; cliente: <br />N° Doc: " + $("#cliDocSunat").val();
        }   

        var data = $("#modal-{{ $nameModule }}-form").serialize();
        $.ajax({
            beforeSend: function(){
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardando...');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline disabled",
                });          
            },
            type : 'POST',
            url : url,
            data : data,
            success : function(datos_json) {  
                if (datos_json.success != false) {
                    $.growl.notice({
                        title: "Mensaje:",
                        message: mensaje,
                        size: 'large'
                    });
                    $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                    $("#{{ $btnName }}").attr({
                        'class': "btn btn-primary btn-outline",
                    });
                    $('#modal-{{ $nameModule }}').modal('hide');
                    $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();
                }else{
                    setTimeout(function () {
                            $('html, #modal-{{ $nameModule }}').animate({scrollTop:0}, 'slow')
                    }, 800);
                    $("#validator").show();
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
                    //     message: "El n&uacute;mero de documento ya exite en la base de datos: <br />N° Doc: "+ $("#number").val(),
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
        $("#sunat_show").empty();
    }
    

    function modalSunat(){
        if($("#document_id").val()==""){
            $.growl.warning({
                title: "Mensaje:",
                message: "Seleccione tipo de documento",
                size: 'large'
            });
        }else if($("#number").val()==""){
            $.growl.warning({
                title: "Mensaje:",
                message: "El n&uacute;mero de documento es requerido",
                size: 'large'
            });
        }else if($("#document_id").val()=="2"){
            if($("#number").val().length<11 || $("#number").val().length>11){
                $.growl.warning({
                    title: "Mensaje: N° de RUC incorrecto",
                    message: "RUC: 11 caracteres",
                    size: 'large'
                });     
            }else{
                sunat();
            }
        }else if($("#document_id").val()=="1"){
            if($("#number").val().length<8 || $("#number").val().length>8){
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
            url: "{{ url('cliente.createSunat') }}/"+$("#cliDoc").val(),
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

            },
            type : 'GET',
            url : '{{ url('sunat.cliente') }}/'+$("#cliDoc").val(),
            // data: { 
            //     id:$("#cliDoc").val()
            // },
            success : function(datos_json) {    
                if (datos_json.success != false) {
                    $('#cliTip').val('2').trigger('change.select2');
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
                        $('#cliTip').val('2').trigger('change.select2');
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

    function tipoDocumento(){
        if($('#cliTip').val()=="2"){
            $("#razNom").removeAttr('readonly');
        }else{
            $("#razNom").attr({
                'readonly': ""
            });
            $("#razNom").val("-");
        }
    }

    function activarCampos(){
        $('#cliDocSunat').attr('readonly', true); 
        $('#razNom').attr('readonly', true); 
        $('#cliDir').attr('readonly', true); 
        $('#cliTel').attr('readonly', true); 
        $('#cliCor').attr('readonly', true); 
        $('#cliRep').attr('readonly', true); 
        $('#cliTip').attr('disabled', true); 
        $('#departamento').attr('disabled', true); 
        $('#provincia').attr('disabled', true); 
        $('#distrito').attr('disabled', true); 
        $('#cliApePat').attr('readonly', true); 
        $('#cliApeMat').attr('readonly', true); 
        $('#name').attr('readonly', true); 
    }

    function desactivarCampos(){
        $("#cliDocSunat").attr("readonly", false); 
        $('#razNom').attr('readonly', false); 
        $('#cliDir').attr('readonly', false); 
        $('#cliTel').attr('readonly', false); 
        $('#cliCor').attr('readonly', false); 
        $('#cliRep').attr('readonly', false); 
        $('#cliTip').attr('disabled', false);
        $('#departamento').attr('disabled', false); 
        $('#provincia').attr('disabled', false); 
        $('#distrito').attr('disabled', false); 
        $('#cliApePat').attr('readonly', false); 
        $('#cliApeMat').attr('readonly', false); 
        $('#name').attr('readonly', false); 
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