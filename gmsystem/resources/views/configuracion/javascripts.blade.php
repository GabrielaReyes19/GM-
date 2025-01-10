<input type="hidden" id="btnText" value="{{$btnText or 'Guardar'}}">
<script type="text/javascript">
    $(document).ready(function (){
        $("#validatorMarca").hide();
        $("#est").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });
    });
    $("#modal-mar-{{  $nameModule }}-form").validate({
        //ignore: '.ignore, .select2-input',
        focusInvalid: true,
        rules: {
            'claMar': {
                required: true
            },
        },
        messages: {
            'claMar': 'Requerido',
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
                title: "Seguro de guardar Marca?",
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
                        create_marca_{{ $nameModule }}();
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
            });
        }   
    });


    function create_marca_{{ $nameModule }}(){
        if($("#btnText").val()=="Guardar"){
            url="{{ url('/marca') }}";
            mensaje="Se creo marca: <br />Nombre: " + $("#marNom").val();
        }else{
            url="{{ route('marca.edit', $id)}}";
            mensaje="Se actualizo clasificación: <br />Nombre: " + $("#marNom").val();
        } 


        var data = $("#modal-mar-{{ $nameModule }}-form").serialize();
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
                    $("#marNom").val("");
                    $("#marNom").focus();
                    $("#validatorMarca").hide();
                    if($("#btnText").val()!="Guardar"){
                        $('#modal-btn-{{ $nameModule }}').modal('hide');
                    }
                    cboMarca('1','-1');
                }
                else{
                    setTimeout(function () {
                            $('html, #modal-{{ $nameModule }}').animate({scrollTop:0}, 'slow')
                    }, 800);
                    $("#validatorMarca").show();
                    cleanValidatorMarca();
                    $("#marNom_show").text(datos_json['validar']['marNom']);
                    $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardar');
                    $("#{{ $btnName }}").attr({
                        'class': "btn btn-primary btn-outline",
                    });
                    $("#marNom").val("")
                    $("#marNom").focus() 
                }

            },
            error : function(data) {
                $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo guardar marca" , size: 'large' });
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardar');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
                $("#marNom").val("")
                $("#marNom").focus()            
            },

            dataType : 'json'
        });
    }

    function cleanValidatorMarca(){
        $("#marNom_show").empty();
    }
</script>