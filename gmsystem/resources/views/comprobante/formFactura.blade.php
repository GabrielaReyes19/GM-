<div class="row" id="validator">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Se han detectado las siguientes validaciones</strong>
            <div id="cliente_show"></div>
            <div id="tipo_documento_show"></div>
            <div id="serie_show"></div>
            <div id="doc_show"></div>
            <div id="fecha_emision_show"></div>
            <div id="tipo_operacion_show"></div>
            <div id="moneda_show"></div>
            <div id="fecha_vencimiento_show"></div>
            <div id="origen_show"></div>
            <div id="observacion_show"></div>
            <div id="detalle_show"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-1">
        <div class="form-group " >
            <label class="control-label" >Número:</label>
                <input type="text" class="form-control" maxlength="10" id="numDoc" name="numDoc" readonly="" autocomplete="off" value="{{ $ComprobanteCabecera->c_doc or $correlativo }}" />        
        </div>
    </div>
    
    <div class="col-md-2">
        <label class="control-label">Fecha de emisión:</label><br>
        <div class="form-group has-feedback no-padding">
            <div class="input-group date" id="fecha">
                <input type="text" class="form-control input-sm" id="fecFactura" name="fecFactura" value="{{$ComprobanteCabecera->f_hor_fac or old('f_hor_fac')}}"/>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div> 

    <div class="col-md-2">
        <label class="control-label">Fecha de vencimiento:</label><br>
        <div class="form-group has-feedback no-padding">
            <div class="input-group date" id="fecha">
                <input type="text" class="form-control input-sm" id="fecFacturaVencimiento" name="fecFacturaVencimiento" value="{{$ComprobanteCabecera->f_hor_fac_ven or old('f_hor_fac_ven')}}"/>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div> 

    <div class="col-md-1">
        <div class="form-group ">
            <label class="control-label">Moneda:</label>
            {{-- <select id="idMoneda" name="idMoneda" class="form-control" onchange="cambiaMoneda();"> --}}
            <select id="idMoneda" name="idMoneda" class="form-control" onchange="print();">
                @foreach($cboMoneda as $moneda)
                    @if($ComprobanteCabecera->fk_mon_id==$moneda->pk_mon_id)
                        <option value="{{ $moneda->pk_mon_id }}" selected="">{{ $moneda->c_abr }}</option>
                    @else
                        <option value="{{ $moneda->pk_mon_id }}">{{ $moneda->c_abr }}</option>
                    @endif
                @endforeach
            </select>           
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group" style="margin-bottom: 0px;">
            <label class="control-label" >Cliente:
                <a href="#" id="btn_cli_cre_{{ $nameModule}}" onclick="createCliente('1');" class="btn btn-xs btn-outline btn-primary add-tooltip">Nuevo cliente con RUC</a>
                <a href="#" id="btn_cli_cre_{{ $nameModule}}" onclick="createCliente('2');" class="btn btn-xs btn-outline btn-primary add-tooltip">Nuevo cliente SIN RUC</a>
                 <a href="#" id="btn_cli_cre_{{ $nameModule}}" onclick="cboCliente('-1');" class="btn btn-xs btn-outline btn-primary add-tooltip">Refrescar</a>
            </label>
            <div id="cargaCliente"></div>           
        </div>
    </div>
</div>

<div class="row"> 
    <div class="col-md-2">
        <label class="control-label">Inicio de Obra:</label><br>
        <div class="form-group has-feedback no-padding">
            <div class="input-group date" id="fecha">
                <input type="text" class="form-control input-sm" id="fecInicioObra" name="fecInicioObra" value="{{$ComprobanteCabecera->f_hor_fac_ven or old('f_hor_fac_ven')}}"/>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div> 
    <div class="col-md-2">
        <label class="control-label">Fin de Obra:</label><br>
        <div class="form-group has-feedback no-padding">
            <div class="input-group date" id="fecha">
                <input type="text" class="form-control input-sm" id="fecFinObra" name="fecFinObra" value="{{$ComprobanteCabecera->f_hor_fac_ven or old('f_hor_fac_ven')}}"/>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div> 
