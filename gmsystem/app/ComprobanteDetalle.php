<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ComprobanteDetalle extends Model
{
    protected $table = 'mov_detalle_comprobante';
    protected $primaryKey = 'pk_det_cpb_id';

    public function scopeComprobanteDetalle($query, $id="")
    {
        $query = ComprobanteDetalle::
        leftJoin('mae_producto', 'mae_producto.pk_prd_id', '=', 'mov_detalle_comprobante.fk_prd_id')
        ->leftJoin('mae_unidad_medida', 'mae_unidad_medida.pk_uni_med_id', '=', 'mov_detalle_comprobante.fk_uni_med_id')
        ->select([
                'mov_detalle_comprobante.pk_det_cpb_id',
                'mov_detalle_comprobante.fk_cpb_id',
                'mov_detalle_comprobante.fk_prd_id',
                'mov_detalle_comprobante.n_can',
                'mov_detalle_comprobante.n_pre',
                'mov_detalle_comprobante.n_sub_tot_sin_igv',
                'mov_detalle_comprobante.n_igv',
                'mov_detalle_comprobante.n_sub_tot',
                'mae_unidad_medida.c_abr',
                DB::raw("UPPER(mae_producto.c_cod) as c_cod"),
                DB::raw("UPPER(mae_producto.c_nom) as c_nom")
            ])

        ->where('mov_detalle_comprobante.fk_cpb_id','=', $id)
        ->get();
        
        return  $query;
    }

    public function scopeDatosProductoComprobante($query,$id="",$id2="")
    {
        $query = ComprobanteDetalle::
        select([
                'n_pre',
            ])
        ->where('fk_prd_id','=', $id)
        ->where('fk_cpb_id','=', $id2)
        ->get();
        return  $query;
    }

}
