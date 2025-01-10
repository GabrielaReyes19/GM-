<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Clasificacion;
use App\Marca;
use App\ProductoServicio;
use App\UnidadMedida;
use App\Moneda;
use DB;
use Carbon\Carbon;
use File;

class ProductoServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('redireccionaSiNoExisteSucursal');
        $this->nameModule = "producto";
        $this->titleModule = "Productos y servicios";
        $this->linkBaseModule = "producto/";
    }

    private function messages()
    {
        $messages = [
            'clasificacionId.required' => '- Es necesario seleccionar clasificaión.',
            'categoria.required' => '- Es necesario seleccionar categoria.',
            //'proCod.required' => '- Es necesario ingresar un código.',
            'proNom.required' => '- Es necesario ingresar un nombre del producto o servicio.',
            'unidadMedida.required' => '- Es necesario seleccionar un tipo.',
            'moneda.required' => '- Es necesario seleccionar una moneda.',
        ];

        return $messages; 
    }

    private function rules($request)
    {
        $rules = [
            'clasificacionId' => 'required',
            'categoria' => 'required',
            //'proCod' => 'required',
            'proNom' => 'required',
            'unidadMedida' => 'required',
            'moneda' => 'required',
        ];
        return $rules;
    }

    public function index()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        return view('productoServicio.index', compact('titleModule','linkBaseModule','nameModule'));
    }

    public function create()
    {
        $nameModule = $this->nameModule;
        $titleModule = $this->titleModule;
        $linkBaseModule = $this->linkBaseModule;
        $tipo = UnidadMedida::get();
        $moneda = Moneda::get();
        return view('productoServicio.create',compact('nameModule','titleModule','linkBaseModule','tipo', 'moneda'));
    }

    public function apiProductoServicio(Request $request)
    {
        $pro = $request->input('pro');
        $datos = ProductoServicio::Busqueda($pro);
        return Datatables::of($datos)
        ->addColumn('codigo', function($datos){
            $codigo="";
            if($datos->c_cod==""){
                $codigo='---'; 
            }else{
                $codigo=$datos->c_cod; 
            }
            return $codigo;
        })

        ->addColumn('precio', function($datos){
          if($datos->fk_mon_id=="1"){
            return "S/. ".$datos->n_pre_ven;
          }else{
            return "US$ ".$datos->n_pre_ven;
          }
        })

        ->addColumn('estado', function($datos){
                $estado="";
                if($datos->n_est=="1"){
                    $estado='<a href="#" onclick="return false;" class="label label-success label-tag">Activo</a>'; 
                }else{
                    $estado='<a href="#" onclick="return false;" class="label label-danger label-tag">Inactivo</a>'; 
                }
                return $estado;
        })
        ->addColumn('img', function($datos){
            return '<img src="public/images/'.$datos->c_img.'" style="width:100px; height:100px;"/>';

        })
        ->addColumn('action', function($datos){
            return '<div class="btn-group btn-group-xs">
              <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                <span class="fa fa-cog"></span>&nbsp;<span class="fa fa-caret-down"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="#" onclick="renderUpdate(\''.$datos->pk_prd_id.'\');" id="btn_upd_'.$datos->pk_prd_id.'">Editar </a></li>
                <li><a href="#" onclick="renderDelete(\''.$datos->pk_prd_id.'\');" id="btn_del_'.$datos->pk_prd_id.'" >Borrar </a></li>
              </ul>
            </div>';
        })
        ->rawColumns(['codigo', 'estado', 'action', 'img'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $img="";
        $usuario=auth()->user()->id;
        $fk_cla_id=$request->input('clasificacionId');
        $fk_cat_id=$request->input('categoria');
        $fk_mar_id=$request->input('marca');
        $fk_uni_med_id=$request->input('unidadMedida');
        $fk_mon_id=$request->input('moneda');
        $c_nom=$request->input('proNom');
        $c_cod=$request->input('proCod');
        $n_pre_com="0.00";
        $n_pre_ven=$request->input('preVen');
        $n_can_min="0";
        $n_can_max="0";
        $c_obs=$request->input('obs');
        $n_est=$request->input('est');

        $datos = DB::table("mae_producto")
            ->where("c_nom", "=", $c_nom)
            ->count();
        if($datos!=0){
            $messages = [
              'proNom' => '- El producto ['.$c_nom.'] ya existe en la base de datos.',
            ];

            $success=FALSE;
            $datos_json = response()->json(['success' =>  $success,'validarDetalle' => '2', 'validar' =>  $messages]);
            return $datos_json;
        }

        $validator = \Validator::make($request->all(), $this->rules($request), $this->messages());

        if ($validator->fails()) {
            $success=FALSE;
            $datos_json = response()
            ->json(['success' =>  $success,'validar' => $validator->getMessageBag()->toArray()]);
        }else{
            if($request->hasFile('imagen')){
                $file = $request->file('imagen');
                $path = public_path() . '/images';
                $fileName = uniqid() . '-' .$file->getClientOriginalName();
                $moved = $file->move($path, $fileName);
                if($moved) {
                    $img = $fileName;
                }
            }
            $data = array(
                "fk_cla_id" => $fk_cla_id,
                "fk_cat_id" => $fk_cat_id,
                "fk_mar_id" => $fk_mar_id,
                "fk_uni_med_id" => $fk_uni_med_id,
                "fk_mon_id" => $fk_mon_id,
                "c_nom" => $c_nom,
                "c_cod" => $c_cod,
                "n_pre_com" => $n_pre_com,
                "n_pre_ven" => $n_pre_ven,
                "n_can_min" => $n_can_min,
                "n_can_max" => $n_can_max,
                "c_obs" => $c_obs,
                "c_img" => $img,
                "n_est" => $n_est,
                "c_usu_cre" => $usuario,
                "f_cre" => Carbon::now(),
            );
            $id = DB::table('mae_producto')->insertGetId($data,'pk_pro_id');

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
        $tipo = UnidadMedida::get();
        $moneda = Moneda::get();
        $producto = ProductoServicio::findOrFail($id);
        return view('productoServicio.edit',compact('nameModule','titleModule','linkBaseModule','tipo', 'moneda', 'producto'));
    }

    public function update(Request $request, $id)
    {
        $img="";
        $usuario=auth()->user()->id;
        $fk_cla_id=$request->input('clasificacionId');
        $fk_cat_id=$request->input('categoria');
        $fk_mar_id=$request->input('marca');
        $fk_uni_med_id=$request->input('unidadMedida');
        $fk_mon_id=$request->input('moneda');
        $c_nom=$request->input('proNom');
        $c_cod=$request->input('proCod');
        $c_cod2=$request->input('proCod2');
        $n_pre_com="0.00";
        $n_pre_ven=$request->input('preVen');
        $n_can_min="0";
        $n_can_max="0";
        $c_obs=$request->input('obs');
        $n_est=$request->input('est');
        $datosXId=ProductoServicio::findOrFail($id);

        $validator = \Validator::make($request->all(), $this->rules($request), $this->messages());

        if ($validator->fails()) {
            $success=FALSE;
            $datos_json = response()
            ->json(['success' =>  $success,'validar' => $validator->getMessageBag()->toArray()]);
        }else{
            $datos = DB::table("mae_producto")
            ->where("c_cod", "=", $c_cod) 
            ->whereNotIn('c_cod', [$c_cod2])
            ->count();

            if($datos!=0){
                $messages = [
                  'proCod' => '- El código ['.$c_cod.'] ya existe en la base de datos.',
                ];

                $success=FALSE;
                $datos_json = response()->json(['success' =>  $success, 'validar' =>  $messages]);
                return $datos_json;
            }
            if($request->hasFile('imagen')){
                $file = $request->file('imagen');
                $path = public_path() . '/images';
                $fileName = uniqid() . '-' .$file->getClientOriginalName();
                $moved = $file->move($path, $fileName);
                if($moved) {
                    $img = $fileName;
                }

                if($moved) {
                    $previousPath = $path . '/' .$datosXId->c_img;
                    $img= $fileName;
                    File::delete($previousPath);
                }
            }else{
                $productoXId=ProductoServicio::findOrFail($id);
                $img = $productoXId->c_img;
            }

            DB::table('mae_producto')->where('pk_prd_id',$id)->update([
                "fk_cla_id" => $fk_cla_id,
                "fk_cat_id" => $fk_cat_id,
                "fk_mar_id" => $fk_mar_id,
                "fk_uni_med_id" => $fk_uni_med_id,
                "fk_mon_id" => $fk_mon_id,
                "c_nom" => $c_nom,
                "c_cod" => $c_cod,
                "n_pre_com" => $n_pre_com,
                "n_pre_ven" => $n_pre_ven,
                "n_can_min" => $n_can_min,
                "n_can_max" => $n_can_max,
                "c_obs" => $c_obs,
                "c_img" => $img,
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

        $datos = DB::table("mov_detalle_comprobante")
        ->where("fk_prd_id", "=", $id)
        ->count();
        if($datos!=0){
            $success=FALSE;
        }else{
            $datosXId=ProductoServicio::findOrFail($id);
            $success=TRUE;
            $path = public_path() . '/images';
            $previousPath = $path . '/' .$datosXId->c_img;
            File::delete($previousPath);
            ProductoServicio::findOrFail($id)->delete();
        }

        $datos_json = response()->json(['success' =>  $success]);
        return $datos_json;
    }
}