</div>

<div class="row">

    <input type="hidden" name="almacen" id="almacen" value="1">
<!--     <div class="col-md-2">
        <div class="form-group " >
            <label class="control-label">Origen:</label>
            <select id="almacen" name="almacen" class="form-control" >
                @foreach($cboAlmacen as $almacen)
                    <option value="{{ $almacen->fk_alm_id }}">{{ $almacen->c_nom }}</option>
                @endforeach
            </select>           
        </div>
    </div> -->
    <div class="col-md-12">
        <div class="form-group" style="margin-bottom: 0px;">
            <label class="control-label" for="tal_nom">Asunto</label>
            <textarea cols="" rows="4" class="form-control input-sm" name="asu" id="asu">{{$ComprobanteCabecera->c_asu or old('c_asu')}}</textarea>
        </div> <!-- / .form-group -->
    </div> 
</div>
<div class="row" style="margin-top: 12px;">
    <div class="table-primary table-responsive">
        <table class="table table-bordered table-hover" id="tabla">
            <thead>
                <tr>
                    <th style="width:600px; background: #3690e6">Producto</th>
                    <th style="text-align: center; width: 20%; background: #3690e6">Imagen</th>
                    <th style="background: #3690e6; text-align: center;">Cantidad</th>
                    <th style="background: #3690e6; text-align: center;">VALOR Unit.</th>
                    <th style="background: #3690e6; text-align: center;">Subtotal</th>
                    @if($igv!="1")
                        <th style="background: #3690e6; text-align: center;">Total</th>
                    @endif
                    <th style="background: #3690e6; text-align: center;"></th>
                </tr>
            </thead>
            @if($btnText=="Guardar")
                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="detalleId1" id="detalleId1" value="">
                            <span id="idp1"></span>
                        </td>
                        <td>
                            <img id='img-upload1' src="" style="width: 100%" />
                        </td>
                        <td>
                            <div class="form-group" id="pintaCantidad1" style="margin-bottom: 0px;">
                                <input type="text" name="cantidad1" id="cantidad1" value="0" style="text-align:right" onchange="calcImporte()" class="form-control" autocomplete="off"/>
                            </div>

                        </td>
                        <td>
                            <div class="form-group" id="pintaPrecio1" style="margin-bottom: 0px;">
                                <input type="text" name="precuni1" id="precuni1" style="text-align:right" onchange="calcImporte()" class="form-control" autocomplete="off"/>
                            </div>
                        </td>
                        <td>
                            <input type="hidden" name="igvDetalle1" id="igvDetalle1">
                            @if($igv=="1")
                                <input type="hidden" name="subtotalSinIgv1" id="subtotalSinIgv1">
                                <input type="text" name="subtotal1" id="subtotal1" value="0" style="text-align:right" class="form-control" readonly="" />
                            @else
                                <input type="text" name="subtotalSinIgv1" id="subtotalSinIgv1" class="form-control" autocomplete="off" readonly="" value="0.00" style="text-align:right">
                            @endif
                        </td>
                        @if($igv!="1")
                            <td>
                                <input type="text" name="subtotal1" id="subtotal1" value="0.00" style="text-align:right" class="form-control" readonly="" />
                            </td>
                        @endif
                        <td>
                            <button type="button" class="btn btn-danger btn-outline" onclick="eliminar('1');">
                                <span class="btn-label icon fa fa-times"></span>
                            </button> 
                        </td>
                    </tr>
                </tbody>
            @else
                <tbody>
                    <?php $id = 1; ?>
                    @foreach ($comprobanteDetalle as $detalle)
                    <tr>
                        <td>
                            <span id="idp{{ $id }}">
                                <input type="hidden" name="productoId{{ $id }}" id="productoId{{ $id }}" value="{{ $detalle->fk_prd_id }}">
                                <input type="hidden" name="nombreProducto{{ $id }}" id="nombreProducto{{ $id }}" value="{{ $detalle->c_nom }}" class="form-control" readonly="">
                                <input type="hidden" name="codigo{{ $id }}" id="codigo{{ $id }}" value="{{ $detalle->c_cod }}">
                                <input type="hidden" name="um{{ $id }}" id="um{{ $id }}" value="{{ $detalle->c_abr }}">
                                <input type="hidden" name="idUm{{ $id }}" id="idUm{{ $id }}" value="{{ $detalle->pk_uni_med_id }}">
                                <span id="search{{ $id }}" style="font-weight:bold;">{{ $detalle->c_cod }} {{ $detalle->c_nom }}</span>
                                <span id="proDes{{ $id }}">{!! $detalle->c_obs !!}</span>
                            </span>
                        </td>
                        <td>
                            <img id='img-upload' src="{{ asset('/public/images/'.$detalle->c_img) }}" style="width: 100%" />
                        </td>
                        <td>
                            <div class="form-group" id="pintaCantidad{{ $id }}" style="margin-bottom: 0px;">
                                <input type="text" name="cantidad{{ $id }}" id="cantidad{{ $id }}" value="{{ $detalle->n_can }}" style="text-align:right" onchange="calcImporte()" class="form-control" autocomplete="off"/>
                            </div>

                        </td>
                        <td>
                            <div class="form-group" id="pintaPrecio{{ $id }}" style="margin-bottom: 0px;">
                                <input type="text" name="precuni{{ $id }}" id="precuni{{ $id }}" value="{{ $detalle->n_pre }}" style="text-align:right" onchange="calcImporte()" class="form-control" autocomplete="off"/>
                            </div>
                        </td>
                        <td>

                            <input type="hidden" name="igvDetalle{{ $id }}" id="igvDetalle{{ $id }}" value="{{ $detalle->n_igv }}">
                            @if($igv=="1")
                                <input type="hidden" name="subtotalSinIgv{{ $id }}" id="subtotalSinIgv{{ $id }}" value="<?php echo number_format((float)$detalle->n_sub_tot_sin_igv, 2, '.', ''); ?>" >
                                <input type="text" name="subtotal{{ $id }}" id="subtotal{{ $id }}" value="<?php echo number_format((float)$detalle->n_sub_tot, 2, '.', ''); ?>" style="text-align:right" class="form-control" readonly="" />
                            @else
                                <input type="text" name="subtotalSinIgv{{ $id }}" id="subtotalSinIgv{{ $id }}" value="<?php echo number_format((float)$detalle->n_sub_tot_sin_igv, 2, '.', ''); ?>" class="form-control" autocomplete="off" readonly="" value="0.00" style="text-align:right">
                            @endif

                        </td>
                        @if($igv!="1")
                            <td>
                                <input type="text" name="subtotal{{ $id }}" id="subtotal{{ $id }}" value="<?php echo number_format((float)$detalle->n_sub_tot, 2, '.', ''); ?>" style="text-align:right" class="form-control" readonly="" />
                            </td>
                        @endif
                        <td>
                            <button type="button" class="btn btn-danger btn-outline" onclick="eliminar('{{ $id }}');">
                                <span class="btn-label icon fa fa-times"></span>
                            </button> 
                        </td>
                    </tr>
                    <?php $id++; ?>
                    @endforeach
                </tbody>
            @endif
            
        </table>
    </div>
    @if($igv!="1")
        <button type="button" class="btn btn-primary btn-outline" onclick="addfila();">
            <span class="btn-label icon fa fa-plus"></span> Nuevo Item
        </button>

    @else
        <button type="button" class="btn btn-primary btn-outline" onclick="addfila2();">
        <span class="btn-label icon fa fa-plus"></span> Nuevo Item
        </button>
    @endif

    <input type="hidden" id="estIgv" value="{{ $igv }}">
{{--     <button type="button" class="btn btn-danger btn-outline" id="btnDeleteRow">
        <span class="btn-label icon fa fa-times"></span> Quitar Item
    </button> --}}
