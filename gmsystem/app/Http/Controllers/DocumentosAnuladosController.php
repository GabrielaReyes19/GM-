<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Comprobante;
use App\FacturaRa;
use App\Empresa;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use GuzzleHttp\Client;

class DocumentosAnuladosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('redireccionaSiNoExisteSucursal');
        $this->nameModule = "documentosAnulados";
        $this->titleModule = "Factura Anulada";
        $this->linkBaseModule = "documentos_anulados";
    }
    public function index()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        return view('documentoAnulado.index', compact('titleModule','linkBaseModule','nameModule'));
    }

    public function create()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $datos = FacturaRa::Correlativo();
        if(count($datos)!=0) { 
            $suma=$datos[0]->c_num+1;
            $correlativo = $suma;
        }else{
            $correlativo = "1";
        } 
        return view('documentoAnulado.create',compact('nameModule','titleModule','linkBaseModule','correlativo'));        
    }

    public function apiFacturaRa(Request $request)
    {
        $fec = $request->input('fec');
        $fecFin = $request->input('fecFin');
        $facturaRa = FacturaRa::Busqueda($fec,$fecFin);
        return Datatables::of($facturaRa)
            ->addColumn('xml', function($facturaRa){
                return'<div id="preload'.$facturaRa->pk_ra_id.'"></div><div id="carga'.$facturaRa->pk_ra_id.'"><a id="xml'.$facturaRa->pk_ra_id.'" onclick="consultarXml(\''.$facturaRa->c_ar_sun.'\',\''.$facturaRa->pk_ra_id.'\');" class="btn btn-rounded btn-xs" download><span id="texto'.$facturaRa->pk_ra_id.'">XML</span>  

                </a></div>';
            })

            ->addColumn('cdr', function($facturaRa){
                if($facturaRa->n_est==1){
                    $estadoCdr='';
                }else{
                    $estadoCdr = '<div id="preload2'.$facturaRa->pk_ra_id.'"></div><div id="carga2'.$facturaRa->pk_ra_id.'"><a id="cdr2'.$facturaRa->pk_ra_id.'" onclick="consultarCdr(\''.$facturaRa->c_ar_sun.'\',\''.$facturaRa->pk_ra_id.'\');" class="btn btn-rounded btn-xs" download><span id="texto2'.$facturaRa->pk_ra_id.'">CDR</span>  

                </a></div>';
                }
                return $estadoCdr;
            })
            ->addColumn('estado', function($facturaRa){
               if($facturaRa->n_est=="1"){
                    $estado='<a href="#" onclick="return false;" class="label label-warning label-tag">Firmada - Enviada</a>';
                }else{
                    $estado='<a href="#" onclick="return false;" class="label label-success label-tag">Enviada - Aceptada</a>';
                }
                return $estado;
            })
            ->addColumn('documento', function($facturaRa){
                return $facturaRa->c_des." ".$facturaRa->c_num_ser." - ".$facturaRa->c_num_doc;
            })

            ->addColumn('action', function($facturaRa){

                return '<div class="btn-group btn-group-xs">
                  <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="fa fa-cog"></span>&nbsp;<span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#" onclick="consultarEstadoSunat(\''.$facturaRa->c_num_tic.'\',\''.$facturaRa->c_cod.'\',\''.$facturaRa->pk_ra_id.'\');" id="consulta">Consultar estado a la SUNAT</a></li>
                  </ul>
                </div>';
            })
            ->rawColumns(['xml', 'cdr', 'documento', 'estado', 'action'])
            ->make(true);
    }

    // public function apidocumentoAnulado($fecha="")
    // {
    //     $factura = Comprobante::Busqueda2($fecha);
    //     return Datatables::of($factura)
    //         ->addColumn('correlativo', function($factura){
    //             return $factura->c_num_ser.' '.$factura->c_doc;
    //         })
    //         ->addColumn('check', function($factura){
    //             return '<input type="checkbox" name="chk'.$factura->rownum.'" id="chk'.$factura->rownum.'" value="" onclick="ckeck('.$factura->pk_cpb_id.')";>
    //                     <input type="hidden" name="serie'.$factura->rownum.'" value="'.$factura->c_num_ser.'">
    //                     <input type="hidden" name="correlativo'.$factura->rownum.'" value="'.$factura->c_doc.'">
    //                     <input type="hidden" name="subTotal'.$factura->rownum.'" value="'.$factura->n_sub_tot.'">
    //                     <input type="hidden" name="igv'.$factura->rownum.'" value="'.$factura->n_igv.'">
    //                     <input type="hidden" name="total'.$factura->rownum.'" value="'.$factura->n_tot.'">';
    //         })
    //         ->addColumn('motivo', function($factura){
    //             return '<textarea cols="" rows="1" class="form-control input-sm" name="motivo'.$factura->pk_cpb_id.'" id="motivo'.$factura->pk_cpb_id.'"></textarea>';
    //         })
    //         ->rawColumns(['correlativo', 'check', 'motivo'])
    //         ->make(true);
    // }

    public function store(Request $request, Filesystem $filesystem)
    {
        $sucursal=session('pk_suc_id');
        $idComprobante = $request->input('id');  
        $Comprobante = Comprobante::ComprobanteCabecera($idComprobante);
        $empresa = Empresa::Empresa();
        $correlativo=$request->input('num');
        $date = Carbon::now();
        $usuario=auth()->user()->id;
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
        $identificadorDeLaComunicacion = "RA-".$fecGeneracionComunicacionTxt."-".$correlativo;
        $items = [];
        $motivo = $request->input('mot');
        $tipoDocuemtno=$Comprobante[0]->c_num;
        $pk_cpb_id=$Comprobante[0]->pk_cpb_id;
        $serie=$Comprobante[0]->c_num_ser;
        $numeroCorrelativo=str_pad($Comprobante[0]->c_doc,7,"0",STR_PAD_LEFT);
        $numeroItem="1";
        $subTotal=$Comprobante[0]->n_sub_tot;
        $igv=$Comprobante[0]->n_igv;
        $total=$Comprobante[0]->n_tot;
        // $base_api = env('URL_FE');
        // $endpoint = "/api/process-txt";
        // $items[]=  [
        //     'tipo_de_Documento ' => ''.$tipoDocuemtno.'',
        //     'serie_del_documento_dado_de_baja' => ''.$serie.'',
        //     'numero_correlativo_del_documento_dado_de_baja' => ''.$numeroCorrelativo.'',
        //     'motivo_de_baja' => ''.$motivo.'',
        //     'numero_de_item ' => ''.$numeroItem.''
        //   ];
        // $data_json = 
        // '{
        //   "cabeceraDocumento": [
        //     {
        //         "apellidos_y_nombres_denominacion_o_razon_social": "'.$razonSocialEmisor.'", 
        //         "numero_de_RUC": "'.$numero_de_RUC.'!6",   
        //         "fecha_de_generación_del_documento_dado_de_baja": "'.$fecGeneracionDocumento.'",
        //         "identificador_de_la_comunicación": "'.$identificadorDeLaComunicacion.'", 
        //         "fecha_de_generación_de_la_comunicación": "'.$fecGeneracionComunicacion.'", 
        //         "firma_digital": "",
        //         "version_del_UBL": "2.0", 
        //         "version_de_la_estrucutra": "1.0"
        //     }
        //   ],
        //   "itemsDocumento": '.json_encode($items).'
        // }';

        // //JSON TO Array
        // $assocArray = json_decode($data_json, true);

        // //Cabecera
        // $master = $assocArray["cabeceraDocumento"][0];
        // foreach($master as $k => $v) {
        //     $values[] = $v;
        // }
        // $csv_master = implode('|', $values);


        // //Detalle
        // $detail = $assocArray["itemsDocumento"];
        // foreach($detail as $line) {

        //     $values2 = array();
        //     foreach($line as $k2 => $v2) {  

        //         $values2[] = $v2;

        //     }
        //     $csv_detail[] = implode('|', $values2);

        // }
        // $csv_detail = implode(PHP_EOL, $csv_detail);

        // //Generated TXTs
        // $name = $fecGeneracionDocumentoTxt."-".$numero_de_RUC."-RA-".$fecGeneracionComunicacionTxt."-".$correlativo.".txt";
        // $nameBd = $numero_de_RUC."-RA-".$fecGeneracionComunicacionTxt."-".$correlativo;
        // $filesystem->put($name, $csv_master . PHP_EOL . $csv_detail);
        // $file = storage_path('app/'.$name);
        // $client = new Client(['base_uri' => $base_api]);
        // $response = $client->post($endpoint,
        //     [
        //         'http_errors'=>true,
        //         'headers' => [
        //             'Accept' => 'application/json',
        //          ],
        //         'multipart' => [
        //             [
        //                 'name'     => 'text_plain',
        //                 'contents' => fopen($file, 'r'),
        //                 'filename' => $file
        //             ]
        //         ]
        //     ]);
        // $contents = (string) $response->getBody()->getContents();
        // $result = json_decode($contents, true);
        // $numero_ticket=$result["ticket"];
        $message="";
        // if($result["ticket"]!=""){
            $data = array(
                "fk_suc_id" => $sucursal,
                "c_cod" => $identificadorDeLaComunicacion,
                "c_num_tic" => "",
                "c_num" => $correlativo,
                "c_ar_sun" => "",
                "n_est" => "1",
                "f_baja" => $fecGeneracionComunicacion,
                "c_usu_cre" => $usuario,
                "f_cre" => Carbon::now(),
            );
            $id = DB::table('mov_ra')->insertGetId($data,'pk_ra_id');
            $data2 = array(
                "fk_ra_id" => $id,
                "fk_cpb_id" => $pk_cpb_id,
                "c_num_ser" => $serie,
                "c_num_doc" => $numeroCorrelativo,
                "n_sub_tot" => $subTotal,
                "n_igv" => $igv,
                "n_tot" => $total,
                "f_doc" => $fecGeneracionDocumento,
                "c_mot" => $motivo
            );
            DB::table('mov_detalle_ra')->insertGetId($data2,'pk_det_ra_id');
            DB::table('mov_comprobante')->where('pk_cpb_id',$idComprobante)->update([
                "fk_ra_id" => $id,
                "n_est" => "0"
            ]);

            // DB::table('mov_ra')->where('pk_ra_id',$id)->update([
            //     "c_ar_sun" => $nameBd,
            //     "c_num_tic" => $numero_ticket,
            // ]);
            $message="AGREGADO, NO OLVIDES CONSULTAR EL ESTADO DEL COMPROBANTE ANULADO EN LA SUNAT LUEGO DE UNOS MINUTOS";
        // }else{
        //     $message="NO SE PUEDO AGREGAR, pOR FAVOR VUELVA A AGREGAR EL COMPROBANTE A ANULAR";
        // }
        $success=TRUE;
        $datos_json = response()->json(['success' =>  $success]);
        return $datos_json;

    }

    public function show($id)
    {
        //
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
        //dd($result);
        if($result["message"]["code"]=="0"){
            DB::table('mov_ra')->where('c_num_tic',$id)->update([
                "n_est" => "2"
            ]);

            DB::table('mov_comprobante')->where('fk_ra_id',$id3)->update([
                "n_est" => "0"
            ]);
            $mensaje="Enviado a la SUNAT. CÓDIGO: ".$result["message"]["code"]." | DESCRIPCIÓN: La Comunicacion de baja ".$id2.", ha sido aceptada.";
        }else{
            $mensaje="Enviado a la SUNAT. CÓDIGO: ".$result["message"]["code"]." | DESCRIPCIÓN: La Comunicacion de baja ".$id2.", ya ha sido generada.";
        }



        $success=TRUE;
        $datos_json = response()->json(['success' =>  $success, 'result' =>  $mensaje, 'codigo' => $result["message"]["code"]]);
        return $datos_json;
    }
}
