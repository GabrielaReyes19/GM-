<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;
use App\Cliente;
use App\User;
use App\Branch;
use App\DocumentoIdentidad;
use DB;
use URL;
use cURL;
use Carbon\Carbon;
use Auth;
use App\Departamento;
use App\Provincia;
use App\Distrito;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('redireccionaSiNoExisteSucursal');
        $this->nameModule = "cliente";
        $this->titleModule = "Cliente";
        $this->linkBaseModule = "cliente/";
        $this->cc = new cURL();
    }

    private function messages()
    {
        $messages = [
            'cliDocSunat.unique' => '- El número de documento ya existe en la base de datos.',
            'cliTip.required' => '- Es necesario seleccionar tipo de documento.',
            //'cliDocSunat.required' => '- Es necesario ingresar un número de documento.',
            'razNom.required' => '- Es necesario ingresar una razón social.',
            'cliApePat.required' => '- Es necesario ingresar un apellido paterno.',
            'cliApeMat.required' => '- Es necesario ingresar un apellido materno.',
            'name.required' => '- Es necesario ingresar un nombre.',
            //'cliDir.required' => '- Es necesario ingresar una dirección.',
            'cliDir.max' => '- La dirección corta solo admite hasta 250 caracteres.',
            //'cliTel.integer' => '- El teléfono solo admite números enteros.',
            'cliCor.email' => '- Es necesario ingresar un correo válido.'
            //'representative.required' => 'Es necesario ingresar un representatante.',
        ];

        return $messages; 
    }

    private function rules($request)
    {
        $rules = [
            'cliTip' => 'required',
            'cliDocSunat' => 'required|unique:mae_cliente,c_num_doc,'. $request->route('pk_cli_id') . ',pk_cli_id',
            'razNom' => 'required',
            'cliApePat' => 'required',
            'cliApeMat' => 'required',
            'name' => 'required',
            //'cliDir' => 'required|max:250',
            //'cliTel' => 'integer'
            //'mail' => 'email'
        ];
        return $rules;
    }

    private function rules2($request)
    {
        $rules = [
            'cliTip' => 'required',
            'cliDocSunat' => 'required|unique:mae_cliente,c_num_doc,'. $request->route('pk_cli_id') . ',pk_cli_id',
            'razNom' => 'required',
            'cliDir' => 'required|max:250',
            //'cliTel' => 'integer'
            //'mail' => 'email'
        ];
        return $rules;
    }

    private function rules3($request)
    {
        $rules = [
            'cliTip' => 'required',
            'cliDocSunat' => 'required',
            'razNom' => 'required',
            'cliApePat' => 'required',
            'cliApeMat' => 'required',
            'name' => 'required',
            'cliDir' => 'required|max:250',
            //'cliTel' => 'integer'
            //'mail' => 'email'
        ];
        return $rules;
    }

    private function rules4($request)
    {
        $rules = [
            'cliTip' => 'required',
            'cliDocSunat' => 'required',
            'razNom' => 'required',
            'cliDir' => 'required|max:250',
            //'cliTel' => 'integer'
            //'mail' => 'email'
        ];
        return $rules;
    }

    public function index()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        // if (Auth::check())
        // {
        //     $id=Auth::user()->id;
        //     $user = User::find($id);
        //     $user->employee;
        //     $branch = User::find($id);
        //     $branch->branch;
        //     return view('dashboard', compact('titleModule','linkBaseModule','user','branch','nameModule'));
        // }else{
        //     return redirect('/login');
        // }

        return view('clients.index', compact('titleModule','linkBaseModule','nameModule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function apiClient(Request $request)
    {
        $cliente = Cliente::Busqueda();
        return Datatables::of($cliente)
            ->addColumn('estado', function($cliente){
                $estado="";
                if($cliente->n_est=="1"){
                    $estado='<a href="#" onclick="return false;" class="label label-success label-tag">Activo</a>'; 
                }else{
                    $estado='<a href="#" onclick="return false;" class="label label-danger label-tag">Inactivo</a>'; 
                }
                return $estado;
            })

            ->addColumn('action', function($cliente){
                return '<div class="btn-group btn-group-xs">
                  <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="fa fa-cog"></span>&nbsp;<span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#" onclick="renderUpdate(\''.$cliente->pk_cli_id.'\',\''.$cliente->c_num_doc.'\');" id="btn_upd_'.$cliente->pk_cli_id.'">Editar </a></li>
                    <li><a href="#" onclick="deleteCliente(\''.$cliente->pk_cli_id.'\',\''.$cliente->c_num_doc.'\');" id="btn_del_'.$cliente->pk_cli_id.'" >Borrar </a></li>
                  </ul>
                </div>';
            })
            ->rawColumns(['estado', 'action'])
            ->make(true);
    }

    public function create()
    {
        $documento = DocumentoIdentidad::get();
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        return view('clients.create',compact('nameModule','titleModule','linkBaseModule','documento'));
    }

    public function createSunat($doc="")
    {
        $ruc_dni=$doc;
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        return view('clients.detalleSunat',compact('nameModule','titleModule','linkBaseModule','documents','ruc_dni'));
    }

    public function departamento($id="")
    {
        $datos = Departamento::select('pk_dep_id','c_nom')->get();   

        return view('clients.cboDepartamento',compact('datos', 'id'));
    }

    public function provincia($id="", $id2="")
    {

        if($id2=="-1"){
            // $datos = Provincia::select('pk_pvi_id','c_nom')->where('fk_dep_id',$id)->get();
            $datos = DB::select(
                "SELECT 
                    pk_pvi_id,c_nom
                from 
                    mae_provincia
                where 
                    fk_dep_id=".$id."

            ");
        }else{
            // $datos = Provincia::select('pk_pvi_id','c_nom')->where('fk_dep_id',$id2)->get();
            $datos = DB::select(
                "SELECT 
                    pk_pvi_id,c_nom
                from 
                    mae_provincia
                where 
                    fk_dep_id=".$id2."

            ");
        }
        return view('clients.cboProvincia',compact('datos','id','id2'));
    }

    public function distrito($id="", $id2="")
    {
        if($id2=="-1"){         
            $datos = DB::select(
                "SELECT 
                    pk_dis_id,c_nom
                from 
                    mae_distrito
                where 
                    fk_pvi_id=".$id."
            ");
        }else{
            $datos = DB::select(
                "SELECT 
                    pk_dis_id,c_nom
                from 
                    mae_distrito
                where 
                    fk_pvi_id=".$id2."

            ");
        }
        return view('clients.cboDistrito',compact('datos','id','id2'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $c_num_doc=$request->input('cliDocSunat');

        if($c_num_doc==""){
            $c_num_doc="-";            
        }
        $departamento=$request->input('departamento');
        $provincia=$request->input('provincia');
        $distrito=$request->input('distrito');
        $c_pri_ape=$request->input('cliApePat');
        $c_seg_ape=$request->input('cliApeMat');
        $c_nom=$request->input('name');
        $c_dir=$request->input('cliDir');
        $c_cor=$request->input('cliCor');
        $c_tel=$request->input('cliTel');
        $c_rep=$request->input('cliRep');
        $n_est=$request->input('est');
        $usuario=auth()->user()->id;
        $c_raz="";
        //$this->validate($request, Client::$rules, Client::$messages);
        $numeroDocumento=strlen($c_num_doc);
        if(($numeroDocumento=="11")){
            $validator = \Validator::make($request->all(), $this->rules2($request), $this->messages());
            $fk_tip_doc_id="2";
            $c_raz=$request->input('razNom');
        }else{
            $validator = \Validator::make($request->all(), $this->rules($request), $this->messages());
            $fk_tip_doc_id=$request->input('cliTip');
            if($c_pri_ape=="-" || $c_seg_ape=="-"){
                $c_raz=$c_nom;
            }else{
                $c_raz=$c_pri_ape." ".$c_seg_ape." ".$c_nom;
            }
            
        }

        $validator->sometimes('mail', 'required|email', function($input)
        {
            return $input->mail != "";
        });

        if($request->input('cliTip')=="11"){
            $check_friend_request = DB::table("mae_cliente")
            ->where("c_raz", "=", $c_raz) // "=" is optional
            ->count();
            if($check_friend_request!=0){
                $messages = [
                  'name' => '- El nombre ya existe en la base de datos.',
                ];
                //dd($messages);

                $success=FALSE;
                $datos_json = response()->json(['success' =>  $success,'validar' => $messages]);
                return $datos_json;
            }
        }


        if ($validator->fails()) {
           //return response()->json($validator->errors(), 422);
            $success=FALSE;
            $datos_json = response()
            ->json(['success' =>  $success,'validar' => $validator->getMessageBag()->toArray()]);

            return $datos_json;
        }else{
            $data = array(
                "fk_tip_doc_id" => $fk_tip_doc_id,
                "fk_dep_id" => $departamento,
                "fk_pvi_id" => $provincia,
                "fk_dis_id" => $distrito,
                "c_num_doc" => $c_num_doc,
                "c_raz" => $c_raz,
                "c_pri_ape" => $c_pri_ape,
                "c_seg_ape" => $c_seg_ape,
                "c_nom" => $c_nom,
                "c_dir" => $c_dir,
                "c_cor" => $c_cor,
                "c_tel" => $c_tel,
                "c_rep" => $c_rep,
                "n_est" => $n_est,
                "c_usu_cre" => $usuario,
                "f_cre" => Carbon::now(),
            );
            $id = DB::table('mae_cliente')->insertGetId($data,'pk_cli_id');
            //$client = Client::create($request->all());
            // $client->creation_user = auth()->user()->id;
            // $client->save();
            $success=TRUE;
            $datos_json = response()->json(['success' =>  $success, 'id' =>  $id]);
        }
        return $datos_json;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        $documento = DocumentoIdentidad::get();
        //$documents = Document::orderBy('name')->get();
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        return view('clients.edit',compact('nameModule','titleModule','linkBaseModule','documento','cliente', 'id'));
    }

    public function update(Request $request, $id)
    {

        $departamento=$request->input('departamento');
        $provincia=$request->input('provincia');
        $distrito=$request->input('distrito');
        $pk_cli_id=$request->input('id');
        $c_num_doc=$request->input('cliDocSunat');
        $c_pri_ape=$request->input('cliApePat');
        $c_seg_ape=$request->input('cliApeMat');
        $c_nom=$request->input('name');
        $c_dir=$request->input('cliDir');
        $c_cor=$request->input('cliCor');
        $c_tel=$request->input('cliTel');
        $c_rep=$request->input('cliRep');
        $n_est=$request->input('est');
        $usuario=auth()->user()->id;
        //$this->validate($request, Client::$rules, Client::$messages);
        $numeroDocumento=strlen($c_num_doc);
        if(($numeroDocumento=="11")){
            $validator = \Validator::make($request->all(), $this->rules4($request), $this->messages());
            $fk_tip_doc_id="2";
            $c_raz=$request->input('razNom');
        }else{
            $validator = \Validator::make($request->all(), $this->rules3($request), $this->messages());
            $fk_tip_doc_id=$request->input('cliTip');
            $c_raz=$c_pri_ape." ".$c_seg_ape." ".$c_nom;
        }

        $validator->sometimes('mail', 'required|email', function($input)
        {
            return $input->mail != "";
        });

        if ($validator->fails()) {
           //return response()->json($validator->errors(), 422);
            $success=FALSE;
            $datos_json = response()
            ->json(['success' =>  $success,'validar' => $validator->getMessageBag()->toArray()]);

            return $datos_json;
        }else{
            DB::table('mae_cliente')->where('pk_cli_id',$pk_cli_id)->update([
                "fk_tip_doc_id" => $fk_tip_doc_id,
                "fk_dep_id" => $departamento,
                "fk_pvi_id" => $provincia,
                "fk_dis_id" => $distrito,
                "c_num_doc" => $c_num_doc,
                "c_raz" => $c_raz,
                "c_pri_ape" => $c_pri_ape,
                "c_seg_ape" => $c_seg_ape,
                "c_nom" => $c_nom,
                "c_dir" => $c_dir,
                "c_cor" => $c_cor,
                "c_tel" => $c_tel,
                "c_rep" => $c_rep,
                "n_est" => $n_est,
                "c_usu_mod" => $usuario,
                "f_mod" => Carbon::now(),
            ]);
            $success=TRUE;
            $datos_json = response()->json(['success' =>  $success, 'id' =>  $id]);
        }
        return $datos_json;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario=auth()->user()->id;

        $datos = DB::table("mov_comprobante")
        ->where("fk_cli_id", "=", $id)
        ->count();
        if($datos!=0){
            $success=FALSE;
        }else{
            Cliente::findOrFail($id)->delete();
            $success=TRUE;
        }

        $datos_json = response()->json(['success' =>  $success]);
        return $datos_json;
    }

    /************************************+Consulta Sunat*******************************************/  
    function getNumRand()
    {
        $url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random";
        $numRand = $this->cc->send($url);
        return $numRand;
    }
    function getDataRUC( $ruc )
    {
        $numRand = $this->getNumRand();
        $rtn = array();
        if($ruc != "" && $numRand!=false)
        {
            $data = array(
                "nroRuc" => $ruc,
                "accion" => "consPorRuc",
                "numRnd" => $numRand
            );

            $url = "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
            $Page = $this->cc->send($url,$data);

            //RazonSocial
            $patron='/<input type="hidden" name="desRuc" value="(.*)">/';
            $output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
            if(isset($matches[0]))
            {
                $RS = utf8_encode(str_replace('"','', ($matches[0][1])));
                $rtn = array("RUC"=>$ruc,"RazonSocial"=>trim($RS));
            }

            //Telefono
            $patron='/<td class="bgn" colspan=1>Tel&eacute;fono\(s\):<\/td>[ ]*-->\r\n<!--\t[ ]*<td class="bg" colspan=1>(.*)<\/td>/';
            $output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
            if( isset($matches[0]) )
            {
                $rtn["Telefono"] = trim($matches[0][1]);
            }

            // Condicion Contribuyente
            $patron='/<td class="bgn"[ ]*colspan=1[ ]*>Condici&oacute;n del Contribuyente:[ ]*<\/td>\r\n[\t]*[ ]+<td class="bg" colspan=[1|3]+>[\r\n\t[ ]+]*(.*)[\r\n\t[ ]+]*<\/td>/';
            $output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
            if( isset($matches[0]) )
            {
                $rtn["Condicion"] = strip_tags(trim($matches[0][1]));
            }

            $busca=array(
                "NombreComercial"       => "Nombre Comercial",
                "Tipo"                  => "Tipo Contribuyente",
                "Inscripcion"           => "Fecha de Inscripci&oacute;n",
                "Estado"                => "Estado del Contribuyente",
                "Direccion"             => "Direcci&oacute;n del Domicilio Fiscal",
                "SistemaEmision"        => "Sistema de Emisi&oacute;n de Comprobante",
                "ActividadExterior"     => "Actividad de Comercio Exterior",
                "SistemaContabilidad"   => "Sistema de Contabilidad",
                "Oficio"                => "Profesi&oacute;n u Oficio",
                "ActividadEconomica"    => "Actividad\(es\) Econ&oacute;mica\(s\)",
                "EmisionElectronica"    => "Emisor electr&oacute;nico desde",
                "PLE"                   => "Afiliado al PLE desde"
            );
            foreach($busca as $i=>$v)
            {
                $patron='/<td class="bgn"[ ]*colspan=1[ ]*>'.$v.':[ ]*<\/td>\r\n[\t]*[ ]+<td class="bg" colspan=[1|3]+>(.*)<\/td>/';
                $output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
                if(isset($matches[0]))
                {
                    $rtn[$i] = trim(utf8_encode( preg_replace( "[\s+]"," ", ($matches[0][1]) ) ) );
                }
            }
        }
        if( count($rtn) > 2 )
        {
            return $rtn;
        }
        return false;
    }
    function dnitoruc($dni)
    {
        if ($dni!="" || strlen($dni) == 8)
        {
            $suma = 0;
            $hash = array(5, 4, 3, 2, 7, 6, 5, 4, 3, 2);
            $suma = 5; // 10[NRO_DNI]X (1*5)+(0*4)
            for( $i=2; $i<10; $i++ )
            {
                $suma += ( $dni[$i-2] * $hash[$i] ); //3,2,7,6,5,4,3,2
            }
            $entero = (int)($suma/11);

            $digito = 11 - ( $suma - $entero*11);

            if ($digito == 10)
            {
                $digito = 0;
            }
            else if ($digito == 11)
            {
                $digito = 1;
            }
            return "10".$dni.$digito;
        }
        return false;
    }
    function valid($valor) // Script SUNAT
    {
        $valor = trim($valor);
        if ( $valor )
        {
            /*if ( strlen($valor) == 8 ) // DNI
            {
                $suma = 0;
                for ($i=0; $i<strlen($valor)-1;$i++)
                {
                    $digito = $valor[$i];
                    if ( $i==0 )
                    {
                        $suma += ($digito*3);
                        echo $digito." x 3 = ".($digito*3)."\n";
                    }
                    else if ( $i==1 )
                    {
                        $suma += ($digito*2);
                        echo $digito." x 2 = ".($digito*2)."\n";
                    }
                    else
                    {
                        $suma += ($digito*(strlen($valor)-$i+1));
                        echo $digito." x ".(strlen($valor)-$i+1)." = ".($digito*(strlen($valor)-$i+1))."\n";
                    }
                }
                echo "suma=".$suma."\n";
                $resto = $suma % 11;
                echo "modulo=".$resto."\n";
                if ( $resto == 1)
                {
                    $resto = 11;
                }
                if ( $resto + ( $valor[strlen($valor)-1] ) == 11 )
                {
                    return true;
                }
            }
            else */
            if ( strlen($valor) == 11 ) // RUC
            {
                $suma = 0;
                $x = 6;
                for ( $i=0; $i<strlen($valor)-1; $i++ )
                {
                    if ( $i == 4 )
                    {
                        $x = 8;
                    }
                    $digito = $valor[$i];
                    $x--;
                    if ( $i==0 )
                    {
                        $suma += ($digito*$x);
                    }
                    else
                    {
                        $suma += ($digito*$x);
                    }
                }
                $resto = $suma % 11;
                $resto = 11 - $resto;
                if ( $resto >= 10)
                {
                    $resto = $resto - 10;
                }
                if ( $resto == $valor[strlen($valor)-1] )
                {
                    return true;
                }
            }
        }
        return false;
    }
    
    function buscarRucDni($doc="")
    {
        $data = [];
        $ruc_dni=$doc;
        if( strlen(trim($ruc_dni))==8 )
        {

            $ruc_dni = $this->dnitoruc($ruc_dni);
        }
        if( strlen($ruc_dni)==11 && $this->valid($ruc_dni) )
        {
            $info = $this->getDataRUC($ruc_dni);
            if($info["Direccion"]!="-"){
                $items = explode(' - ', $info["Direccion"]);
                if (count($items) !== 3) {
                    $info["Direccion"] = preg_replace("[\s+]", ' ', $info["Direccion"] );
                    if (trim($info["Direccion"] ) === '-') {
                       $info["Direccion"]  = '';
                    }
                    return;
                }

                for ($i=0;$i<=2;$i++)
                {
                    $items[$i] = trim($items[$i]);
                }

                $pieces = explode(' ', $items[0]);
                list($len, $value) = $this->getDepartment(end($pieces));
                // $company->departamento = $value;
                // $company->provincia = $items[1];
                // $company->distrito = $items[2];
                array_splice($pieces, -1 * $len);
                $direccion = join(' ', $pieces);
                $data['direccion'] = $direccion;
                $data['departamento'] = Departamento::idByDescription($value);
                $data['provincia'] = Provincia::idByDescription($items[1]);

                $data['distrito'] =  Distrito::idByDescription(ltrim($items[2]), $data['provincia']);
            }else{
                $data['direccion'] = "";
                $data['departamento'] = "-1";
                $data['provincia'] = "-1";
                $data['distrito'] =  "-1";
            }
            

            $data['ruc'] = $info["RUC"];
            $data['razonSocial'] = $info["RazonSocial"];
            $data['nombreComercial'] = $info["NombreComercial"];

            if( $info!=false )
            {
                $success=TRUE;
                $datos_json = response()
                                ->json([
                                    'success' =>  $success, 
                                    'result' => $data
                                ]);

            }
            else
            {
                $success=FALSE;
                $datos_json = response()
                                ->json([
                                    'success' =>  $success, 
                                    'msg'=>'- PROBLEMAS CON LA SUNAT.',
                                    'est'=>'1'
                                ]);
            }
        }else{
            $success=FALSE;
            $datos_json = response()
                            ->json([
                                'success' =>  $success, 
                                'msg'=>'- El Numero de RUC no existe en la SUNAT',
                                'est'=>'0'
                            ]);
        }

        return $datos_json;
    }

    private function getDepartment($department)
    {
        $department = strtoupper($department);
        $words = 1;
        switch ($department) {
            case 'DIOS':
                $department = 'MADRE DE DIOS';
                $words = 3;
            break;
            case 'MARTIN':
                $department = 'SAN MARTIN';
                $words = 2;
            break;
            case 'LIBERTAD':
                $department = 'LA LIBERTAD';
                $words = 2;
            break;
        }

        return [$words, $department];
    }

    public function otros(){
        $datos = Cliente::where('fk_tip_doc_id','11')->orderBy('pk_cli_id', 'desc')->first();
        if($datos!=null) { 
            $suma=$datos->c_num_doc+1;
            $correlativo = $suma;
        }else{
            $correlativo = 1;
        } 
        $success=TRUE;
        $datos_json = response()->json(['success' =>  $success, 'correlativo' => $correlativo]);
        return $datos_json;
    }

    // public function buscarRucDni($doc){
    //     //dd($ruc);
    //     $ruta = "https://ruc.com.pe/api/beta/ruc";
    //     $token = "4165cb2b-6ad6-4045-a4da-d2dcc0ce9c43-d2166d12-59e0-4886-ae14-abf6e51fdd06";

    //     $rucaconsultar = '10443750041';

    //     $data = array(
    //         "token" => $token,
    //         "ruc"   => $doc
    //     );
            
    //     $data_json = json_encode($data);

    //     // Invocamos el servicio a ruc.com.pe
    //     // Ejemplo para JSON
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $ruta);
    //     curl_setopt(
    //         $ch, CURLOPT_HTTPHEADER, array(
    //         'Content-Type: application/json',
    //         )
    //     );
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $respuesta  = curl_exec($ch);
    //     curl_close($ch);

    //     $leer_respuesta = json_decode($respuesta, true);
    //     if (isset($leer_respuesta['errors'])) {
    //         //Mostramos los errores si los hay
    //         $datos_json = response()->json([
    //                     'success' =>  $leer_respuesta['success'], 
    //                     'result' => $leer_respuesta['errors']
    //                 ]);
    //     } else {
    //         $datos_json = response()->json([
    //                     'success' =>  $leer_respuesta['success'], 
    //                     'result' => $leer_respuesta
    //                 ]);
    //     }

    //     return $datos_json;
    // }


}

