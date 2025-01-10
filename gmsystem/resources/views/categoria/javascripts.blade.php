<input type="hidden" id="btnText" value="{{$btnText or 'Guardar'}}">
<script type="text/javascript">
    $(document).ready(function (){
        $("#validatorCategoria").hide();
        $("#est").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });
    });
    $("#modal-cat-{{  $nameModule }}-form").validate({
        //ignore: '.ignore, .select2-input',
        focusInvalid: true,
        rules: {
            'catNom': {
                required: true
            },
        },
        messages: {
            'catNom': 'Requerido',
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
                title: "Seguro de guardar categoria?",
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
                        create_categoria_{{ $nameModule }}();
                    }
                },
                className: " no-margin-hr panel-padding modal-alert modal-warning animated bounce",
                locale: "es",
                closeButton: false,
            });
        }   
    });


    function create_categoria_{{ $nameModule }}(){
        if($("#btnText").val()=="Guardar"){
            url="{{ url('/categoria') }}";
            mensaje="Se creo categoria: <br />Nombre: " + $("#catNom").val();
        }else{
            url="{{ route('categoria.edit', $id)}}";
            mensaje="Se actualizo categoria: <br />Nombre: " + $("#catNom").val();
        } 

        var data = $("#modal-cat-{{ $nameModule }}-form").serialize();
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
                    $("#catNom").val("")
                    $("#validatorCategoria").hide();
                    if($("#btnText").val()!="Guardar"){
                        $('#modal-btn-{{ $nameModule }}').modal('hide');
                    }
                    cboCategoria($("#clasificacionId2").val(),'1','-1');
                }
                else{
                    setTimeout(function () {
                            $('html, #modal-{{ $nameModule }}').animate({scrollTop:0}, 'slow')
                    }, 800);
                    $("#validatorCategoria").show();
                    cleanvalidatorCategoria();
                    $("#catNom_show").text(datos_json['validar']['catNom']);
                    $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardar');
                    $("#{{ $btnName }}").attr({
                        'class': "btn btn-primary btn-outline",
                    });
                    $("#catNom").val("")
                    $("#catNom").focus() 
                }

            },
            error : function(data) {
                $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo guardar clasificaci&oacute;n!" , size: 'large' });
                $("#{{ $btnName }}").html('<span class="btn-label icon fa fa-save"></span> Guardar');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
                $("#catNom").val("")
                $("#catNom").focus()            
            },

            dataType : 'json'
        });
    }


    function cleanvalidatorCategoria(){
        $("#catNom_show").empty();
    }
</script>