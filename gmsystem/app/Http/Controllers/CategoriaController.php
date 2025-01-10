<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Categoria;
use App\Clasificacion;
use DB;
use Carbon\Carbon;

class CategoriaController extends Controller
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
            // 'claNom.unique' => '- La clasificación ya existe en la base de datos.',
            'catNom.required' => '- Es necesario ingresar categoria.',
        ];

        return $messages; 
    }

    private function rules($request)
    {
        $rules = [
            // 'catNom' => 'required|unique:mae_clasificacion,c_nom,'. $request->route('pk_cla_id') . ',pk_cla_id',
            'catNom' => 'required',
        ];
        return $rules;
    }

    public function create($id="")
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $clasificacion = Clasificacion::where('pk_cla_id','=',$id)->get();
        return view('categoria.create',compact('nameModule','titleModule','linkBaseModule', 'id', 'clasificacion'));
    }

    public function cboCategoria($id="", $id2="", $id3="")
    {
        $categoria = Categoria::select(['pk_cat_id',DB::raw("UPPER(c_nom) as c_nom")])->where('fk_cla_id','=',$id)->orderBy('c_nom', 'desc')->get();
        return view('categoria.cboCategoria',compact('categoria', 'id2', 'id3'));
    }

    public function store(Request $request)
    {
        $usuario=auth()->user()->id;
        $id=$request->input('id');
        $c_nom=$request->input('catNom');
        $n_est=$request->input('est');
        $datos = DB::table("mae_categoria")
            ->where("c_nom", "=", $c_nom)
            ->count();
        if($datos!=0){
            $messages = [
              'catNom' => '- La categoria ['.$c_nom.'] ya existe en la base de datos.',
            ];
            //dd($messages);

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
                "fk_cla_id" => $id,
                "n_est" => $n_est,
                "c_usu_cre" => $usuario,
                "f_cre" => Carbon::now(),
            );
            $idCat = DB::table('mae_categoria')->insertGetId($data,'pk_cat_id');

            $success=TRUE;
            $datos_json = response()->json(['success' =>  $success, 'id' =>  $idCat]);
        }
        return $datos_json;
    }


    public function show($id)
    {
        //
    }

    public function edit($id, $id2)
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $clasificacion = Clasificacion::where('pk_cla_id','=',$id)->get();
        $categoria = Categoria::findOrFail($id2);
        return view('categoria.edit',compact('nameModule','titleModule','linkBaseModule', 'id', 'clasificacion', 'categoria'));
    }

    public function update(Request $request, $id)
    {
        $usuario=auth()->user()->id;
        $c_nom=$request->input('catNom');
        $c_nom2=$request->input('catNom2');
        $n_est=$request->input('est');
        $validator = \Validator::make($request->all(), $this->rules($request), $this->messages());

        if ($validator->fails()) {
            $success=FALSE;
            $datos_json = response()
            ->json(['success' =>  $success,'validar' => $validator->getMessageBag()->toArray()]);
            return $datos_json;
        }else{

        $datos = DB::table("mae_categoria")
        ->where("c_nom", "=", $c_nom) 
        ->whereNotIn('c_nom', [$c_nom2])
        ->count();

        if($datos!=0){
            $messages = [
              'catNom' => '- La categoria ['.$c_nom.'] ya existe en la base de datos.',
            ];
            //dd($messages);

            $success=FALSE;
            $datos_json = response()->json(['success' =>  $success, 'validar' =>  $messages]);
            return $datos_json;
        }

        DB::table('mae_categoria')->where('pk_cat_id',$id)->update([
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $usuario="1";

        $datos = DB::table("mae_producto")
        ->where("fk_cat_id", "=", $id)
        ->count();
        if($datos!=0){
            $success=FALSE;
        }else{
            Categoria::findOrFail($id)->delete();
            $success=TRUE;
        }

        $datos_json = response()->json(['success' =>  $success]);
        return $datos_json;
    }
}