</div>

<div class="panel-footer text-right ">
    <div class="row">
        <div class="col-md-12">
            <div id="totTipo">
                <div>
                    <span class="text-bg">Subtotal:</span>
                    <span class="text-xlg">
                        <span class="text-lg text-slim" id="mSubTotal">
                            @if($ComprobanteCabecera->fk_mon_id == "1" || $ComprobanteCabecera->fk_mon_id == "")
                                S/
                            @else
                                US$
                            @endif
                        </span>
                        <strong id="subTotal">@php echo number_format($ComprobanteCabecera->n_sub_tot, 2, '.', ',') @endphp</strong>
                    </span>
                </div>
                <span class="text-bg">Igv:</span>
                <span class="text-xlg">
                    <span class="text-lg text-slim" id="mIgv">
                        @if($ComprobanteCabecera->fk_mon_id == "1" || $ComprobanteCabecera->fk_mon_id == "")
                            S/
                        @else
                            US$
                        @endif
                    </span>
                    <strong id="igv2">@php echo number_format($ComprobanteCabecera->n_igv, 2, '.', ',') @endphp</strong>
                </span>
            </div>
            <span class="text-bg">Total:</span>
            <span class="text-xlg">
                <span class="text-lg text-slim" id="mTotal">
                    @if($ComprobanteCabecera->fk_mon_id == "1" || $ComprobanteCabecera->fk_mon_id == "")
                        S/
                    @else
                        US$
                    @endif
                </span>
                <strong id="total">@php echo number_format($ComprobanteCabecera->n_tot, 2, '.', ',') @endphp</strong>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-5" >
                    <span class="text-bg">%Desc:</span>
                </div>
                <div class="col-md-7">
                    <span class="text-xlg">
                        <strong id="">
                            <input type="text" class="form-control" name="descuento" id="descuento" autocomplete="off" value="{{$ComprobanteCabecera->n_des or old('n_des')}}" onkeyup="calcImporte();"/>  
                        </strong>
                    </span>
                </div>
            </div>
        </div>  
     </div>

     <div class="row">
        <div class="col-md-12">
            <span class="text-bg">Total %Desc:</span>
            <span class="text-xlg">
                <span class="text-lg text-slim" id="mTotal">
                    @if($ComprobanteCabecera->fk_mon_id == "1" || $ComprobanteCabecera->fk_mon_id == "")
                        S/
                    @else
                        US$
                    @endif
                </span>
                <strong id="totalDes">@php echo number_format($ComprobanteCabecera->n_tot_des, 2, '.', ',') @endphp</strong>
            </span>
        </div>
    </div>
