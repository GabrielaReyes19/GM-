<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado;
use App\Sucursal;
use DB;
use Carbon\Carbon;

class AccederController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $fk_emp_id=auth()->user()->fk_emp_id;
        $id=auth()->user()->id;
        $empleado = Empleado::where('pk_emp_id', $fk_emp_id)->first();
        $sucursal = Sucursal::SucursalUsuario($id);
        return view('acceder.index',compact('empleado','sucursal'));
    }


    public function acceso(Request $request)
    {
        $id=$request->input('id');
        $datos = Sucursal::where('pk_suc_id', $id)->first();
        $empleado = Empleado::where('pk_emp_id', auth()->user()->fk_emp_id)->first();
        $nombreEmpleado=$empleado->c_nom." ".$empleado->c_pri_ape." ".$empleado->c_seg_ape;
        session(['pk_suc_id'=>$datos->pk_suc_id]);
        session(['nomSucursal'=>$datos->c_nom]);
        session(['nomEmppleado'=>$nombreEmpleado]);
        // dd(session('pk_suc_id'));
        $success=TRUE;
        $datos_json = response()->json(['success' =>  $success, 'id' =>  $id]);
        return $datos_json;
    }

}
