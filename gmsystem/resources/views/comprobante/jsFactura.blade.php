<input type="hidden" name="btnText" id="btnText" value="{{$btnText or 'Guardar'}}">
<script type="text/javascript">
    var numfila;
    $(document).ready(function (){
        $('#descuento').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            calcImporte();
            return false;
          }
        });
        $('#descuento').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9\.]/g, '');
        });
        $("#validator").hide();
        $("#validator2").hide();
        if($("#btnText").val()=="Guardar"){
            fechaActual();
            fechaVencimiento();
            $("#idp1").load("{{ url('cbo.producto') }}/1");
            numfila = 1;
            cboCliente(-1);
        }else{
            numfila = $("#fila").val();
            cboCliente($("#idCliente").val());
        }
        $('#fecInicioObra').datepicker(
        {
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es-ES',
            todayHighlight: true,
            endDate: '+0',
            weekStart: 0
            
        }); 

        $('#fecFinObra').datepicker(
        {
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es-ES',
            todayHighlight: true,
            endDate: '+0',
            weekStart: 0
            
        });

        $('#fecFactura').datepicker(
        {
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es-ES',
            todayHighlight: true,
            endDate: '+0',
            weekStart: 0
            
        }); 

        $("#idMoneda").select2({
            //allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });
             
        // $("#almacen").select2({
        //     allowClear: true,
        //     placeholder: "SELECCIONE...",
        //     //minimumInputLength: 3,
        //     //multiple: false,
        // });
        
        $("#cliente").select2({
            allowClear: true,
            placeholder: "SELECCIONE...",
            //minimumInputLength: 3,
            //multiple: false,
        });
        
            
    });

    $("#modal-{{ $nameModule }}-form").validate({
        //ignore: '.ignore, .select2-input',
        focusInvalid: true,
        // rules: {
        //     'cliente': {required: true},
        //     'numDoc': {required: true},        
        // },

        // messages: {
        //     'cliente': 'Seleccione',   
        //     'numDoc': 'Requerido',  
        // },
   
        submitHandler: function(form) {
            var boton;
            if($("#estBorrador").val()=="0"){
                boton="{{ $btnName }}";
            }else{
                boton="bor-{{ $btnName }}";
            }
            $("#"+boton).attr({
                'class': "btn btn-primary btn-outline disabled",
            });
            guardarFactura();
            //createSend();
        }
    });

     function guardarFactura(){
        var boton;
        var titulo;
        if($("#estBorrador").val()=="0"){
            boton="{{ $btnName }}";
            titulo="Seguro(a) de guardar comprobante?";
        }else{
            boton="bor-{{ $btnName }}";
            titulo="Seguro(a) de guardar borrador?";
        }
        setTimeout(function(){
             $("#"+boton).attr({
                'class': "btn btn-primary btn-outline",
            });
        }, 200);
        var fila=$("#fila").val();
        var numCantidad=0;
        var numPrecio=0;
        var numSearch=0;
        for (var i = 1; i <= fila; i++) {
            if($("#cantidad"+i).val()=="0" || $("#cantidad"+i).val()==""){
                $("#pintaCantidad"+i).attr("class","form-group has-error");
                numCantidad=0;
            }else{
                numCantidad=1;
            }

            if($("#precuni"+i).val()=="0" || $("#precuni"+i).val()==""){
                $("#pintaPrecio"+i).attr("class","form-group has-error");
                numPrecio=0;
            }else{
                numPrecio=1;
            }
            var duplicaSearch = $("#codigo"+i).val()+" "+$("#nombreProducto"+i).val();
            if($("#search"+i).val()=="" || $("#search"+i).val()!=duplicaSearch){
                $("#pintaProducto"+i).attr("class","form-group has-error");
                if($("#search"+i).val()==undefined){
                    numSearch=1;
                }else{
                    numSearch=0;
                }
            }else{
                numSearch=1;
            }
        }
        if($("#total2").val()=="0.00"){
            alert("El detalle tiene que tener al menos un item");
        }else{
            bootbox.confirm({
            title: titulo,
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
                    $("#"+boton).attr({
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
    }

    function createSend(){
        var boton;
        var url;
        var nombre;
        if($("#estBorrador").val()=="0"){
            boton="{{ $btnName }}";
            url="{{ url('/comprobante') }}";
            nombre="Guardar";
        }else{
            boton="bor-{{ $btnName }}";
            url="{{ url('/comprobanteBorrador') }}";
            nombre="Borrador";
        }
        var data = $("#modal-{{ $nameModule }}-form").serialize();

        $.ajax({
            beforeSend: function(){
                $("#"+boton).html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardando...');
                $("#"+boton).attr({
                    'class': "btn btn-primary btn-outline disabled",
                });
            },
            type : 'POST',
            url : url,
            data : data,
            success : function(datos_json) {
                if (datos_json.success == "true") {
                    $('#modal-{{ $nameModule }}').modal('hide');
                    $('#modal-{{ $nameModule }}-detalle').modal('hide');
                    $("#content-modal-{{ $nameModule }}").html("");
                    $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();
                    $("#mensaje").show();
                    var estado="alert alert-success";
                    $("#mensaje").attr("class", estado);
                    $("#respuesta").text(datos_json.result["message"]);
                    //detalleComprobante(datos_json.id);
                }else if(datos_json.success == "false"){
                    $("#"+boton).html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                    $('#'+boton).attr({
                        'class': "btn btn-primary btn-outline",
                    }); 
                    setTimeout(function () {
                            $('html, #modal-{{ $nameModule }}').animate({scrollTop:0}, 'slow')
                    }, 800);
                    $("#validator").show();
                    if(datos_json['validarDetalle']=="1"){
                        //VAlidamos el detalle del comprobante
                        cleanValidator();
                        $("#detalle_show").text("- Por favor revisar la cesta de productos o servicios");
                        $("#"+boton).html('<span class="btn-label icon fa fa-save"></span>&nbsp;'+nombre);
                        $("#"+boton).attr({
                            'class': "btn btn-primary btn-outline",
                        });
                    }else{
                        //Validamos la cabecera del detalle
                        cleanValidator();
                        $("#cliente_show").text(datos_json['validar']['cliente']);
                        $("#tipo_documento_show").text(datos_json['validar']['tipDoc']);
                        $("#serie_show").text(datos_json['validar']['numSerie']);
                        $("#doc_show").text(datos_json['validar']['numDoc']);
                        $("#fecha_emision_show").text(datos_json['validar']['fecFactura']);
                        $("#tipo_operacion_show").text(datos_json['validar']['tOpe']);
                        $("#moneda_show").text(datos_json['validar']['idMoneda']);
                        $("#fecha_vencimiento_show").text(datos_json['validar']['fecFacturaVencimiento']);
                        $("#origen_show").text(datos_json['validar']['almacen']);
                        $("#observacion_show").text(datos_json['validar']['obs']);

                        $("#"+boton).html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                        $("#"+boton).attr({
                            'class': "btn btn-primary btn-outline",
                        });
                    }
                }else{
                    $('#modal-{{ $nameModule }}').modal('hide');
                    $("#mensaje").show();
                    var estado="alert alert-danger";
                    $("#mensaje").attr("class", estado);
                    $("#respuesta").text(datos_json.result["message"]);
                    $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();
                }
            },
            error : function(data) {
                $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "Problemas con la sunat!" , size: 'large' });
                $("#"+boton).html('<span class="btn-label icon fa fa-save"></span>&nbsp;Guardar');
                $('#'+boton).attr({
                    'class': "btn btn-primary btn-outline",
                }); 
                $('#modal-{{ $nameModule }}').modal('hide');
                $("#content-modal-{{ $nameModule }}").html("");
                $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();   
            },

            dataType : 'json'
        });
        return false;
    }

    function cleanValidator(){
        $("#cliente_show").empty();
        $("#tipo_documento_show").empty();
        $("#serie_show").empty();
        $("#doc_show").empty();
        $("#fecha_emision_show").empty();
        $("#tipo_operacion_show").empty();
        $("#moneda_show").empty();
        $("#fecha_vencimiento_show").empty();
        $("#origen_show").empty();
        $("#observacion_show").empty();
        $("#detalle_show").empty();
    }

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
        $("#fecFactura").val(hoy);
    }

    function fechaVencimiento(){
        var hoy = new Date();
        //var dd = hoy.getDate()+1;
        var dd = hoy.setDate(hoy.getDate()+parseInt(8));
        dd=hoy.getDate();
        var mm = hoy.getMonth()+1; //hoy es 0!
        var yyyy = hoy.getFullYear();
        if(dd<10) {
            dd='0'+dd
        } 
        if(mm<10) {
            mm='0'+mm
        } 
        hoy = dd+'/'+mm+'/'+yyyy;
        $("#fecFacturaVencimiento").val(hoy);
    }

    function cboCliente(id){
        $.ajax({
            beforeSend: function(){
                $("#cargaCliente").html("{!! $loadImg !!}");
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline disabled",
                });
            },
            type: "GET",
            url: "{{ url('cbo.cliente') }}/"+id,
            success: function(response) {
                $("#cargaCliente").html(response);
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
            },
            error: function(e){
                $.growl.error({ title: "Error: " + e.status + " " + e.statusText, message: "No se pudo cargar cliente!" , size: 'large' });
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary btn-outline",
                });
            },
            dataType: 'html'
          });
    }

    function calcImporte() {
        var total = 0;
        var subTotal= 0;
        var igv = 0;
        var desc = 0;
        var totalDesc = 0;
        for(i=1; i<=numfila; ++i) {
            if($("#cantidad"+i).val()!=undefined){
                if($("#estIgv").val()!="1"){
                    $("#subtotalSinIgv"+i).val(parseFloat($("#cantidad"+i).val() * $("#precuni"+i).val()).toFixed(2));
                    $("#subtotal"+i).val(parseFloat($("#subtotalSinIgv" + i).val()*parseFloat(1.18)).toFixed(2));
                }else{
                    $("#subtotal"+i).val(parseFloat($("#cantidad"+i).val() * $("#precuni"+i).val()).toFixed(2));
                    $("#subtotalSinIgv"+i).val(parseFloat($("#subtotal" + i).val()/parseFloat(1.18)).toFixed(2));
                }
                var igvDetalle = parseFloat($("#subtotal"+i).val()-$("#subtotalSinIgv"+i).val());
                $("#igvDetalle"+i).val(igvDetalle.toFixed(2));
                total += parseFloat($("#subtotal" + i).val());
            }
        }

        subTotal = total/parseFloat(1.18);              
        igv=total-subTotal; 
        if($("#descuento").val()!=""){
            desc=total*$("#descuento").val()/100;
            totalDesc=total-desc;
        } 
        $("#subTotal").text(parseFloat(subTotal).toFixed(2));
        $("#igv2").text(parseFloat(igv).toFixed(2));
        $("#total").text(parseFloat(total).toFixed(2));
        $("#totalDes").text(parseFloat(totalDesc).toFixed(2));
        $("#subTotal2").val(parseFloat(subTotal).toFixed(2));
        $("#igv3").val(parseFloat(igv).toFixed(2));
        $("#total2").val(parseFloat(total).toFixed(2));
        $("#totalDes2").val(parseFloat(totalDesc).toFixed(2));
        // $("#subTotal").val(parseFloat(subTotal).toFixed(2));
        // $("#igv2").val(parseFloat(igv).toFixed(2));
        // $("#total").val(parseFloat(total).toFixed(2));
    }

    function addfila() {
        ++numfila;
        $("#tabla").find('tbody')
        .append(
            $('<tr>')
            .append(
                $('<td>')
                .append($('<span>')
                    .attr({
                        'id':'idp'+numfila
                    })
                )              
            )
            .append(
                $('<td>')
               .append(
                    $('<img>')
                    .attr({
                        'id':'img-upload'+numfila,
                        'src': ''
                    })
                    .css('width','100%')
                )
                .change(function() {
                    calcImporte();
                    }
                )
            )
            .append(
                $('<td>')
                .append(
                    $('<div>')
                    .attr({
                        'class': 'form-group',
                        'id':'pintaCantidad'+numfila,
                    })
                    .css('margin-bottom','0px')

                    .append(
                        $('<input>')
                        .attr({
                            'type':'text', 
                            'name':'cantidad'+numfila, 
                            'id':'cantidad'+numfila,
                            'class': 'form-control',
                            'autocomplete': 'off'
                        })
                        .val(0)
                        .css('text-align','right')
                    )
                )

                .change(function() {
                    calcImporte();
                    }
                )
            )
            .append(
                $('<td>')
                .append(
                    $('<div>')
                    .attr({
                        'class': 'form-group',
                        'id':'pintaPrecio'+numfila,
                    })
                    .css('margin-bottom','0px')

                    .append($('<input>')
                    .attr({
                        'type':'text', 
                        'name':'precuni'+numfila, 
                        'id':'precuni'+numfila,
                        'class': 'form-control',
                        'autocomplete': 'off'
                    })
                    .val('')
                    .css('text-align','right'))
                    .change(function() {
                        calcImporte();
                    })
                )

            )

            .append(
                $('<td>')
                .append(
                    $('<div>')
                    .css('margin-bottom','0px')
                    .append($('<input>')
                    .attr({
                        'type':'text', 
                        'name':'subtotalSinIgv'+numfila, 
                        'id':'subtotalSinIgv'+numfila,
                        'class': 'form-control',
                        'readonly':''
                    })
                    .val('0.00')
                    .css('text-align','right'))
                    .change(function() {
                        calcImporte();
                    })
                )

            )

            .append(
                $('<td>')
                .append(
                    $('<input>')
                    .attr({
                        'type':'hidden', 
                        'name':'igvDetalle'+numfila, 
                        'id':'igvDetalle'+numfila
                    })
                    .val(0)
                )
                .append(
                    $('<input>')
                    .attr({
                        'type':'text', 
                        'name':'subtotal'+numfila, 
                        'id':'subtotal'+numfila,
                        'class': 'form-control',
                        'readonly':''
                    })
                    .css('text-align','right')
                    .val('0.00')
                )

            )


            .append(
                $('<td>')
                .append(
                    $('<button>')
                    .attr({
                        'type':'button', 
                        'class':'btn btn-danger btn-outline'
                    })
                    .val(numfila)
                    .click(function() {
                        eliminar($(this).val());
                        }
                    )
                    .append(
                        $('<span>')
                        .attr({
                            'class':'btn-label icon fa fa-times'
                        })
                    )
                )
            )
        );

        $("#idp"+numfila).load("{{ url('cbo.producto') }}/"+numfila);
        $("#fila").val(numfila);
    }

    function addfila2() {
        ++numfila;
        $("#tabla").find('tbody')
        .append(
            $('<tr>')
            .append(
                $('<td>')
                .append($('<span>')
                    .attr({
                        'id':'idp'+numfila
                    })
                )              
            )
            .append(
                $('<td>')
               .append(
                    $('<img>')
                    .attr({
                        'id':'img-upload'+numfila,
                        'src': ''
                    })
                    .css('width','100%')
                )
                .change(function() {
                    calcImporte();
                    }
                )
            )
            .append(
                $('<td>')
                .append(
                    $('<div>')
                    .attr({
                        'class': 'form-group',
                        'id':'pintaCantidad'+numfila,
                    })
                    .css('margin-bottom','0px')

                    .append(
                        $('<input>')
                        .attr({
                            'type':'text', 
                            'name':'cantidad'+numfila, 
                            'id':'cantidad'+numfila,
                            'class': 'form-control',
                            'autocomplete': 'off'
                        })
                        .val(0)
                        .css('text-align','right')
                    )
                )

                .change(function() {
                    calcImporte();
                    }
                )
            )
            .append(
                $('<td>')
                .append(
                    $('<div>')
                    .attr({
                        'class': 'form-group',
                        'id':'pintaPrecio'+numfila,
                    })
                    .css('margin-bottom','0px')

                    .append($('<input>')
                    .attr({
                        'type':'text', 
                        'name':'precuni'+numfila, 
                        'id':'precuni'+numfila,
                        'class': 'form-control',
                        'autocomplete': 'off'
                    })
                    .val(0)
                    .css('text-align','right'))
                    .change(function() {
                        calcImporte();
                    })
                )

            )
            .append(
                $('<td>')
                .append(
                    $('<input>')
                    .attr({
                        'type':'hidden', 
                        'name':'subtotalSinIgv'+numfila, 
                        'id':'subtotalSinIgv'+numfila
                    })
                    .val(0)
                )
                .append(
                    $('<input>')
                    .attr({
                        'type':'hidden', 
                        'name':'igvDetalle'+numfila, 
                        'id':'igvDetalle'+numfila
                    })
                    .val(0)
                )
                .append(
                    $('<input>')
                    .attr({
                        'type':'text', 
                        'name':'subtotal'+numfila, 
                        'id':'subtotal'+numfila,
                        'class': 'form-control',
                        'readonly':''
                    })
                    .css('text-align','right')
                    .val(0)
                )

            )


            .append(
                $('<td>')
                .append(
                    $('<button>')
                    .attr({
                        'type':'button', 
                        'class':'btn btn-danger btn-outline'
                    })
                    .val(numfila)
                    .click(function() {
                        eliminar($(this).val());
                        }
                    )
                    .append(
                        $('<span>')
                        .attr({
                            'class':'btn-label icon fa fa-times'
                        })
                    )
                )
            )
        );

        $("#idp"+numfila).load("{{ url('cbo.producto') }}/"+numfila);
        $("#fila").val(numfila);
    }

    function eliminar(id){
        alert("Esta seguro de eliminar el producto?");
        $($("#idp"+id).parent("td")).parent("tr").remove();
        calcImporte();
    }

    function datosCliente(){
        var idcliente;
        if($("#cliente").val()!=""){
           idcliente=$("#cliente").val();
        }
        $.ajax({
            beforeSend: function(){
            },
            type: "GET",
            url: "{{ url('datos.cliente') }}/"+idcliente,
            success : function(datos_json) {    
                if (datos_json.success != false) {
                    $("#razon").val(datos_json.razon);
                    $("#direccion").val(datos_json.direccion);
                    $("#ruc").val(datos_json.doc);
                }
            },
            error : function(data) {
                $.growl.error({ title: "Error:", message: "No se pudo cargar!", size: 'large' });
            },
            dataType : 'json'
        });  
    }

    function createCliente(id){
        var data = "";

        $('#modal-cliente').modal({
            show:true 
        });

        $.ajax({
            beforeSend: function(){
              $("#content-modal-cliente").html("<?php echo $loadImg;?>");                   
                $('#btn_cli_cre_{{ $nameModule}}').attr({
                    'class': "btn btn-xs btn-outline btn-primary add-tooltip disabled",
                });                                     
            },
            type: "GET",
            cache: false,
            url: "{{ url('/comprobante') }}/createCliente/{{$cboTipo}}/"+id,
            data: data,
            success: function(response){
                if (response != "false") {
                    $('#content-modal-cliente').html(response);             
                    $('#btn_cli_cre_{{ $nameModule}}').attr({
                        'class': "btn btn-xs btn-outline btn-primary add-tooltip",
                    });     
                }else{
                    alert("No se cre&oacute; cliente "+response.error);             
                    $('#btn_cli_cre_{{ $nameModule}}').attr({
                        'class': "btn btn-xs btn-outline btn-primary add-tooltip",
                    }); 
                }
            },
            error: function(e){
                $.growl.error({
                    title: "Error: " + e.status + " " + e.statusText ,
                    message: "No es posible cargar el formulario! <br />Vuelva a intertarlo en un momento",
                    size: 'large'
                });
                setTimeout(function(){
                    $("#content-modal-cliente").html('');                   
                    $('#btn_cli_cre_{{ $nameModule}}').attr({
                        'class': "btn btn-xs btn-outline btn-primary add-tooltip",
                    });
                    
                    $('#modal-cliente').modal('hide');
                }, 4000);       
            },
            dataType : 'html'
        });
        return false;
    }

    function borrador(){
        $("#estBorrador").val("1");
    }

    function factura(){
        $("#estBorrador").val("0");   
    }

    function cambiaMoneda(){
        if($("#idMoneda").val()=="1"){
            $("#mSubTotal").text("S/");
            $("#mIgv").text("S/");
            $("#mTotal").text("S/");
            $("#mVuelto").text("S/");
        }else{
            $("#mSubTotal").text("US$");
            $("#mIgv").text("US$");
            $("#mTotal").text("US$");
            $("#mVuelto").text("US$");
        }
        for (i=0;i<=$("#fila").val();i++) { 
            if($("#productoId"+i).val()!="0"){
                id = parseInt(i) + parseInt(1)
                if(i!="0"){
                    DatosMoneda(i);
                }
            }
        }
    }

    function DatosMoneda(id){
        var moneda=$("#idMoneda").val();
        var codigo=$("#codigo"+id).val();
        var url;
        if(typeof codigo != 'undefined'){
            $.ajax({
              beforeSend: function(){
              },
              type: "GET",
              url: "{{ url('datos.producto') }}/"+codigo+"/"+moneda,
              success : function(datos_json) {    
                  if (datos_json.success != false) {
                    if(datos_json.precio!=null){
                        $("#precuni"+id).val(datos_json.precio);
                        calcImporte(); 
                    }else{
                        DatosMonedaComprobante(id,$("#productoId"+id).val())
                    }
            
                  }
              },
              error : function(data) {
                  $.growl.error({ title: "Error:", message: "No se pudo cargar!", size: 'large' });
              },
              dataType : 'json'
            });
        }
    }


    function DatosMonedaComprobante(id,id2){
        $.ajax({
          beforeSend: function(){
          },
          type: "GET",
          url: "{{ url('datos.productoComprobante') }}/"+id2+"/"+$("#id").val(),
          success : function(datos_json) {    
              if (datos_json.success != false) {
                $("#precuni"+id).val(datos_json.precio); 
                calcImporte();          
              }
          },
          error : function(data) {
              $.growl.error({ title: "Error:", message: "No se pudo cargar!", size: 'large' });
          },
          dataType : 'json'
        });
    }

</script>