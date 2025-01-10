<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Configuracion extends Model
{
	protected $table = 'mae_producto';
    protected $primaryKey = 'pk_prd_id';

	public function scopeBusqueda($query, $cla="", $cat="", $mar="")
    {
        $query = Configuracion::Clasificacion($cla)->Categoria($cat)->Marca($mar)
        ->leftJoin('mae_categoria', 'mae_categoria.pk_cat_id', '=', 'mae_producto.fk_cat_id')
        ->leftJoin('mae_marca', 'mae_marca.pk_mar_id', '=', 'mae_producto.fk_mar_id')
        ->leftJoin('mae_clasificacion', 'mae_clasificacion.pk_cla_id', '=', 'mae_categoria.fk_cla_id')
        ->leftJoin('mae_unidad_medida', 'mae_unidad_medida.pk_uni_med_id', '=', 'mae_producto.fk_uni_med_id')
        ->select([
        	'mae_producto.pk_prd_id',
            DB::raw("UPPER(mae_unidad_medida.c_nom) as nomUnidadMedida"),
            DB::raw("UPPER(mae_producto.c_nom) as c_nom"),
            DB::raw("UPPER(mae_producto.c_cod) as c_cod"),
            DB::raw("UPPER(mae_categoria.c_nom) as nomCategoria"),
            DB::raw("UPPER(mae_marca.c_nom) as nomMarca"),
            DB::raw("UPPER(mae_clasificacion.c_nom) as nomClasificacion"),
            'mae_producto.n_pre_com',
            'mae_producto.n_pre_ven',
            'mae_producto.c_img',
            'mae_producto.fk_mon_id',
            'mae_producto.n_est'

        ])
        ->orderBy('mae_producto.c_nom', 'asc')
        ->get();
        
        return  $query;
    }

    public function scopeClasificacion($query,$cla="")
    {
        if(trim($cla) != ""){

            $query->where('mae_producto.fk_cla_id','like','%'.$cla.'%');

        }

    }

    public function scopeCategoria($query,$cat="")
    {
        if(trim($cat) != ""){

            $query->where('mae_producto.fk_cat_id','like','%'.$cat.'%');

        }
    }

    public function scopeMarca($query,$mar="")
    {
        if(trim($mar) != ""){

            $query->where('mae_producto.fk_mar_id','like','%'.$mar.'%');

        }
    }
}
