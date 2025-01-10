<input type="hidden" id="btnText" value="{{$btnText or 'Guardar'}}">
<script type="text/javascript">
    $(document).ready(function (){
        $("#validatorProducto").hide();
        if($("#btnText").val()=="Guardar"){
            cboClasificacion('2', '-1'); 
            cboMarca('2', '-1');
        }else{
            cboClasificacion('2', '{{ $producto->fk_cla_id }}'); 
            cboCategoria('{{ $producto->fk_cla_id }}','2','{{ $producto->fk_cat_id }}' );
            cboMarca('2', '{{ $producto->fk_mar_id }}');
        }
        $("#clasificacionId").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });

        $("#categoria").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });

        $("#marca").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });

        $("#unidadMedida").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });

        $("#moneda").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });

        $("#est").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });
    });
    $("#modal-{{  $nameModule }}-form").validate({
        //ignore: '.ignore, .select2-input',
        focusInvalid: true,
        // rules: {
        //     'clasificacionId': {
        //         required: true
        //     },
        //     'categoria': {
        //         required: true
        //     },
        //     'proCod': {
        //         required: true
        //     },
        //     'proNom': {
        //         required: true
        //     },
        //     'unidadMedida': {
        //         required: true
        //     },
        //     'moneda': {
        //         required: true
        //     },

        // },
        // messages: {
        //     'clasificacionId': 'Seleccione...',
        //     'categoria': 'Seleccione...',
        //     'proCod': 'Requerido',
        //     'proNom': 'Requerido',
        //     'unidadMedida': 'Requerido',
        //     'moneda': 'Requerido',

        // },
        submitHandler: function(form) {
            $("#{{ $btnName }}").attr({
                'class': "btn btn-primary btn-outline disabled",
            });
            setTimeout(function(){
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
            }, 200);
            bootbox.confirm({
                title: "Seguro de guardar Producto ó Servicio",
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
                        create_{{ $nameModule }}();
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
            });
        }   
    });


    function create_{{ $nameModule }}(){
        if($("#btnText").val()=="Guardar"){
            url="{{ url('/producto') }}";
            mensaje="Se creo producto ó servicio: <br />Nombre: " + $("#proNom").val();
        }else{
            url="{{ route('producto.edit', $id)}}";
            mensaje="Se actualizo producto ó servicio: <br />Nombre: " + $("#proNom").val();
        } 



        var data = new FormData($("#modal-{{ $nameModule }}-form")[0]);
        var token = "{{ csrf_token() }}";
        $.ajax({
            beforeSend: function(){
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardando...');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline disabled",
                });
            },
            type : 'POST',
            headers: {'X-CSRF-TOKEN':token},
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
            cache: false,
            url : url,
            data : data,
            success : function(datos_json) {             
                if (datos_json.success != false) {
                    $.growl.notice({
                        title: "Mensaje:",
                        message: mensaje,
                        size: 'large'
                    });
                    $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardar');
                    $("#{{ $btnName }}").attr({
                        'class': "btn btn-primary btn-outline",
                    });

                    $('#modal-{{ $nameModule }}').modal('hide');
                    $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();
                    //$("#validatorProducto").hide();
                }
                else{
                    setTimeout(function () {
                            $('html, #modal-{{ $nameModule }}').animate({scrollTop:0}, 'slow')
                    }, 800);
                    $("#validatorProducto").show();
                    cleanvalidatorProducto();
                    $("#clasificacionId_show").text(datos_json['validar']['clasificacionId']);
                    $("#categoria_show").text(datos_json['validar']['categoria']);
                    $("#proCod_show").text(datos_json['validar']['proCod']);
                    $("#proNom_show").text(datos_json['validar']['proNom']);
                    $("#unidadMedida_show").text(datos_json['validar']['unidadMedida']);
                    $("#moneda_show").text(datos_json['validar']['moneda']);
                    $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardar');
                    $("#{{ $btnName }}").attr({
                        'class': "btn btn-primary btn-outline",
                    });

                }

            },
            error : function(data) {
                $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo guardar clasificaci&oacute;n!" , size: 'large' });
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardar');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
                $("#claNom").val("")
                $("#claNom").focus()            
            },

            dataType : 'json'
        });
    }

    function cleanvalidatorProducto(){
        $("#clasificacionId_show").empty();
        $("#categoria_show").empty();
        $("#proCod_show").empty();
        $("#proNom_show").empty();
        $("#unidadMedida_show").empty();
        $("#moneda_show").empty();
    }
</script>