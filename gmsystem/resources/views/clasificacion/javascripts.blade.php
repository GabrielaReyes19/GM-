<input type="hidden" id="btnText" value="{{$btnText or 'Guardar'}}">
<script type="text/javascript">
    $(document).ready(function (){
        $("#validatorClasificacion").hide();
        $("#est").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });
    });
    $("#modal-cla-{{  $nameModule }}-form").validate({
        //ignore: '.ignore, .select2-input',
        focusInvalid: true,
        rules: {
            'claNom': {
                required: true
            },
        },
        messages: {
            'claNom': 'Requerido',
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
            bootbox.confirm({
                title: "Seguro de guardar clasificaci&oacute;n?",
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
                        create_clasificacion_{{ $nameModule }}();
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
            });
        }   
    });


    function create_clasificacion_{{ $nameModule }}(){
        if($("#btnText").val()=="Guardar"){
            url="{{ url('/clasificacion') }}";
            mensaje="Se creo clasificación: <br />Nombre: " + $("#claNom").val();
        }else{
            url="{{ route('clasificacion.edit', $id)}}";
            mensaje="Se actualizo clasificación: <br />Nombre: " + $("#claNom").val();
        } 


        var data = $("#modal-cla-{{ $nameModule }}-form").serialize();
        $.ajax({
            beforeSend: function(){
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardando...');
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
                    $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardar');
                    $("#{{ $btnName }}").attr({
                        'class': "btn btn-primary btn-outline",
                    });
                    $("#claNom").val("")
                    $("#validatorClasificacion").hide();
                    if($("#btnText").val()!="Guardar"){
                        $('#modal-btn-{{ $nameModule }}').modal('hide');
                    }
                    cboClasificacion('1', '-1');

                }
                else{
                    setTimeout(function () {
                            $('html, #modal-{{ $nameModule }}').animate({scrollTop:0}, 'slow')
                    }, 800);
                    $("#validatorClasificacion").show();
                    cleanValidatorClasificacion();
                    $("#claNom_show").text(datos_json['validar']['claNom']);
                    $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardar');
                    $("#{{ $btnName }}").attr({
                        'class': "btn btn-primary btn-outline",
                    });
                    $("#claNom").val("")
                    $("#claNom").focus() 
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

    function cleanValidatorClasificacion(){
        $("#claNom_show").empty();
    }
</script>