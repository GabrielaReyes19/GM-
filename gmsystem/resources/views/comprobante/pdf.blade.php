
{{--$idDocument = $document->id;--}}

{{--if(!$note = \App\Models\Tenant\Note::where('document_id', $idDocument)->first()){--}}

{{--} else {--}}
{{--$document_affected = $note->affected_document_series.'-'.$note->affected_document_number;--}}

{{--$noteType = \App\Models\Tenant\Catalogs\Code::byCatalogAndCode('09',$note->note_type_code);--}}
{{--}--}}
<html>
<head>
    <title>Cotización 1</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 12px;
        }
        

        header {
          position: fixed;
          padding-bottom: 20px;
          top: 0cm;
          left: 0cm;
          right: 0cm;
          height: 3cm;
        }

        footer {
            position: fixed; 
            bottom: 0cm; 
            left: 0cm; 
            right: 0cm;
            height: 1cm;
        }

        body {
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0cm;
        }

        table.table-style-two {

            font-family: verdana, arial, sans-serif;
            font-size: 11px;
            color: #FFFFFF;
            border-width: 1px;
            border-color: #FF0000;
            border-collapse: collapse;
        }
     
        table.table-style-two th {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #517994;
            background-color: #BC180D;
        }
     
        table.table-style-two tr:hover td {
            background-color: #DFEBF1;
        }
     
        table.table-style-two td {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #517994;
            color: #000000;
            background-color: #ffffff;
        }

        table.table-style-footer {
            font-family: verdana, arial, sans-serif;
            font-size: 11px;
            color: #FFFFFF;
            border-width: 1px;
            border-color: #FF0000;
            border-collapse: collapse;
        }

        p{margin:0;padding:0}

        .voucher-information {
            border: 1px solid #333;
            width: 100%;
        }
        .voucher-information.top-note, .voucher-information.top-note tbody tr td {
            border-top: 0;
        }
        .voucher-information tbody tr td {
            padding-top: 5px;
            padding-bottom: 5px;
            vertical-align: top;
        }
        .voucher-information-left tbody tr td {
            padding: 0px 10px;
            vertical-align: top;
        }
        .voucher-information-right tbody tr td {
            padding: 0px 10px;
            vertical-align: top;
        }

    </style>

</head>

<body>
    <script type="text/php">
      if (isset($pdf)) {
        {{-- $pdf->page_text(120, 740, "Para consultar el comprobante ingresar a /search", "Arial", 8, array(0, 0, 0)); --}}
        $font = $fontMetrics->getFont("Arial", "bold");
        $pdf->page_text(530, 760, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 7, array(0, 0, 0));
      }
    </script>
{{--     <header>
      <img src="{{ asset('/public/images/logo.jpeg') }}"/>
    </header>
    <footer>
        <img src="{{ asset('/public/images/footer.jpeg') }}"/>
    </footer> --}}

<table class="voucher-information">
    <tr>
        <td width="65%">
            <table class="voucher-information-left">
                <tbody>
                    <tr>
                        <td width="100%" colspan="2">
                            <img id='img-upload' src="../public/images/logo.jpg" />
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="2">GRUPO GM SYSTEM SAC</td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="2">20604874841</td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="2">Sitio Web: https://gmsystemperu.com/</td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="2">Teléfono: {{ $empresa->c_tel }}</td>
                    </tr>
{{--                     <tr>
                        <td width="100%" colspan="2">Soporte Técnico: {{ $empresa->c_tel_sop }} </td>
                    </tr> --}}


                    @if(auth()->user()->id==2)
                        <tr>
                            <td width="100%" colspan="2">Soporte Técnico: {{ $empresa->c_tel_sop }} </td>
                        </tr>
                    @else
                         <tr>
                            <td width="100%" colspan="2">Celular Ventas: {{ $datos->c_tel }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td width="100%" colspan="2">Asesor de Venta: {{ $datos->nomEmpleado }} {{ $datos->c_pri_ape }} {{ $datos->c_seg_ape }}</td>
                    </tr>

                </tbody>
            </table>
        </td>
        <td width="35%">
            <table class="voucher-information-right">
                <tbody>
                    <tr>
                        <td width="100%" colspan="2" style="text-align: center; font-size: 30px;">Cotización</td>
                    </tr>
                    <tr>
                        <td width="50%" style="text-align: right;">FECHA: </td>
                        <td width="50%">{{ $datos->f_hor_fac }}</td>
                    </tr>
                   <tr>
                        <td width="50%" style="text-align: right;">COTIZACIÓN: </td>
                        <td width="50%">{{$datos->c_doc}}</td>
                    </tr>
                    <tr>
                        <td width="50%" style="text-align: right;">VALIDO HASTA: </td>
                        <td width="50%">{{$datos->f_hor_fac_ven}}</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>
<br>
{{-- <table class="table-style-two" style="width: 100%">
    <thead>
        <tr>
            <th>CLIENTE</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $datos->c_raz }}</td>
        </tr>
        <tr>
            <td style="text-transform: uppercase">{{ $datos->c_dir }} {{ $datos->nomDepartamento }} - {{ $datos->nomProvincia }} - {{ $datos->nomDistrito }}</td>
        </tr>
    </tbody>
</table> --}}
@if($datos->pk_tip_doc_id=="2")
    <div style="font-weight:bold;">{{ $datos->c_raz }}</div>
    <div style="font-weight:bold;">{{ $datos->nomDepartamento }} - {{ $datos->nomProvincia }} - {{ $datos->nomDistrito }}</div>
{{--     <div style="font-weight:bold;">{{ $datos->nomDepartamento }} - Perú</div> --}}
    <div style="font-weight:bold;">ESTIMADO/A</div>
    <div style="font-weight:bold;">{{ $datos->c_rep }}</div>
