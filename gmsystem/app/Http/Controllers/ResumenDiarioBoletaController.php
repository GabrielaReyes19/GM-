<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Comprobante;
use App\ResumenRc;
use App\Empresa;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use GuzzleHttp\Client;

class ResumenDiarioBoletaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('redireccionaSiNoExisteSucursal');
        $this->nameModule = "resumenDiario";
        $this->titleModule = "Factura Anulada";
        $this->linkBaseModule = "resumen_diario";
    }
    public function index()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        return view('resumenDiario.index', compact('titleModule','linkBaseModule','nameModule'));
    }

    public function indexAnulado()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        return view('resumenAnulado.index', compact('titleModule','linkBaseModule','nameModule'));
    }

    public function create()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        

        return view('resumenDiario.create',compact('nameModule','titleModule','linkBaseModule'));        
    }

    public function apiresumenRc(Request $request)
    {
        $fec = $request->input('fec');
        $fecFin = $request->input('fecFin');
        $boletaRC = ResumenRc::Busqueda($fec,$fecFin);
        return Datatables::of($boletaRC)
            ->addColumn('xml', function($boletaRC){
                 // return '<button class="btn btn-primary btn-rounded btn-xs" onclick="consultarXml(\''.$boletaRC->c_ar_sun.'\');">XML</button>';

                return'<div id="preload'.$boletaRC->pk_rc_id.'"></div><div id="carga'.$boletaRC->pk_rc_id.'"><a id="xml'.$boletaRC->pk_rc_id.'" onclick="consultarXml(\''.$boletaRC->c_ar_sun.'\',\''.$boletaRC->pk_rc_id.'\');" class="btn btn-rounded btn-xs" download><span id="texto'.$boletaRC->pk_rc_id.'">XML</span>  

                </a></div>';
            })

            ->addColumn('cdr', function($boletaRC){
                if($boletaRC->n_est==1){
                    $estadoCdr='';
                }else{
                    $estadoCdr = '<div id="preload2'.$boletaRC->pk_rc_id.'"></div><div id="carga2'.$boletaRC->pk_rc_id.'"><a id="cdr2'.$boletaRC->pk_rc_id.'" onclick="consultarCdr(\''.$boletaRC->c_ar_sun.'\',\''.$boletaRC->pk_rc_id.'\');" class="btn btn-rounded btn-xs" download><span id="texto2'.$boletaRC->pk_rc_id.'">CDR</span>  

                </a></div>';
                }
                return $estadoCdr;
            })
            
            ->addColumn('estado', function($boletaRC){
                if($boletaRC->n_est=="1"){
                    $estado='<a href="#" onclick="return false;" class="label label-warning label-tag">Firmada - Enviada</a>';
                }elseif($boletaRC->n_est=="2"){
                    $estado='<a href="#" onclick="return false;" class="label label-success label-tag">Enviada - Aceptada</a>';
                }elseif($boletaRC->n_est=="3"){
                    $estado='<a href="#" onclick="return false;" class="label label-danger label-tag">Enviada - Rechazada</a>';
                }
                return $estado;
            })

            ->addColumn('total_documentos', function($boletaRC){
                return '<a href="#" onclick="verResumen(\''.$boletaRC->pk_rc_id.'\', \''.$boletaRC->c_cod.'\');">VER NUEVO RESUMEN '.$boletaRC->n_cant_doc.' DOCUMENTOS</a>';
            })

            ->addColumn('action', function($boletaRC){

                if($boletaRC->n_est=="3" || $boletaRC->n_est=="1"){
                    $accion = '<li><a href="#" onclick="consultarEstadoSunat(\''.$boletaRC->c_num_tic.'\',\''.$boletaRC->c_cod.'\',\''.$boletaRC->pk_rc_id.'\',\''.$boletaRC->n_est_anu.'\');" id="consulta">Consultar estado a la SUNAT</a></li>
                    <li><a href="#" onclick="verResumen(\''.$boletaRC->pk_rc_id.'\', \''.$boletaRC->c_cod.'\');">Ver Resumen</a></li>';
                }else{
                    $accion = '<li><a href="#" onclick="verResumen(\''.$boletaRC->pk_rc_id.'\', \''.$boletaRC->c_cod.'\');">Ver Resumen</a></li>';
                }

                return '<div class="btn-group btn-group-xs">
                  <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="fa fa-cog"></span>&nbsp;<span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    '.$accion.'
                  </ul>
                </div>';
            })
            ->rawColumns(['xml', 'cdr', 'estado', 'total_documentos', 'action'])
            ->make(true);
    }

    public function apiResumenDiario($fecha="")
    {
        $boleta = ResumenRc::Busqueda2($fecha);
        return Datatables::of($boleta)
            ->addColumn('numero', function($boleta){
                return str_pad($boleta->c_doc,7,"0",STR_PAD_LEFT).'<input type="hidden" name="id'.$boleta->rownum.'" value="'.$boleta->pk_cpb_id.'">';

            })
            ->rawColumns(['numero'])
            ->make(true);
    }

    public function apiresumenAnuladoRc(Request $request)
    {
        $fec = $request->input('fec');
        $fecFin = $request->input('fecFin');
        $boletaRC = ResumenRc::BusquedaAnulado($fec,$fecFin);
        return Datatables::of($boletaRC)
            ->addColumn('xml', function($boletaRC){
                 // return '<button class="btn btn-primary btn-rounded btn-xs" onclick="consultarXml(\''.$boletaRC->c_ar_sun.'\');">XML</button>';

                return'<div id="preload'.$boletaRC->pk_rc_id.'"></div><div id="carga'.$boletaRC->pk_rc_id.'"><a id="xml'.$boletaRC->pk_rc_id.'" onclick="consultarXml(\''.$boletaRC->c_ar_sun.'\',\''.$boletaRC->pk_rc_id.'\');" class="btn btn-rounded btn-xs" download><span id="texto'.$boletaRC->pk_rc_id.'">XML</span>  

                </a></div>';
            })

            ->addColumn('cdr', function($boletaRC){
                if($boletaRC->n_est==1){
                    $estadoCdr='';
                }else{
                    $estadoCdr = '<div id="preload2'.$boletaRC->pk_rc_id.'"></div><div id="carga2'.$boletaRC->pk_rc_id.'"><a id="cdr2'.$boletaRC->pk_rc_id.'" onclick="consultarCdr(\''.$boletaRC->c_ar_sun.'\',\''.$boletaRC->pk_rc_id.'\');" class="btn btn-rounded btn-xs" download><span id="texto2'.$boletaRC->pk_rc_id.'">CDR</span>  

                </a></div>';
                }
                return $estadoCdr;
            })
            
            ->addColumn('estado', function($boletaRC){
                if($boletaRC->n_est=="1"){
                    $estado='<a href="#" onclick="return false;" class="label label-warning label-tag">Firmada - Enviada</a>';
                }else{
                    $estado='<a href="#" onclick="return false;" class="label label-success label-tag">Enviada - Aceptada</a>';
                }
                return $estado;
            })

            ->addColumn('total_documentos', function($boletaRC){
                return $boletaRC->c_des." ".$boletaRC->c_num_ser." - ".$boletaRC->c_num_doc;
            })

            ->addColumn('action', function($boletaRC){

                return '<div class="btn-group btn-group-xs">
                  <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="fa fa-cog"></span>&nbsp;<span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#" onclick="consultarEstadoSunat(\''.$boletaRC->c_num_tic.'\',\''.$boletaRC->c_cod.'\',\''.$boletaRC->pk_rc_id.'\',\''.$boletaRC->n_est_anu.'\');" id="consulta">Consultar estado a la SUNAT</a></li>
                    <li><a href="#" onclick="verResumen(\''.$boletaRC->pk_rc_id.'\', \''.$boletaRC->c_cod.'\');">Ver Resumen</a></li>
                  </ul>
                </div>';
            })
            ->rawColumns(['xml', 'cdr', 'estado', 'total_documentos', 'action'])
            ->make(true);
    }

    public function apiShowResumenDiario($id="")
    {
        $boleta = ResumenRc::BusquedaVerDetalleResumenPorId($id);
        return Datatables::of($boleta)
            ->addColumn('numero', function($boleta){
                return str_pad($boleta->c_doc,7,"0",STR_PAD_LEFT);

            })
            ->addColumn('aceptada', function($boleta){
                $estadoAceptado='';
                if($boleta->n_est_sun=="1"){
                    $estadoAceptado='<i class="fa fa-times" style="color: #df3823;"></i>';
                }else if($boleta->n_est_sun=="2"){
                    $estadoAceptado='<i class="fa fa-check" style="color: #42a142;"></i>';
                }
                return $estadoAceptado;
            })
            ->addColumn('anulada', function($boleta){
                $estadoAnulado='';
                if($boleta->nEstCom=="0"){
                    $estadoAnulado='<i class="fa fa-check" style="color: #42a142;"></i>';
                }else{
                    $estadoAnulado='<i class="fa fa-times" style="color: #df3823;"></i>';
                }
                return $estadoAnulado;
            })
            ->rawColumns(['numero','anulada','aceptada'])
        ->make(true);
    }

    public function store(Request $request, Filesystem $filesystem)
    {
        $sucursal=session('pk_suc_id');
        $empresa = Empresa::Empresa();
        $tipoDeDocumento="RC";
        $filas = ResumenRc::Total();
        $date = Carbon::now();
        $usuario=auth()->user()->id;
        $razonSocialEmisor=$empresa[0]->c_raz_soc; 
        $numero_de_RUC = $empresa[0]->c_num; 
        $datos = ResumenRc::Correlativo();
        $correlativo = "";
        if(count($datos)!=0) { 
            $suma=$datos[0]->c_num+1;
            $correlativo = $suma;
        }else{
            $correlativo = "1";
        } 
        $fecha=$request->input('fecEmision'); 
        $dia = substr($fecha, 0, 2);
        $mes   = substr($fecha, 3, 2);
        $anio = substr($fecha, 6, 4);

        $fecha2=$request->input('fecGeneracion'); 
        $dia2 = substr($fecha2, 0, 2);
        $mes2   = substr($fecha2, 3, 2);
        $anio2 = substr($fecha2, 6, 4);

        $fecGeneracionDocumento= $anio."-".$mes."-".$dia;
        $fecGeneracionComunicacion = $anio2."-".$mes2."-".$dia2;

        $fecGeneracionComunicacionTxt = Carbon::parse($fecGeneracionComunicacion)->format('Ymd'); 
        $fecGeneracionDocumentoTxt=Carbon::parse($fecGeneracionDocumento)->format('Ymd'); 
        $identificadorDeLaComunicacion = $tipoDeDocumento."-".$fecGeneracionComunicacionTxt."-".$correlativo;
        $observacion = "Boleta";
        $items = [];
        $filas = $request->input('filas'); 
        $message="";
        
        for($i=1; $i<=$filas; $i++)
        {
            $idComprobante=$request->input('id'.$i);
            $comprobante = Comprobante::ComprobanteCabecera($idComprobante);
            $num=$i;
            $serie=$comprobante[0]->c_num_ser;
            $numeroCorrelativo=$comprobante[0]->c_doc;
            $subTotal=$comprobante[0]->n_sub_tot;
            $igv=$comprobante[0]->n_igv;
            $total=$comprobante[0]->n_tot;
            $docCliente=$comprobante[0]->c_num_doc;
            $serBol=$comprobante[0]->c_mod_num_ser;
            $docBol=$comprobante[0]->c_mod_doc;
            $tipDocRel="03";
            $tipoDocuemtno=$comprobante[0]->c_num;

            if($serBol=="" && $docBol==""){
                $serBol="";
                $docBol="";
                $tipDocRel="";
            }
            if($serie!=null){
                // $items[]=  [
                //     'tipo_de_documento_catalogo_'.$tipoDocuemtno.'' => ''.$tipoDocuemtno.'',
                //     'numero_de_serie_del_documento' => ''.$serie.'',
                //     'numero_correlativo_del_documento' => ''.$numeroCorrelativo.'',
                //     'numero_de_documento_de_identidad_del_adquirente_o_usuario' => ''.$docCliente.'',
                //     'tipo_de_documento_catalogo_relacionado' => ''.$tipDocRel.'',
                //     'numero_de_serie_del_documento_relacionado' => ''.$serBol.'',
                //     'numero_del_documento_relacionado' => ''.$docBol.'',
                //     'total_valor_de_venta_operaciones_gravadas' => ''.$subTotal.'!01' ,
                //     'total_valor_de_venta_operaciones_exoneradas' => '10.00!02' ,
                //     'Total_valor_de_venta_operaciones inafectas' => '10.00!03',
                //     'importe_total_de_sumatoria_otros_cargos_del_item' => 'true!10.00',
                //     'total_ISC' => '10.00!10.00!2000!ISC!EXC',
                //     'Total_IGV' => ''.$igv.'!'.$igv.'!1000!IGV!VAT' ,
                //     'total_otros_tributos' => '0!0!9999!OTROS!OTH' ,
                //     'importe_total_de_la venta_o_sesion_en_uso_o_del_servicio_prestado' => ''.$total.'',
                //     'numero_correlativo_de_la_boleta_de_venta_que modifica' => $num,
                //     'estado_del_item' => '1'
                //   ];

                $items[]=  [
                    'tipo_de_documento_catalogo_'.$tipoDocuemtno.'' => ''.$tipoDocuemtno.'',
                    'numero_de_serie_del_documento' => ''.$serie.'',
                    'numero_correlativo_del_documento' => ''.$numeroCorrelativo.'',
                    'numero_de_documento_de_identidad_del_adquirente_o_usuario' => ''.$docCliente.'',
                    'tipo_de_documento_catalogo_relacionado' => ''.$tipDocRel.'',
                    'numero_de_serie_del_documento_relacionado' => ''.$serBol.'',
                    'numero_del_documento_relacionado' => ''.$docBol.'',
                    'total_valor_de_venta_operaciones_gravadas' => ''.$subTotal.'!01' ,
                    'total_valor_de_venta_operaciones_exoneradas' => '10.00!02' ,
                    'Total_valor_de_venta_operaciones inafectas' => '10.00!03',
                    'importe_total_de_sumatoria_otros_cargos_del_item' => 'true!10.00',
                    'Total_IGV' => ''.$igv.'!'.$igv.'!1000!IGV!VAT' ,
                    'importe_total_de_la venta_o_sesion_en_uso_o_del_servicio_prestado' => ''.$total.'',
                    'numero_correlativo_de_la_boleta_de_venta_que modifica' => $num,
                    'estado_del_item' => '1'
                  ];
            }
        }

        $base_api = env('URL_FE');
        $endpoint = "/api/process-txt";
        // fecha_de_generación_del_documento_dado_de_baja" =>se refiera a la fecha de emisión de las facturas
        // fecha_de_generación_de_la_comunicación => se refiere a la fecha en que estas creando el archivo que contienes las facturas
        $data_json = 
        '{
          "cabeceraDocumento": [
            {
                "apellidos_y_nombres_denominacion_o_razon_social": "'.$razonSocialEmisor.'", 
                "numero_de_RUC": "'.$numero_de_RUC.'!6",   
                "fecha_de_generación_del_documento_dado_de_baja": "'.$fecGeneracionDocumento.'",
                "identificador_de_la_comunicación": "'.$identificadorDeLaComunicacion.'", 
                "fecha_de_generación_de_la_comunicación": "'.$fecGeneracionComunicacion.'", 
                "firma_digital": "",
                "version_del_UBL": "2.0", 
                "version_de_la_estrucutra": "1.1",
                "observacion_del_resumen": "'.$observacion.'"
            }
          ],
          "itemsDocumento": '.json_encode($items).'
        }';

        //JSON TO Array
        $assocArray = json_decode($data_json, true);


        //Cabecera
        $master = $assocArray["cabeceraDocumento"][0];
        foreach($master as $k => $v) {
            $values[] = $v;
        }
        $csv_master = implode('|', $values);


        //Detalle
        $detail = $assocArray["itemsDocumento"];
        foreach($detail as $line) {

            $values2 = array();
            foreach($line as $k2 => $v2) {  

                $values2[] = $v2;

            }
            $csv_detail[] = implode('|', $values2);

        }
        $csv_detail = implode(PHP_EOL, $csv_detail);

        //Generated TXTs
        $name = $fecGeneracionDocumentoTxt."-".$numero_de_RUC."-".$tipoDeDocumento."-".$fecGeneracionComunicacionTxt."-".$correlativo.".txt";
        $nameBd = $numero_de_RUC."-".$tipoDeDocumento."-".$fecGeneracionComunicacionTxt."-".$correlativo;
        $filesystem->put($name, $csv_master . PHP_EOL . $csv_detail);

        $file = storage_path('app/'.$name);
        $client = new Client(['base_uri' => $base_api]);
        $response = $client->post($endpoint,
            [
                'http_errors'=>true,
                'headers' => [
                    'Accept' => 'application/json',
                 ],
                'multipart' => [
                    [
                        'name'     => 'text_plain',
                        'contents' => fopen($file, 'r'),
                        'filename' => $file
                    ]
                ]
            ]);
        $contents = (string) $response->getBody()->getContents();
        $result = json_decode($contents, true);
        $numero_ticket=$result["ticket"];

        if($result["ticket"]!=""){
            $data = array(
                "fk_suc_id" => $sucursal,
                "c_cod" => $identificadorDeLaComunicacion,
                "c_num_tic" => "",
                "c_num" => $correlativo,
                "n_cant_doc" => $filas,
                "c_ar_sun" => "",
                "n_est" => "1",
                "f_gen" => $fecGeneracionComunicacion,
                "f_emi" => $fecGeneracionDocumento,
                "c_usu_cre" => $usuario,
                "f_cre" => Carbon::now(),
            );
            $id = DB::table('mov_rc')->insertGetId($data,'pk_rc_id');

            for($i=1; $i<=$filas; $i++)
            {
                $idComprobante=$request->input('id'.$i);
                $comprobante = Comprobante::ComprobanteCabecera($idComprobante);
                $idCliente=$comprobante[0]->fk_cli_id;
                $idTipDocVenta=$comprobante[0]->fk_tip_doc_ven_id;
                $serie=$comprobante[0]->c_num_ser;
                $numeroCorrelativo=$comprobante[0]->c_doc;
                $subTotal=$comprobante[0]->n_sub_tot;
                $igv=$comprobante[0]->n_igv;
                $total=$comprobante[0]->n_tot;
                $docCliente=$comprobante[0]->c_num_doc;
                $fecha=$comprobante[0]->fComprobante;
                $monedaId=$comprobante[0]->fk_mon_id;
                $data2 = array(
                    "fk_rc_id" => $id,
                    "fk_mon_id" => $id,
                    "c_num_ser" => $serie,
                    "c_num_doc" => $numeroCorrelativo,
                    "f_doc" => $fecha,
                    "c_mot" => $observacion,
                    "n_sub_tot" => $subTotal,
                    "n_igv" => $igv,
                    "n_tot" => $total,
                    "fk_cpb_id" => $idComprobante,
                    "fk_mon_id" => $monedaId
                );
                if($serie!=null){
                    DB::table('mov_detalle_rc')->insertGetId($data2,'pk_det_ra_id');

                    DB::table('mov_comprobante')->where('pk_cpb_id',$idComprobante)->update([
                        "fk_rc_id" => $id,
                        "n_est_sun" => "2",
                        "n_est" => "6",
                        "n_est_rc" => "2"
                    ]);
                }
            }

            DB::table('mov_rc')->where('pk_rc_id',$id)->update([
                "c_ar_sun" => $nameBd,
                "c_num_tic" => $numero_ticket,
            ]);

            $message="AGREGADO, NO OLVIDES CONSULTAR EL ESTADO DEL RESUMEN DIARIO EN LA SUNAT LUEGO DE UNOS MINUTOS";
        }else{
            $message="NO SE PUEDO AGREGAR, pOR FAVOR VUELVA A AGREGAR EL RESUMEN DIARIO";
        }
        $success=TRUE;
        $datos_json = response()->json(['success' =>  $success, 'result' =>  $result, 'message' =>  $message]);
        return $datos_json;

    }

    public function storeAnulado(Request $request, Filesystem $filesystem)
    {
        $empresa = Empresa::Empresa();
        $tipoDeDocumento="RC";
        $correlativo=$request->input('num');
        $filas = ResumenRc::Total();
        $date = Carbon::now();
        $usuario=auth()->user()->id;
        $sucursal=session('pk_suc_id');
        $razonSocialEmisor=$empresa[0]->c_raz_soc; 
        $numero_de_RUC = $empresa[0]->c_num; 
        $fecha=$request->input('fecComprobante'); 
        $dia = substr($fecha, 0, 2);
        $mes   = substr($fecha, 3, 2);
        $anio = substr($fecha, 6, 4);

        $fecha2=$request->input('fecAnulacion'); 
        $dia2 = substr($fecha2, 0, 2);
        $mes2   = substr($fecha2, 3, 2);
        $anio2 = substr($fecha2, 6, 4);

        $fecGeneracionDocumento= $anio."-".$mes."-".$dia;
        $fecGeneracionComunicacion = $anio2."-".$mes2."-".$dia2;

        $fecGeneracionComunicacionTxt = Carbon::parse($fecGeneracionComunicacion)->format('Ymd'); 
        $fecGeneracionDocumentoTxt=Carbon::parse($fecGeneracionDocumento)->format('Ymd'); 
        $identificadorDeLaComunicacion = $tipoDeDocumento."-".$fecGeneracionComunicacionTxt."-".$correlativo;
        $observacion = $request->input('mot');
        $items = [];
        $filas = "1"; 
        $message="";
        
        #Detalle
        $idComprobante=$request->input('id');
        $comprobante = Comprobante::ComprobanteCabecera($idComprobante);
        $num="1";
        $serie=$comprobante[0]->c_num_ser;
        $numeroCorrelativo=$comprobante[0]->c_doc;
        $subTotal=$comprobante[0]->n_sub_tot;
        $igv=$comprobante[0]->n_igv;
        $total=$comprobante[0]->n_tot;
        $docCliente=$comprobante[0]->c_num_doc;
        $serBol=$comprobante[0]->c_mod_num_ser;
        $docBol=$comprobante[0]->c_mod_doc;
        $tipDocRel="03";
        $tipoDocuemtno=$comprobante[0]->c_num;
        if($serBol=="" && $docBol==""){
            $serBol="";
            $docBol="";
            $tipDocRel="";
        }

        $data = array(
            "fk_suc_id" => $sucursal,
            "c_cod" => $identificadorDeLaComunicacion,
            "c_num_tic" => "",
            "c_num" => $correlativo,
            "n_cant_doc" => $filas,
            "c_ar_sun" => "",
            "n_est" => "1",
            "n_est_anu" => "2",
            "f_gen" => $fecGeneracionComunicacion,
            "f_emi" => $fecGeneracionDocumento,
            "c_usu_cre" => $usuario,
            "f_cre" => Carbon::now(),
        );
        $id = DB::table('mov_rc')->insertGetId($data,'pk_rc_id');
        $idComprobante=$request->input('id');
        $comprobante = Comprobante::ComprobanteCabecera($idComprobante);
        $idCliente=$comprobante[0]->fk_cli_id;
        $idTipDocVenta=$comprobante[0]->fk_tip_doc_ven_id;
        $serie=$comprobante[0]->c_num_ser;
        $numeroCorrelativo=$comprobante[0]->c_doc;
        $subTotal=$comprobante[0]->n_sub_tot;
        $igv=$comprobante[0]->n_igv;
        $total=$comprobante[0]->n_tot;
        $docCliente=$comprobante[0]->c_num_doc;
        $fecha=$comprobante[0]->fComprobante;
        $monedaId=$comprobante[0]->fk_mon_id;
        $data2 = array(
            "fk_rc_id" => $id,
            "c_num_ser" => $serie,
            "c_num_doc" => $numeroCorrelativo,
            "f_doc" => $fecha,
            "c_mot" => $observacion,
            "n_sub_tot" => $subTotal,
            "n_igv" => $igv,
            "n_tot" => $total,
            "fk_cpb_id" => $idComprobante,
            "fk_mon_id" => $monedaId
        );

        DB::table('mov_detalle_rc')->insertGetId($data2,'pk_det_ra_id');
        DB::table('mov_comprobante')->where('pk_cpb_id',$idComprobante)->update([
            "fk_rc_id" => $id,
            "n_est_sun" => "2",
            "n_est" => "0"
        ]);
        $success=TRUE;
        $message="AGREGADO, NO OLVIDES CONSULTAR EL ESTADO DEL RESUMEN DIARIO EN LA SUNAT LUEGO DE UNOS MINUTOS";
        $datos_json = response()->json(['success' =>  $success]);
        return $datos_json;

    }

    public function show($id, $id2)
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        
        return view('resumenDiario.show',compact('nameModule','titleModule','linkBaseModule','correlativo','id','id2'));   
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function procesarTicket(Request $request)
    {
        $id = $request->input('id');
        $id2 = $request->input('id2');
        $id3 = $request->input('id3');
        $id4 = $request->input('id4');
        $base_api = env('URL_FE');
        $endpoint = "/api/process-txt";
        $client = new Client(['base_uri' => $base_api]);
        $response = $client->post('/api/get-status-ticket',
            [
                'http_errors'=>true,
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'id' => $id,
                    'send' => true
                ],
            ]);
        $contents = (string) $response->getBody()->getContents();
        $result = json_decode($contents, true);
        if($result["message"]["code"]=="0"){
            # Actualizamos estado a Firmada - Enviada
            DB::table('mov_rc')->where('c_num_tic',$id)->update([
                "n_est" => "2"
            ]);

            # Actualizamos estado a Aceptada

            DB::table('mov_comprobante')->where('fk_rc_id',$id3)->update([
                "n_est_sun" => "3",
                "n_est" => "2"
            ]);

            if($id4=="2"){
                DB::table('mov_comprobante')->where('fk_rc_id',$id3)->update([
                    "n_est" => "0"
                ]);
            }

            if($id4=="1"){
                $mensaje="Enviado a la SUNAT. CÓDIGO: ".$result["message"]["code"]." | DESCRIPCIÓN: El resumen diario ".$id2.", ha sido aceptada.";
            }else{
                $mensaje="Enviado a la SUNAT. CÓDIGO: ".$result["message"]["code"]." | DESCRIPCIÓN: La Comunicacion de baja ".$id2.", ha sido aceptada.";
            }
        }elseif($result["message"]["code"]=="99"){
            $mensaje="Enviado a la SUNAT. CÓDIGO: ".$result["message"]["code"]." | DESCRIPCIÓN: El resumen diario ".$id2.", ha sido rechazado.";
            $activarResumen = ResumenRc::ActivarComprobante($id3);
            for($i=0; $i < sizeof($activarResumen); $i++)
            {
                DB::table('mov_comprobante')->where('pk_cpb_id',$activarResumen[$i]->pk_cpb_id)->update([
                    "n_est_rc" => "1",
                    "n_est" => "6",
                    "n_est_sun" => "1"
                ]);
            }
            DB::table('mov_rc')->where('c_num_tic',$id)->update([
                "n_est" => "3"
            ]);
        }elseif($result["message"]["code"]=="0127"){
            $mensaje="Enviado a la SUNAT. CÓDIGO: ".$result["message"]["code"]." | DESCRIPCIÓN: El resumen diario ".$id2.", ya ha sido generado.";
        }else{
            $mensaje="Enviado a la SUNAT. CÓDIGO: ".$result["message"]["code"]." | DESCRIPCIÓN: El resumen diario ".$id2.", ya ha sido rechazado.";
            DB::table('mov_comprobante')->where('pk_cpb_id',$activarResumen[$i]->pk_cpb_id)->update([
                "n_est_rc" => "1",
                "n_est" => "6",
                "n_est_sun" => "1"
            ]);
        }

        $success=TRUE;
        $datos_json = response()->json(['success' =>  $success, 'result' =>  $mensaje, 'codigo' => $result["message"]["code"]]);
        return $datos_json;
    }

    public function contar($fecha="")
    {
        $sucursal=session('pk_suc_id');
        $contar = Comprobante::whereIn('fk_tip_doc_ven_id', [2,3,4])->where(['f_hor_fac' => $fecha])->where('fk_suc_id', $sucursal)->where(['n_est_rc' => "1"])->count();
        $success=TRUE;
        $datos_json = response()->json([
          'success' =>  $success,
          'result' =>  $contar]);

        return $datos_json;
    }

}
