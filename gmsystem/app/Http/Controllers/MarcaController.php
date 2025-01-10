<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Marca;
use DB;
use Carbon\Carbon;

class MarcaController extends Controller
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
        //
    }

    private function messages()
    {
        $messages = [
            // 'marNom.unique' => '- La clasificación ya existe en la base de datos.',
            'marNom.required' => '- Es necesario ingresar marca.',
        ];

        return $messages; 
    }

    private function rules($request)
    {
        $rules = [
            // 'marNom' => 'required|unique:mae_clasificacion,c_nom,'. $request->route('pk_cla_id') . ',pk_cla_id',
            'marNom' => 'required',
        ];
        return $rules;
    }

    public function create()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;

        return view('marca.create',compact('nameModule','titleModule','linkBaseModule'));
    }

    public function cboMarca($id="", $id2="")
    {
        $marca = Marca::select(['pk_mar_id',DB::raw("UPPER(c_nom) as c_nom")])->orderBy('c_nom', 'desc')->get();
        return view('marca.cboMarca',compact('marca', 'id', 'id2'));
    }

    public function store(Request $request)
    {
        $usuario=auth()->user()->id;
        $c_nom=$request->input('marNom');
        $n_est=$request->input('est');
        $datos = DB::table("mae_marca")
            ->where("c_nom", "=", $c_nom)
            ->count();
        if($datos!=0){
            $messages = [
              'marNom' => '- La marca ['.$c_nom.'] ya existe en la base de datos.',
            ];

            $success=FALSE;
            $datos_json = response()->json(['success' =>  $success, 'validar' =>  $messages]);
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
            $id = DB::table('mae_marca')->insertGetId($data,'pk_mar_id');
            $success=TRUE;
            $datos_json = response()->json(['success' =>  $success, 'id' =>  $id]);
        }
        return $datos_json;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $marca = Marca::findOrFail($id);
        return view('marca.edit',compact('nameModule','titleModule','linkBaseModule','marca'));
    }


    public function update(Request $request, $id)
    {
        $usuario=auth()->user()->id;
        $c_nom=$request->input('marNom');
        $c_nom2=$request->input('marNom2');
        $n_est=$request->input('est');


        $validator = \Validator::make($request->all(), $this->rules($request), $this->messages());

        if ($validator->fails()) {
            $success=FALSE;
            $datos_json = response()
            ->json(['success' =>  $success,'validar' => $validator->getMessageBag()->toArray()]);
            return $datos_json;
        }else{
            $datos = DB::table("mae_marca")
            ->where("c_nom", "=", $c_nom) 
            ->whereNotIn('c_nom', [$c_nom2])
            ->count();

            if($datos!=0){
                $messages = [
                  'marNom' => '- La marca ['.$c_nom.'] ya existe en la base de datos.',
                ];

                $success=FALSE;
                $datos_json = response()->json(['success' =>  $success, 'validar' =>  $messages]);
                return $datos_json;
            }

            DB::table('mae_marca')->where('pk_mar_id',$id)->update([
                "c_nom" => $c_nom,
                "n_est" => $n_est,
                "c_usu_mod" => $usuario,
                "f_mod" => Carbon::now(),
            ]);

            $success=TRUE;
            $datos_json = response()->json(['success' =>  $success]);
        }
        return $datos_json;
    }

    public function destroy($id)
    {
        $usuario=auth()->user()->id;
        $datos = DB::table("mae_producto")
        ->where("fk_mar_id", "=", $id)
        ->count();
        if($datos!=0){
            $success=FALSE;
        }else{
            Marca::findOrFail($id)->delete();
            $success=TRUE;
        }

        $datos_json = response()->json(['success' =>  $success]);
        return $datos_json;
    }
}