@else
    <div style="font-weight:bold;">ESTIMADO/A</div>
    <div style="font-weight:bold;">{{ $datos->c_raz }}</div>
    <div style="font-weight:bold;">{{ $datos->nomDepartamento }} - Perú</div>
@endif
<br>
<div style="text-align:left;">
    @if($datos->c_asu!="")
        ASUNTO: {{ $datos->c_asu }}
    @endif

</div>
<br>

<table class="table-style-two">
    <tbody>
        <tr>
            <th>CANT</th>
            <th colspan="2">DESCRIPCIÓN DE LOS EQUIPOS DE SEGURIDAD Ó SERVICIOS</th>
            <th>PRECIO UNI.</th>
            <th>TOTAL</th>
        </tr>
      @php $id = 1; @endphp
      @foreach ($comprobanteDetalle as $detalle)
        <tr>
            <td style="text-align: center;">{{ $detalle->n_can }}</td>
            <td>
              <span style="font-weight:bold;">{{ $detalle->c_nom }}</span>
              <div style="margin-top: 0px"> {!! $detalle->c_obs !!}</div>
            </td>
            <td style="text-align: center;">
              <img id='img-upload' src="../public/images/{{ $detalle->c_img }}" style="width: 100px; height: 100px;" />
            </td>
            <td style="text-align: center;">{{ $detalle->n_pre }}</td>
            <td style="text-align: center;">@php echo number_format((float)$detalle->n_can * $detalle->n_pre, 2, '.', ''); @endphp</td>
        </tr>
      @php $id++; @endphp
      @endforeach
    </tbody>
</table>
<table class="table-style-footer">
    <tfoot>

        <?php
            if($datos->fk_tip_doc_id==2){
        ?>
        <tr style="border-color: #BC180D;">
          <th colspan="5" style="text-align: right; padding-left: 585px; background-color: #BC180D;" >SUB TOTAL:</th>
          <th style="text-align: right; padding-left: 38px;  background-color: #BC180D;">{{ number_format($datos->n_sub_tot, 2) }}</th>
        </tr>

        <tr>
          <th colspan="5" style="text-align: right; background-color: #BC180D;">IGV:</th>
          <th style="text-align: right; background-color: #BC180D;">{{ number_format($datos->n_igv, 2) }}</th>
        </tr>

        <tr>
          <th colspan="5" style="text-align: right; background-color: #BC180D;">TOTAL S/:</th>
          <th style="text-align: right; background-color: #BC180D;">{{ number_format($datos->n_tot, 2) }}</th>
        </tr>
        @if($datos->n_des!="")
            <tr style="border-color: #BC180D;">
              <th colspan="5" style="text-align: right; background-color: #BC180D;" >%DESC:</th>
              <th style="text-align: right; background-color: #BC180D;">{{$datos->n_des}}</th>
            </tr>
            <tr style="border-color: #BC180D;">
              <th colspan="5" style="text-align: right; background-color: #BC180D;" >%TOTAL DESC S/:</th>
              <th style="text-align: right; background-color: #BC180D;">{{ number_format($datos->n_tot_des, 2) }}</th>
            </tr>
        @endif
        <?php
            }else{
                ?>
                    <tr>
                      <th colspan="10" style="text-align: right; padding-left: 585px;  background-color: #BC180D;">TOTAL S/:</th>
                      <th style="text-align: right; padding-left: 50px; background-color: #BC180D;">{{ number_format($datos->n_tot, 2) }}</th>
                    </tr>

                    @if($datos->n_des!="")
                        <tr style="border-color: #BC180D;">
                          <th colspan="10" style="text-align: right;  background-color: #BC180D;" >%DESC:</th>
                          <th style="text-align: right; background-color: #BC180D;">{{$datos->n_des}}</th>
                        </tr>
                        <tr style="border-color: #BC180D;">
                          <th colspan="10" style="text-align: right;  background-color: #BC180D;" >%TOTAL DESC S/:</th>
                          <th style="text-align: right; background-color: #BC180D;">{{ number_format($datos->n_tot_des, 2) }}</th>
                        </tr>
                    @endif
                <?php
            }
        ?>



    </tfoot>
