<?php 
    $loadImg = "<img src=".URL::to('/')."/public/pixeladmin/images/plugins/bootstrap-editable/loading2.gif>";
    $btnName = "btn_detalle".$nameModule;
    $btnCreate = "btnCreate".$nameModule;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <span class="panel-title"><i style="font-size: 25px;"></i> <span id="titulo" style="font-size: 28px;">
    COTIZACIÓN N° <?php echo str_pad($datos[0]->c_doc,7,"0",STR_PAD_LEFT) ?>

</div>

<div class="modal-body">
    <div class="alert alert-success" style="margin-top: 0px; margin-bottom: 10px;" id="mensajeDetalle">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><span id="respuestaDetalle"></span></strong>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label class="control-label">Fecha de emisión:</label><br>
            <span>{{ $datos[0]->f_hor_fac }}</span>
        </div> 
        <div class="col-md-2">
            <label class="control-label">Fecha de emisión:</label><br>
            <span>{{ $datos[0]->f_hor_fac_ven }}</span>
        </div> 
        <div class="col-md-4">
            <div class="form-group ">
                <label class="control-label">Cliente:</label><br>
                <span>{{ $datos[0]->c_num_doc }} {{ $datos[0]->c_raz }}</span>         
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 0px;">
                <label class="control-label" for="tal_nom">Dirección:</label><br>
                <span>{{ $datos[0]->c_dir }}</span>
            </div> <!-- / .form-group -->
        </div> 
    </div>

    @if($datos[0]->n_est!="4")
        <div class="row">
            <div class="col-md-12">
                @if($datos[0]->c_cor!="")
                    <button type="submit" class="btn btn-primary" id="{{ $btnName }}" onclick="detalleCorreo({{ $datos[0]->pk_cpb_id }});">
                        Enviar al cliente [{{ $datos[0]->c_cor }}]   
                    </button>
                @else
                    <button type="submit" class="btn btn-primary" id="{{ $btnName }}" onclick="detalleSinCorreo({{ $datos[0]->pk_cpb_id }});">
                        Enviar a un email personalizado   
                    </button>
                @endif

