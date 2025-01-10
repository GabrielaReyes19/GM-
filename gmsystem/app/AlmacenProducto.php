<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class AlmacenProducto extends Model
{
    protected $table = 'mov_almacen_producto';

    public function scopeDatosProducto($query,$id="",$id2="")
    {
        $query = AlmacenProducto::select(
                'mae_producto.pk_prd_id',
                'mov_almacen_producto.n_can',
                'mae_producto.c_cod',
                'mae_producto.n_pre_ven',
                'mae_unidad_medida.c_abr',
                DB::raw("UPPER(mae_producto.c_nom) as c_nom"),
                DB::raw("UPPER(mae_unidad_medida.c_nom) as nomUnidad"),
                'mae_producto.n_est'
                )
        ->join('mae_producto', 'mae_producto.pk_prd_id', '=', 'mov_almacen_producto.fk_prd_id')
        ->join('mae_unidad_medida', 'mae_unidad_medida.pk_uni_med_id', '=', 'mae_producto.fk_uni_med_id')
        // ->where('mae_producto.c_cod',$id)
        ->where('mov_almacen_producto.fk_prd_id',$id2)
        ->where('mov_almacen_producto.fk_suc_id',session('pk_suc_id'))
        ->where('mov_almacen_producto.fk_alm_id',$id)
        ->get();
        return  $query;
    }

    // public function scopeMonedaId($query,$id2="")
    // {
    //     if(trim($id2) != "-1"){
    //         $query->where('mae_producto.fk_mon_id',$id2);
    //     }

    // }

    
}
