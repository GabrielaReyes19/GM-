<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sucursal extends Model
{
    protected $table = 'mae_sucursal';
    protected $primaryKey = 'pk_suc_id';


    public function scopeSucursalUsuario($query,$id="")
    {
        $query = DB::table('usu_mae_usuario_sucursal')
        ->select('usu_mae_usuario_sucursal.fk_usu_id',
                'usu_mae_usuario_sucursal.fk_suc_id',
            	DB::raw("UPPER(mae_sucursal.c_nom) as c_nom"))
        ->leftJoin('mae_sucursal', 'mae_sucursal.pk_suc_id', '=', 'usu_mae_usuario_sucursal.fk_suc_id')
        ->where('usu_mae_usuario_sucursal.fk_usu_id',$id)
        ->get();
        
        return  $query;
    }
}
