<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Clasificacion;
use DB;
use Carbon\Carbon;

class ClasificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('redireccionaSiNoExisteSucursal');
        $this->nameModule = "producto";
        $this->titleModule = "Productos y servicios";
        $this->linkBaseModule = "producto/";
    }

    public function index()
    {

    }

    private function messages()
    {
        $messages = [
            // 'claNom.unique' => '- La clasificación ya existe en la base de datos.',
            'claNom.required' => '- Es necesario ingresar clasificación.',
        ];

        return $messages; 
    }

    private function rules($request)
    {
        $rules = [
            // 'claNom' => 'required|unique:mae_clasificacion,c_nom,'. $request->route('pk_cla_id') . ',pk_cla_id',
            'claNom' => 'required',
        ];
        return $rules;
    }

    public function create()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;

        return view('clasificacion.create',compact('nameModule','titleModule','linkBaseModule'));
    }

    public function cboClasificacion($id="", $id2="")
    {
        $clasificacion = Clasificacion::select(['pk_cla_id',DB::raw("UPPER(c_nom) as c_nom")])->orderBy('c_nom', 'desc')->get();
        return view('clasificacion.cboClasificacion',compact('clasificacion', 'id', 'id2'));
    }

    public function store(Request $request)
    {
        $usuario=auth()->user()->id;
        $c_nom=$request->input('claNom');
        $n_est=$request->input('est');

        $datos = DB::table("mae_clasificacion")
            ->where("c_nom", "=", $c_nom)
            ->count();
        if($datos!=0){
            $messages = [
              'claNom' => '- La clasificación ['.$c_nom.'] ya existe en la base de datos.',
            ];
            //dd($messages);

            $success=FALSE;
            $datos_json = response()->json(['success' =>  $success,'validarDetalle' => '2', 'validar' =>  $messages]);
            return $datos_json;
        }

        $validator = \Validator::make($request->all(), $this->rules($request), $this->messages());

        if ($validator->fails()) {
            $success=FALSE;
            $datos_json = response()
            ->json(['success' =>  $success,'validar' => $validator->getMessageBag()->toArray()]);
            return $datos_json;
        }else{
            $data = array(
                "c_nom" => $c_nom,
                "n_est" => $n_est,
                "c_usu_cre" => $usuario,
                "f_cre" => Carbon::now(),
            );
            $id = DB::table('mae_clasificacion')->insertGetId($data,'pk_cla_id');
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
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $clasificacion = Clasificacion::findOrFail($id);
        return view('clasificacion.edit',compact('nameModule','titleModule','linkBaseModule','clasificacion'));
    }

    public function update(Request $request, $id)
    {
        $usuario=auth()->user()->id;
        $c_nom=$request->input('claNom');
        $c_nom2=$request->input('claNom2');
        $n_est=$request->input('est');
        $validator = \Validator::make($request->all(), $this->rules($request), $this->messages());
        if ($validator->fails()) {
            $success=FALSE;
            $datos_json = response()
            ->json(['success' =>  $success,'validar' => $validator->getMessageBag()->toArray()]);
            return $datos_json;
        }else{
            $datos = DB::table("mae_clasificacion")
            ->where("c_nom", "=", $c_nom) 
            ->whereNotIn('c_nom', [$c_nom2])
            ->count();

            if($datos!=0){
                $messages = [
                  'claNom' => '- La clasificación ['.$c_nom.'] ya existe en la base de datos.',
                ];
                //dd($messages);

                $success=FALSE;
                $datos_json = response()->json(['success' =>  $success,'validarDetalle' => '2', 'validar' =>  $messages]);
                return $datos_json;
            }

            DB::table('mae_clasificacion')->where('pk_cla_id',$id)->update([
                "c_nom" => $c_nom,
                "n_est" => $n_est,
                "c_usu_mod" => $usuario,
                "f_mod" => Carbon::now(),
            ]);
            $success=TRUE;
            $datos_json = response()->json(['success' =>  $success, 'id' =>  $id]);
        }
        return $datos_json;
    }

    public function destroy($id)
    {
        $usuario=auth()->user()->id;

        $datos = DB::table("mae_categoria")
        ->where("fk_cla_id", "=", $id)
        ->count();
        if($datos!=0){
            $success=FALSE;
        }else{
            Clasificacion::findOrFail($id)->delete();
            $success=TRUE;
        }

        $datos_json = response()->json(['success' =>  $success]);
        return $datos_json;
    }

}