</table>
<table class="voucher-footer">
    <tbody>
    <tr>
        {{--<td class="text-center font-sm">Para consultar el comprobante ingresar a {{ $company->cpe_url }}</td>--}}
    </tr>
    </tbody>
</table>
<br><br>
<div style="text-align:left;">
    <span style="text-decoration: underline; font-weight: bold;">
      TÉRMINOS Y CONDICIONES DEL PROYECTO
    </span>
<br><br>
     A continuación, se detallan los términos y condiciones aplicables al inicio y finalización del proyecto, así como las políticas de pago y horarios de instalación.
<br><br>
  &nbsp; &nbsp; &nbsp; 1. Estructura de Pagos
    <ul>
        <li>
            Inicio del Proyecto: Se requiere un pago del 50% del costo total al inicio de la obra. Este pago es aplicable tanto para clientes corporativos como individuales.
        </li>
        <li>
            Finalización del Proyecto: El 50% restante se deberá abonar una vez que se haya completado la obra y se haya obtenido la conformidad del cliente.
        </li>
    </ul>
  &nbsp; &nbsp; &nbsp; 2.  Medios de Pago
    <ul>
        <li>
            Los pagos se realizarán mediante depósito en cuenta o transferencia electrónica.
        </li>
    </ul>
  &nbsp; &nbsp; &nbsp; 3.  Modificaciones en el Proyecto
    <ul>
        <li>
            Una vez confirmados los puntos de instalación, no se podrán realizar modificaciones.
        </li>
        <li>
            En caso de que se requieran cambios, se aplicará un cobro adicional por dichos cambios.
        </li>
    </ul>
  &nbsp; &nbsp; &nbsp; 4.  Horarios de Instalación
    <ul>
        <li>
            Todos los servicios de instalación se llevarán a cabo en los siguientes horarios:
        </li>
        <li>
            Lunes a Viernes: 8:00 am – 18:00 pm
        </li>
        <li>
            Sábados: 8:00 am – 18:00 pm
        </li>
        <li>
Si se requieren servicios fuera del horario estipulado, el precio por mano de obra aumentará un 30% por cada punto adicional.
        </li>
    </ul>
  &nbsp; &nbsp; &nbsp; 5.  Validez de la Oferta
    <ul>
        <li>
            Esta oferta tiene una validez de 15 días a partir de la fecha de emisión.
        </li>
        <li>
            Si tienes alguna pregunta o necesitas más información, no dudes en contactarnos. ¡Estamos aquí para ayudarte!
        </li>
    </ul>

</div>
<br>

@if($datos->f_ini_obra!=null || $datos->f_fin_obra!=null)
    <div style="text-align:left;">
        <span style="   text-decoration: underline;">
          INICIO DE OBRA Y FINALIZACIÓN DE OBRA:
        </span>
        <ul>
            <li>
                Inicio de Obra: {{ $datos->f_ini_obra }} 
            </li>
            <li>
                Fin de Obra: {{ $datos->f_fin_obra }}
            </li>
        </ul>
    </div>
@endif

<div style="text-align:left; font-weight: bold;">
    <span style="text-decoration: underline; color: red;">
      CUENTA DEL BANCO CONTINENTAL: GRUPO GM SYSTEM  SAC
    </span>
    <ul>
        <li style="font-weight: bold;">
            CUENTA EN SOLES: 0011-0508-0200231467 (Código interbancario soles: 011-508-000200231467-98)
        </li>
        <li style="font-weight: bold;">
             CUENTA DE DETRACCIÓN: BANCO DE LA NACIÓN: 00008051593
        </li>
{{--         <li style="font-weight: bold;">
            CUENTA AHORRO DOLARES: 194-91149215-1-12 (Código interbancario dólares: 002-19419114921511298)
        </li>
        <li style="font-weight: bold;">
            Cuenta detracción del Banco de la Nación (Número de cuenta: 00046257715)
        </li> --}}
    </ul>
</div>


</body>
</html>




