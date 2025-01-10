<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
	protected $table = 'mae_producto';

	public function scopeDatosProducto($query,$id="",$id2="")
    {
        
        $query = Producto::MonedaId($id2)
        		->select(
                'mae_producto.pk_prd_id',
                'mae_producto.n_can',
                'mae_producto.c_cod',
                'mae_producto.c_obs',
                'mae_producto.n_pre_ven',
                'mae_producto.c_img',
                'mae_unidad_medida.c_abr',
                'mae_unidad_medida.pk_uni_med_id',
                DB::raw("UPPER(mae_producto.c_nom) as c_nom"),
                DB::raw("UPPER(mae_unidad_medida.c_nom) as nomUnidad"),
                'mae_producto.n_est'
                )
        ->join('mae_unidad_medida', 'mae_unidad_medida.pk_uni_med_id', '=', 'mae_producto.fk_uni_med_id')
        ->where('mae_producto.pk_prd_id',$id)
        ->get();
        return  $query;
    }

    public function scopeMonedaId($query,$id2="")
    {
        if(trim($id2) != "-1"){
            $query->where('mae_producto.fk_mon_id',$id2);
        }

    }
}