{{--                 <button type="button" class="btn btn-primary" id="imp" onclick="imprimirComprobante('{{ $datos[0]->c_ar_sun }}');">
                    <span class="btn-label icon fa fa-print"></span> Imprimir
                </button> --}}
            </div> 
        </div>
    @endif
    <br>
    <div class="row">

        <div class="col-md-12">
            <div class="form-group" style="margin-bottom: 0px;">
                <label class="control-label" for="tal_nom">Asunto</label><br>
                <span>{{ $datos[0]->c_asu }}</span>
            </div> <!-- / .form-group -->
        </div> 
    </div>
    <br>
    <div class="row" style="margin-top: 5px; margin-left: 0px;">
        <div class="table-light table-responsive">
            <table class="table table-bordered table-hover" id="tabla">
                <thead>
                    <tr>
{{--                         <th style="text-align: center;">Código</th>
                        <th style="text-align: center;">Tipo Unidad</th> --}}
                        <th style="width:600px;">Producto</th>
                        <th style="text-align: center; width: 20%;">Imagen</th>
                        <th style="text-align: center;">Cantidad</th>
                        <th style="text-align: center;">VALOR Unit.</th>
                        <th style="text-align: center;">Subtotal</th> 
                        @if($igv!="1")
                            <th style="text-align: center;">Total</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    <?php $id = 1; ?>
                    @foreach ($comprobanteDetalle as $detalle)
                    <tr>
{{--                         <td style="text-align: left;">
                            <span >{{ $detalle->c_cod }}</span>
                        </td>
                        <td style="text-align: left;">
                            <span >{{ $detalle->nomUnidadMedida }}</span>
                        </td> --}}
                        <td style="text-align: left;">
                            <span style="font-weight:bold;">{{ $detalle->c_nom }}</span>
                            <span> {!! $detalle->c_obs !!}</span>
                        </td>
                        <td>
                            <img id='img-upload' src="{{ asset('/public/images/'.$detalle->c_img) }}" style="width: 100%" />
                        </td>
                        <td style="text-align: right;">
                            <span style="text-align: right;">{{ $detalle->n_can }}</span>
                        </td>
                        <td style="text-align: right;">
                            <span style="text-align: right;">{{ $detalle->n_pre }}</span>
                        </td>
                        <td style="text-align: right;">
                            <span style="text-align: right;"><?php echo number_format((float)$detalle->n_sub_tot, 2, '.', ''); ?></span>
                        </td>
                        @if($igv!="1")
                            <td style="text-align: right;">
                                <span><?php echo number_format((float)$detalle->n_sub_tot, 2, '.', ''); ?></span>
                            </td>
                        @endif
                    </tr>
                    <?php $id++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="panel-footer text-right ">
        <div class="row">
            <div class="col-md-12">
                <div id="totTipo">
                    <div>
                    <span class="text-bg">Subtotal:</span>
                    <span class="text-xlg">
                        <span class="text-lg text-slim">
                            @if($datos[0]->fk_mon_id == "1")
                                S/
                            @else
                                US$
                            @endif
                        </span>
                        <strong id="subTotal"><?php echo number_format((float)$datos[0]->n_sub_tot, 2, '.', '') ?></strong>
                    </span>
                    </div>
                    <span class="text-bg">Igv:</span>
                    <span class="text-xlg">
                        <span class="text-lg text-slim">
                            @if($datos[0]->fk_mon_id == "1")
                                S/
                            @else
                                US$
                            @endif
                        </span>
                        <strong id="igv2"><?php echo number_format((float)$datos[0]->n_igv, 2, '.', '') ?></strong>
                    </span>
                </div>
                <span class="text-bg">Total:</span>
                <span class="text-xlg">
                    <span class="text-lg text-slim">
                        @if($datos[0]->fk_mon_id == "1")
                            S/
                        @else
                            US$
                        @endif
                    </span>
                    <strong id="total"><?php echo number_format((float)$datos[0]->n_tot, 2, '.', '') ?></strong>
                </span>
                @if($datos[0]->n_tot_des!="")
                    <div>
                        <span class="text-bg">%Desc:&nbsp;&nbsp;&nbsp;</span>
                        <span class="text-xlg">
                            <strong id="subTotal"><?php echo $datos[0]->n_des ?></strong>
                        </span>
                    </div>
                    <span class="text-bg">Total %Desc:</span>
                    <span class="text-xlg">
                        <span class="text-lg text-slim">
                            @if($datos[0]->fk_mon_id == "1")
                                S/
                            @else
                                US$
                            @endif
                        </span>
                        <strong id="total"><?php echo number_format((float)$datos[0]->n_tot_des, 2, '.', '') ?></strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $("#mensajeDetalle").hide();
    function detalleCorreo(id){
        $.ajax({
            beforeSend: function(){
                $("#{{ $btnName }}").html('</span>&nbsp;Enviando correo al cliente [{{ $datos[0]->c_cor }}]...');
                $("#{{ $btnName }}").attr({
                    'class': "btn btn-primary disabled",
                });
            },
            type : 'POST',
            url : '{{ url($nameModule.'/correo') }}',
            data: {
            "_token": "{{ csrf_token() }}",
            "id": id
            },
            success : function(datos_json) {
                if (datos_json.success != false) {
                    $("#{{ $btnName }}").html('</span>&nbsp;Enviar correo al cliente [{{ $datos[0]->c_cor }}]');
                    $('#{{ $btnName }}').attr({
                        'class': "btn btn-primary",
                    }); 

                    $("#mensajeDetalle").show();
                    var estado="alert alert-success";
                    $("#mensajeDetalle").attr("class", estado);
                    $("#respuestaDetalle").text(datos_json.result);
                    $('#jq-datatables-{{ $nameModule }}').dataTable().fnClearTable();
                }else{
                    alert("Error");
                }
            },
            error : function(data) {
                $.growl.error({ title: "Error: " + data.status + " " + data.statusText, message: "No se pudo enviar correo!" , size: 'large' });  
                $("#{{ $btnName }}").html('</span>&nbsp;Enviar correo al cliente [{{ $datos[0]->c_cor }}]');
                $('#{{ $btnName }}').attr({
                    'class': "btn btn-primary",
                }); 
            },

            dataType : 'json'
        });
    }

    function detalleSinCorreo(id){
        $('#modal-{{ $nameModule }}-sm').modal({
            show:true 
        });

        $.ajax({
            beforeSend: function(){
                $("#content-modal-{{ $nameModule }}-sm").html("{!! $loadImg !!}");                                   
            },
            type: "GET",
            url: "{{ url($nameModule.'/createCorreo') }}/"+id,
            success: function(response){
                if (response != "false") {
                    $('#content-modal-{{ $nameModule }}-sm').html(response);    
                }else{
                    alert("No se cre&oacute; cliente "+response.error);
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
        return false;

    }


</script>
