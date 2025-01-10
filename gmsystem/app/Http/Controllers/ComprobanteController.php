<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Comprobante;
use App\DocumentoComprobante;
use App\TipoOperacion;
use App\Moneda;
use App\Producto;
use App\Cliente;
use App\TipoNotaCredito;
use App\TipoNotaDebito;
use App\Empresa;
use App\ComprobanteDetalle;
use App\FacturaRa;
use App\ResumenRc;
use App\DocumentoIdentidad;
use App\CondicionPago;
use App\SucursalSerie;
use App\ProductoServicio;
use App\Correo;
use DB;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use GuzzleHttp\Client;
use Mail;
use Zipper;
use Barryvdh\DomPDF\Facade as PDF;

class ComprobanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('redireccionaSiNoExisteSucursal');
        $this->nameModule = "comprobante";
        $this->titleModule = "Comprobante";
        $this->linkBaseModule = "comprobante/";
    }

    private function messages()
    {
        $messages = [
            'numDoc.unique' => '- El número referencial ya existe en la base de datos.',
            'numDoc.required' => '- El número referencial es requerido.',
            'numDoc.integer' => '- El número(referencial) no es un número.',
            'cliente.required' => '- Es necesario seleccionar cliente.',
            'cliente.integer' => '- El cliente solo admite números enteros.',
            'fecFactura.required' => '- Es necesario ingresar fecha de emisión.',
            'idMoneda.required' => '- Es necesario seleccionar tipo de moneda.',
            'idMoneda.integer' => '- El tipo de moneda solo admite números enteros.',
            'almacen.required' => '- Es necesario seleccionar origen.',
            'almacen.integer' => '- El origen solo admite números enteros.',
            'obs.max' => '- La observación solo admite hasta 250 caracteres.',
            'fecFactura.date_format' => '- La fecha solo admite (DD/MM/YYYY).',
        ];

        return $messages; 
    }

    private function rules($request)
    {
        $rules = [
            // 'numDoc' => 'required|integer|unique:mov_comprobante,c_doc',
            // 'numDoc' => 'required|integer|unique:mov_comprobante,c_doc,c_num_ser,'. $request->route('pk_cpb_id') . ',pk_cpb_id',
            'numDoc' => 'required|integer',
            'cliente' => 'required|integer',
            'fecFactura' => 'required',
        ];
        return $rules;
    }

    public function index()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $documentoComprobante = DocumentoComprobante::get();

        $cliente = Cliente::orderBy('c_raz', 'desc')->get();
        return view('comprobante.index', compact('titleModule','linkBaseModule','nameModule','documentoComprobante','cliente'));
    }

    public function apiComprobante(Request $request)
    {
        //$clients = Client::all();
        $fec = $request->input('fec');
        $fecFin = $request->input('fecFin');
        $cli = $request->input('cli');
        $doc = $request->input('doc');

        $comprobante = Comprobante::Busqueda($fec,$fecFin,$cli,$doc);

        return Datatables::of($comprobante)
            ->addColumn('correlativo', function($comprobante){
              $correlativo = str_pad($comprobante->c_doc,7,"0",STR_PAD_LEFT);
              return $correlativo;
            })
            ->addColumn('moneda', function($comprobante){
              if($comprobante->fk_mon_id=="1"){
                return "S/";
              }else{
                return "US$";
              }
            })

            ->addColumn('correo', function($comprobante){
                $estadoCorreo="";
                if($comprobante->n_est_cor!="0"){  
                  $estadoCorreo='<i class="fa fa-check" style="color: #42a142;"></i>';
                }else{
                  $estadoCorreo='<i class="fa fa-times" style="color: #df3823;"></i>';
                }

                return $estadoCorreo;
            })

            ->addColumn('pdf', function($comprobante){
                return '<a target="_blank" href="public/pdf/Cotizacion N° '.$comprobante->pk_cpb_id.'.pdf" download="Cotización_'.$comprobante->c_raz.'" class="btn btn-primary btn-rounded btn-xs">IMPRIMIR</a>';

            })

            ->addColumn('estado', function($comprobante){
                if($comprobante->n_est=="2"){
                    $estado='<a href="#" onclick="return false;" class="label label-success label-tag">Enviada - Aceptada</a>'; 
                }else{
                  $estado='<a href="#" onclick="return false;" class="label label-tag">No firmada - Anulada</a>'; 
                }
                return $estado;
            })

            ->addColumn('action', function($comprobante){
                $correo = Comprobante::CorreoCliente($comprobante->fk_cli_id);
                $correoCliente='';
                $correoPersonalizado='';
                if($comprobante->c_cor!=""){
                  $correoCliente='<li><a href="#" onclick="correo('.$comprobante->pk_cpb_id.',\'1\');">Enviar al cliente ["'.$comprobante->c_cor.'"]</a></li>';
                  $correoPersonalizado='<li><a href="#" onclick="correo('.$comprobante->pk_cpb_id.',\'2\');">Enviar a un email personalizado</a></li>';
                }else{
                  $correoCliente='';
                  $correoPersonalizado='<li><a href="#" onclick="correo('.$comprobante->pk_cpb_id.',\'2\');">Enviar a un email personalizado</a></li>';
                }


                $estadoAnulado='';
                $reenviarComprobante='';
                $verComprobante = '<li><a href="#" onclick="detalleComprobante('.$comprobante->pk_cpb_id.');">Ver Cotización ["'.str_pad($comprobante->c_doc,7,"0",STR_PAD_LEFT).'"]</a></li>';
                $actualizarComprobante = '<li><a href="#" onclick="actualizarComprobante(\''.$comprobante->pk_cpb_id.'\',\'1\');">Editar Cotización ["'.str_pad($comprobante->c_doc,7,"0",STR_PAD_LEFT).'"]</a></li>';

                $nuevoComprobante = '<li><a href="#" onclick="actualizarComprobante(\''.$comprobante->pk_cpb_id.'\',\'2\');">Nueva Cotización ["'.str_pad($comprobante->c_doc,7,"0",STR_PAD_LEFT).'"]</a></li>';

                $eliminarComprobante = '<li><a href="#" onclick="deleteComprobante(\''.$comprobante->pk_cpb_id.'\', \''.$comprobante->c_num_ser.' - '.str_pad($comprobante->c_doc,7,"0",STR_PAD_LEFT).'\');" style="color: #df3c28;">Eliminar Borrador ["'.$comprobante->c_num_ser.' - '.str_pad($comprobante->c_doc,7,"0",STR_PAD_LEFT).'"]</a></li>';

                $menu='<ul class="dropdown-menu dropdown-menu-right">'.$nuevoComprobante.$actualizarComprobante.$verComprobante.$correoCliente.$correoPersonalizado.$estadoAnulado.'</ul>';

                return '<div class="btn-group btn-group-xs">
                  <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="fa fa-cog"></span>&nbsp;<span class="fa fa-caret-down"></span>
                  </button>
                  '.$menu.'
                </div>';
            })
            // <li><a href="#">Verificar en la SUNAT la validéz del CPE</a></li>
            // <li><a href="#">Verificar XML en la  SUNAT</a></li>
            ->rawColumns(['correlativo', 'correo', 'moneda', 'pdf', 'estado','action'])
            ->make(true);
    }

    public function create($id="", $id2="")
    {
      $nameModule = $this->nameModule;
      $titleModule = $this->titleModule;
      $linkBaseModule = $this->linkBaseModule;
      $correlativo="";
      $igv=auth()->user()->n_est_igv;
      $usuario=auth()->user()->id;
      $sucursal=session('pk_suc_id');
      $cboAlmacen = Comprobante::CboAlmacen();
      $cboMoneda = Moneda::where('n_est','=','1')->get();
      $ComprobanteCabecera = "";
      $comprobanteDetalle = "";
      $totalDetalle = "1";
      if($id!="-1"){
        $ComprobanteCabecera = Comprobante::ComprobanteCabecera($id);
        $comprobanteDetalle = ComprobanteDetalle::ComprobanteDetalle($id);
        $totalDetalle = ComprobanteDetalle::ComprobanteDetalle($id)->count();
      }else{
        $datos = Comprobante::Correlativo();
        $correlativo=$datos[0]->c_doc+1;
      }
      return view('comprobante._create',compact('nameModule','titleModule','linkBaseModule','cboAlmacen','cboMoneda','ComprobanteCabecera','comprobanteDetalle','totalDetalle','id','id2','igv','correlativo'));
    }

    public function createCorreo($id="", $id2="")
    {
        $comprobante = Comprobante::ComprobanteCabecera($id)->first();
        $datosCorreos = Correo::where('fk_cpb_id','=',$id)->get();
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $id=$id;
 
        return view('comprobante._createCorreo',compact('nameModule','titleModule','linkBaseModule','id','id2','comprobante','datosCorreos'));
    }

    public function createCliente($id="", $id2=""){
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;

        if($id2=="1"){
          $create="comprobante._createCliente";
          $documents = DocumentoIdentidad::whereIn('pk_tip_doc_id', [1,2])->get();
        }else{
          $documents = DocumentoIdentidad::whereIn('pk_tip_doc_id', [1,3,11])->get();
          $create="comprobante._createCliente2";
        }
 
        return view($create,compact('nameModule','titleModule','linkBaseModule', 'documents'));
    }

    public function imprimirComprobante($id="")
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
 
        return view('comprobante.imprimirComprobante',compact('nameModule','titleModule','linkBaseModule','id'));
    }

    public function detalleComprobante($id="")
    {

      $nameModule = $this->nameModule;
      $titleModule = $this->titleModule;
      $linkBaseModule = $this->linkBaseModule;
      $igv=auth()->user()->n_est_igv;
      $datos = Comprobante::ComprobanteCabecera($id);
      $comprobanteDetalle = Comprobante::ComprobanteDetalleCabecera($id);
      return view('comprobante.detalleComprobante',compact('nameModule','titleModule','linkBaseModule','datos','igv','comprobanteDetalle'));
    }

    public function store(Request $request, Filesystem $filesystem)
    {
      $hora = new \DateTime();
      $nDocumento=$request->input('numDoc');
      $idCotizacion=$request->input('id');
      $idNueva=$request->input('idNueva');
      $correlativo="";
      if($idCotizacion!=""){
        if($idNueva=="2"){
          $datos = Comprobante::Correlativo();
          //dd($datos[0]->c_doc);
          if(count($datos)!=0) { 
              $suma=$datos[0]->c_doc+1;
              $correlativo = $suma;
          }else{
              $correlativo = 1;
          } 
          $nDocumento=$correlativo;
        }else{
          Comprobante::findOrFail($idCotizacion)->delete();
          DB::table('mov_detalle_comprobante')->where('fk_cpb_id', $idCotizacion)->delete();
        }

      }
      $usuario=auth()->user()->id;
      $sucursal=session('pk_suc_id');
      $estBorrador=$request->input('estBorrador');
      $almacen=$request->input('almacen');
      $cliente=$request->input('cliente');
      $obs=$request->input('obs');
      $asu=$request->input('asu');
      $moneda=$request->input('idMoneda');
      $subtotal=$request->input('subTotal2');
      $igv=$request->input('igv3');
      $total=$request->input('total2');
      $totalDesc=$request->input('totalDes2');
      $fecha=$request->input('fecFactura');
      $descuento=$request->input('descuento');
      $fecVencimiento=$request->input('fecFacturaVencimiento');
      $fechaIniObra=$request->input('fecInicioObra');
      $fechaFinObra=$request->input('fecFinObra');
      $dia = substr($fecha, 0, 2);
      $mes   = substr($fecha, 3, 2);
      $anio = substr($fecha, 6, 4);
      $fechaComprobante= $anio."-".$mes."-".$dia;
      $fechaInicioObra= null;
      $fechaFinalObra= null;
      if(isset($fechaIniObra))
      {
        $diaI = substr($fechaIniObra, 0, 2);
        $mesI   = substr($fechaIniObra, 3, 2);
        $anioI = substr($fechaIniObra, 6, 4);
        $fechaInicioObra= $anioI."-".$mesI."-".$diaI;
      }

      if(isset($fechaFinObra))
      {
        $diaIF = substr($fechaFinObra, 0, 2);
        $mesIF   = substr($fechaFinObra, 3, 2);
        $anioIF = substr($fechaFinObra, 6, 4);
        $fechaFinalObra= $anioIF."-".$mesIF."-".$diaIF;
      }



      $diaV = substr($fecVencimiento, 0, 2);
      $mesV   = substr($fecVencimiento, 3, 2);
      $anioV = substr($fecVencimiento, 6, 4);
      $fechaComprobanteVencimiento= $anioV."-".$mesV."-".$diaV;
      $filas=$request->input('fila');
      $items = [];
      # Validar si un payaso pone cualquier numero
      $serie="";

      $validator = \Validator::make($request->all(), $this->rules($request), $this->messages());
      $validator->sometimes('obs', 'required|max:250', function($input)
      {
          return $input->obs != "";
      });
      $validator->sometimes('fecFactura', 'required|date_format:d/m/Y', function($input)
      {
          return $input->fecFactura != "";
      });

      if ($validator->fails()) {
         //return response()->json($validator->errors(), 422);
          $success="false";
          $datos_json = response()
          ->json(['success' =>  $success,'validarDetalle' => '2','validar' => $validator->getMessageBag()->toArray()]);
          return $datos_json;
      }else{
          for($i=1; $i<=$filas; $i++)
          {
            $productoId=$request->input('productoId'.$i);
            $nombre=$request->input('nombreProducto'.$i);
            $cantidad=$request->input('cantidad'.$i);
            $precuni=$request->input('precuni'.$i);
            $subtotalDetalle=$request->input('subtotal'.$i);
            if($nombre!=null){
              # validamos el detalle
              $messagesDetalle = [
                  'productoId'.$i.'.required' => '- El nombre del producto/servicio es requerida.',
                  'cantidad'.$i.'.required' => '- La cantidad es requerida.',
                  'cantidad'.$i.'.numeric' => '- La cantidad solo admite números.',

                  'precuni'.$i.'.required' => '- El precio unitario es requerido.',
                  'precuni'.$i.'.numeric' => '- El precio unitario solo admite números.',

                  'subtotal'.$i.'.required' => '- el subtotal es requerido.',
                  'subtotal'.$i.'.numeric' => '- El subtotal solo admite números.',
              ];

              $rulesDetalle = [
                  //'cantidad'.$i.'' => 'required|numeric|between:0,99.99',
                  'productoId'.$i.'' => 'required',
                  'cantidad'.$i.'' => 'required|numeric',
                  'precuni'.$i.'' => 'required|numeric',
                  'precuni'.$i.'' => 'required|numeric',
              ];


              $validatorDetalle = \Validator::make($request->all(), $rulesDetalle, $messagesDetalle);
              if ($validatorDetalle->fails() || $precuni=="0" || $subtotalDetalle=="0") {
                $success="false";
                $datos_json = response()
                ->json(['success' =>  $success,'validarDetalle' => '1','validar' => $validatorDetalle->getMessageBag()->toArray()]);
                return $datos_json;
              }
            }
          }


          $data = array(
              "fk_suc_id" => $sucursal,
              "fk_usu_id" => $usuario,
              "fk_alm_id" => $almacen,
              "fk_cli_id" => $cliente,
              "fk_mon_id" => $moneda,
              "c_doc" => $nDocumento,
              "n_igv" => $igv,
              "n_sub_tot" => $subtotal,
              "n_tot" => $total,
              "n_des" => $descuento,
              "n_tot_des" => $totalDesc,
              "f_hor_fac" => $fechaComprobante,
              "f_hor_fac_ven" => $fechaComprobanteVencimiento,
              "f_ini_obra" => $fechaInicioObra,
              "f_fin_obra" => $fechaFinalObra,
              "c_asu" => $asu,
              "c_obs" => $obs,
              "n_est" => "2",
              "c_usu_cre" => $usuario,
              "f_cre" => Carbon::now(),
          );
          $id = DB::table('mov_comprobante')->insertGetId($data,'pk_cpb_id');

          $dataDetalle = [];
          for($i=1; $i<=$filas; $i++)
          {
              $cantidad=$request->input('cantidad'.$i);
              $productoId=$request->input('productoId'.$i);
              $nombre=$request->input('nombreProducto'.$i);
              $precuni=$request->input('precuni'.$i);
              $subtotalDetalle=$request->input('subtotal'.$i);
              $codigo=$request->input('codigo'.$i);
              $uMedida=$request->input('idUm'.$i);
              $subtotalSinIgv=$request->input('subtotalSinIgv'.$i);
              $detalleIgv=$request->input('igvDetalle'.$i);
              $um=$request->input('um'.$i);
              $precioVentaUnitarioPorItemCodigo="";
              $valorVentaItem="";
              #"Cantidad" validamos que no se inserte una linea del detalle eliminada
              if($nombre!=null){
                  $productoXId=ProductoServicio::findOrFail($productoId);
                  //Insertamos el detalle del comprobante a la base de datos
                  $data2 = array(
                      "fk_cpb_id" => $id,
                      "fk_uni_med_id" => $uMedida,
                      "fk_prd_id" => $productoId,
                      "n_can" => $cantidad,
                      "n_pre" => $precuni,
                      "n_sub_tot_sin_igv" => $subtotalSinIgv,
                      "n_igv" => $detalleIgv,
                      "n_sub_tot" => $subtotalDetalle,
                      "c_nom" => $productoXId->c_nom,
                      "c_obs" => $productoXId->c_obs,
                      "c_usu_cre" => $usuario,
                      "f_cre" => Carbon::now(),
                  );
                  DB::table('mov_detalle_comprobante')->insertGetId($data2,'pk_det_cpb_id');

              }
          }
         
          $success = "true";
          $result = [
            'message' => 'OPERACIÓN CONCLUIDA CORRECTAMENTE: La cotización N° '.$nDocumento.' fue REGISTRADO correctamente',
          ];
          $this->pdf($id);
          $datos_json = response()->json(['success' =>  $success, 'result' =>  $result, 'id' =>  $id]);
          return $datos_json;
        }
    }


    public function edit($id, $id2)
    {
      $nameModule = $this->nameModule;
      $titleModule = $this->titleModule;
      $linkBaseModule = $this->linkBaseModule;
      $correlativo="";
      $igv=auth()->user()->n_est_igv;
      $usuario=auth()->user()->id;
      $sucursal=session('pk_suc_id');
      $cboAlmacen = Comprobante::CboAlmacen();
      $cboMoneda = Moneda::where('n_est','=','1')->get();
      $ComprobanteCabecera = "";
      $comprobanteDetalle = "";
      $totalDetalle = "1";
      if($id!="-1"){
        $ComprobanteCabecera = Comprobante::ComprobanteCabecera($id)->first();
        $comprobanteDetalle = Comprobante::ComprobanteDetalleCabecera($id);
        $totalDetalle = ComprobanteDetalle::ComprobanteDetalle($id)->count();
      }else{
        $datos = Comprobante::Correlativo();
        $correlativo=$datos[0]->c_doc+1;
      }
      return view('comprobante._edit',compact('nameModule','titleModule','linkBaseModule','cboAlmacen','cboMoneda','ComprobanteCabecera','comprobanteDetalle','totalDetalle','id','igv','correlativo','id2'));

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $usuario=auth()->user()->id;

        Comprobante::findOrFail($id)->delete();
        $success=TRUE;

        $datos_json = response()->json(['success' =>  $success]);
        return $datos_json;
    }

    public function cboCliente($id="")
    {
        $cboCliente = Comprobante::cboCliente($id);
        return view('comprobante.cboCliente',compact('cboCliente','id'));
    }

    public function cboSerie($id="", $id2="", $id3="")
    {
        $datos = Comprobante::Correlativo($id, $id2, $id3);
        $suma=0;
        if($datos[0]->c_doc==null){
          if($id=="1"){
            $suma=1;
          }else{
            $suma=1;
          }
        }else{
          $suma=$datos[0]->c_doc+1;
        }

        $correlativo = $suma;
        $success=TRUE;
        $datos_json = response()->json(['correlativo' =>  $correlativo]);
        return $datos_json; 

        //return view('comprobante.serie',compact('serie'));
    }

    public function cboProducto($id="")
    {
      $almacen = "1";
      $sucursal=session('pk_suc_id');
      $cboProducto = Comprobante::CboProducto($sucursal, $almacen);
      return view('comprobante.cboProducto',compact('id', 'cboProducto'));
    }

    public function datosCliente($id=""){
        $datos = Comprobante::DatosCliente($id);
        $numero = "";
        if($datos[0]->c_raz=="VARIOS"){
          $numero = "-";
        }else{
          $numero = $datos[0]->c_num_doc;
        }

        $success=TRUE;
        $datos_json = response()->json(['razon' =>  $datos[0]->c_raz,'direccion' =>  $datos[0]->c_dir, 'doc' => $numero, 'tipo' => $datos[0]->fk_tip_doc_id]);
        return $datos_json;
    }

    public function datosProducto($id="", $id2=""){

        $datos = Producto::DatosProducto($id, $id2);
        if(count($datos)=="0"){
          $precio = "0";
          $datos = Producto::DatosProducto($id, "-1");
        }else{
          $precio = $datos[0]->n_pre_ven;

        }

        $success=TRUE;
        $datos_json = response()->json([
                      'id' =>  $datos[0]->pk_prd_id, 
                      'nombre' =>  $datos[0]->c_nom, 
                      'precio' =>  $precio, 
                      'disponible' =>  "", 
                      'codigo' =>  $datos[0]->c_cod,
                      'descripion' =>  $datos[0]->c_obs,
                      'um' =>  $datos[0]->c_abr,
                      'idUm' =>  $datos[0]->pk_uni_med_id,
                      'imagen' =>  $datos[0]->c_img
                    ]);
        return $datos_json;
    }

    public function datosProductoComprobante($id="", $id2=""){
      dd("probandio");
      $datos = ComprobanteDetalle::DatosProductoComprobante($id,$id2);
      if(count($datos)=="0"){
        $precio = "0";
      }else{
        $precio = $datos[0]->n_pre;
      }
      $success=TRUE;
      $datos_json = response()->json([
        'precio' =>  $precio
      ]);
      return $datos_json;
    }


    public function searchProducto()
    {
        //$products = Producto::pluck('c_nom');
        $products = Comprobante::CboProducto()->pluck('producto');
        return $products;
    }

    public function procesarConCorreo(Request $request){
      $empresa = Empresa::Empresa();
      $id=$request->input('id');
      $comprobante = Comprobante::ComprobanteCabecera($id);
      $correo = $comprobante[0]->c_cor;
      $numero = $comprobante[0]->c_doc;
      $fecha_emision=$comprobante[0]->f_hor_fac ;
      $total=$comprobante[0]->total;
      $cliente=$comprobante[0]->c_raz ;
      $correo_cliente=$correo;
      $correo_emisor= $empresa[0]->c_cor;
      $razon_social = $empresa[0]->c_raz_soc;
      $asunto = $comprobante[0]->c_asu;
      $data = array(
          'numero'=>''.$numero.'',
          'fecha_emision'=>''.$fecha_emision.'',
          'total'=>''.$total.'',
          'cliente'=>''.$cliente.'',
          'correo_cliente'=>''.$correo_cliente.'',
          'correo_emisor'=>''.$correo_emisor.'',
          'razon_social'=>''.$razon_social.'',
          'asunto'=>''.$asunto.'',
          'ruc'=>''.$empresa[0]->c_num.'',
      );

      Mail::send('emails.comprobante', ['msg' => $data], function($m) use ($comprobante, $data, $razon_social, $numero, $id){
 
          $m->from($data["correo_emisor"], $razon_social);
          $m->to($data["correo_cliente"])->subject("GMSYSTEM (CÁMARAS DE SEGURIDAD, CERCO ELÉCTRICO Y ALARMA CONTRA INCENDIO)");
          $m->attach(''.$id.'.pdf');
      });
      
      $result = "Correo enviado al cliente";
      $success=TRUE;

      DB::table('mov_comprobante')->where('pk_cpb_id',$id)->update([
        "n_est_cor" => "1",
      ]);
      $datos_json = response()->json([
        'success' =>  $success,
        'result' =>  $result]);

      return $datos_json;
    }

    public function procesarSinCorreo(Request $request){
      $empresa = Empresa::Empresa();
      $id=$request->input('id');

      $comprobante = Comprobante::ComprobanteCabecera($id);
      $asunto = $request->input('asunto');
      $dirigido = $request->input('dirigido');
      $numero = $comprobante[0]->c_doc;
      $fecha_emision=$comprobante[0]->f_hor_fac ;
      $total=$comprobante[0]->total;
      $cliente=$comprobante[0]->c_raz ;
      $correo_cliente=$request->input('email');
      $correo_emisor= $empresa[0]->c_cor;
      $razon_social = $empresa[0]->c_raz_soc;
      $firma = $empresa[0]->c_fir;
      $empleado = $comprobante[0]->nomEmpleado." ".$comprobante[0]->c_pri_ape." ".$comprobante[0]->c_seg_ape;
      $celular = $comprobante[0]->c_tel;
      $data = array(
          'numero'=>''.$numero.'',
          'fecha_emision'=>''.$fecha_emision.'',
          'total'=>''.$total.'',
          'cliente'=>''.$cliente.'',
          'correo_cliente'=>''.$correo_cliente.'',
          'correo_emisor'=>''.$correo_emisor.'',
          'razon_social'=>''.$razon_social.'',
          'asunto'=>''.$asunto.'',
          'ruc'=>''.$empresa[0]->c_num.'',
          'dirigido'=>''.$dirigido.'',
          'firma'=>''.$firma.'',
          'empleado'=>''.$empleado.'',
          'celular'=>''.$celular.'',
      );

      Mail::send('emails.comprobante', ['msg' => $data], function($m) use ($comprobante, $data, $razon_social, $numero, $id){
 
          $m->from($data["correo_emisor"], $razon_social);
          $m->to($data["correo_cliente"])->subject("GMSYSTEM (CÁMARAS DE SEGURIDAD, CERCO ELÉCTRICO Y ALARMA CONTRA INCENDIO)");
          $m->attach('public/pdf/Cotizacion N° '.$id.'.pdf');
      });
      
      $result = "Correo enviado al cliente";
      $success=TRUE;

      DB::table('mov_comprobante')->where('pk_cpb_id',$id)->update([
        "n_est_cor" => "1",
      ]);

      $datos = Correo::where('fk_cpb_id','=',$id)->where('c_cor','=',$correo_cliente)->get();
      if(count($datos)==0) { 
        $datosCorreo = new Correo();
        $datosCorreo->fk_cpb_id = $id;
        $datosCorreo->c_cor = $correo_cliente;
        $datosCorreo -> save();
      }
      $datos_json = response()->json([
        'success' =>  $success,
        'result' =>  $result]);

      return $datos_json;
    }

    public function createAnulado($id=""){
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $ComprobanteCabecera = Comprobante::ComprobanteCabecera($id);
        $datos = FacturaRa::Correlativo();
        if(count($datos)!=0) { 
            $suma=$datos[0]->c_num+1;
            $correlativo = $suma;
        }else{
            $correlativo = "1";
        } 
 
        return view('comprobante._createAnulado',compact('nameModule','titleModule','linkBaseModule','id','correlativo', 'ComprobanteCabecera','id'));
    }

    public function createAnuladoBoleta($id=""){
      $nameModule = $this->nameModule;
      $titleModule = $this->titleModule;
      $linkBaseModule = $this->linkBaseModule;
      $ComprobanteCabecera = Comprobante::ComprobanteCabecera($id);

      $datos = ResumenRc::Correlativo();
      if(count($datos)!=0) { 
          $suma=$datos[0]->c_num+1;
          $correlativo = $suma;
      }else{
          $correlativo = "1";
      }  

      return view('comprobante._createAnuladoBoleta',compact('nameModule','titleModule','linkBaseModule','id','correlativo', 'ComprobanteCabecera','id'));
    }

    public function anular(Request $request){
      $id=$request->input('id');
      $datos = Comprobante::ComprobanteCabecera($id)->first();

      $result = [
        'message' => 'OPERACIÓN CONCLUIDA CORRECTAMENTE: El comprobante '.$datos->c_num_ser.' - '.str_pad($datos->c_doc,7,"0",STR_PAD_LEFT).' fue ANULADA correctamente',
      ];

      DB::table('mov_comprobante')->where('pk_cpb_id',$id)->update([
          "n_est" => "7",
          "n_est_anu_sf" => "1"
      ]);

      $success=TRUE;
      $datos_json = response()->json(['success' =>  $success, 'result' =>  $result, 'id' =>  $id]);
      return $datos_json;
    }

    public function pdf($id){
      $datos = Comprobante::ComprobanteCabecera($id)->first();
      $comprobanteDetalle = Comprobante::ComprobanteDetalleCabecera($id);   
      $empresa = Empresa::Empresa()->first();     
        // $pdf = PDF::loadView('comprobante.pdf');
        // $filename = 'Reporte_'.date('YmdHis');im
        // return $pdf->download($filename.'.pdf');

      $pdf = PDF::loadView( 'comprobante.pdf', compact('datos','comprobanteDetalle','empresa'))->save( 'public/pdf/Cotizacion N° '.$id.'.pdf' ); 
      //dd()
      // $view =  \View::make('comprobante.pdf',compact('datos','comprobanteDetalle'))->save('pdfname.pdf' );

      // $pdf = \App::make('dompdf.wrapper');
      // $pdf->loadHTML($view);
      // return $pdf->stream();
    }

    // public function pdf(){
    //   $datos = Comprobante::ComprobanteCabecera(71)->first();
    //   $comprobanteDetalle = Comprobante::ComprobanteDetalleCabecera(71);  
    //   $empresa = Empresa::Empresa()->first();     
    //     // $pdf = PDF::loadView('comprobante.pdf');
    //     // $filename = 'Reporte_'.date('YmdHis');
    //     // return $pdf->download($filename.'.pdf');


    //   $view =  \View::make('comprobante.pdf',compact('datos','comprobanteDetalle','empresa'))->render();
    //   $pdf = \App::make('dompdf.wrapper');
    //   $pdf->loadHTML($view);
    //   return $pdf->stream();
    // }

    
}