</div>

<div class="panel-footer text-right tab-content-padding">
        <input type="hidden" name="id" id="id" value="{{ $ComprobanteCabecera->pk_cpb_id }}" />
        <input type="hidden" name="subTotal2" id="subTotal2" value="{{ $ComprobanteCabecera->n_sub_tot }}" />
        <input type="hidden" name="igv3" id="igv3" value="{{ $ComprobanteCabecera->n_igv }}" />
        <input type="hidden" name="total2" id="total2" value="{{ $ComprobanteCabecera->n_tot }}" />
        <input type="hidden" name="totalDes2" id="totalDes2" value="{{ $ComprobanteCabecera->n_tot_des }}" />
        <input type="hidden" name="fila" id="fila" value="{{ $totalDetalle }}">
        <input type="hidden" name="idCliente" id="idCliente" value="{{ $ComprobanteCabecera->pk_cli_id }}">
        <input type="hidden" name="razon" id="razon">
        <input type="hidden" name="direccion" id="direccion">
        <input type="hidden" name="ruc" id="ruc">
        <input type="hidden" name="docSunat" id="docSunat" value="{{ $cboTipo }}">
        <input type="hidden" name="estBorrador" id="estBorrador" value="0">
        <input type="hidden" name="idNueva" value="{{$id2}}">
        <button type="submit" class="btn btn-primary btn-outline" id="{{ $btnName }}" onclick="factura();">
            <span class="btn-label icon fa fa-save"></span> Guardar
        </button>
        <button type="button" class="btn btn-danger btn-outline" id="cer" onclick="cerrar();">
            <span class="btn-label icon fa fa-times"></span> Cerrar
        </button>
</div>