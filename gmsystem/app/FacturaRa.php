<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class FacturaRa extends Model
{
   protected $table = 'mov_ra';

    public function scopeBusqueda($query, $fec="", $fecFin="")
    {
        $sucursal=session('pk_suc_id');
        $query = FacturaRa::Fecha($fec)->FechaFin($fecFin)
        ->join('mov_detalle_ra', 'mov_detalle_ra.fk_ra_id', '=', 'mov_ra.pk_ra_id')
        ->join('mov_comprobante', 'mov_comprobante.pk_cpb_id', '=', 'mov_detalle_ra.fk_cpb_id')
        ->join('mae_tipo_documento_venta', 'mae_tipo_documento_venta.pk_tip_doc_ven_id', '=', 'mov_comprobante.fk_tip_doc_ven_id')
        ->select([
        		'mov_ra.pk_ra_id',
                'mov_ra.c_cod',
                'mov_ra.c_num',
                'mov_detalle_ra.c_num_ser',
                'mov_ra.c_num_tic',
                'mov_ra.c_ar_sun',
                'mov_ra.n_est',
                'mov_ra.c_cod',
                'mov_detalle_ra.c_mot',
                'mov_detalle_ra.c_num_doc',
                DB::raw("DATE_FORMAT(mov_ra.f_baja, '%d/%m/%Y') as f_baja"),
                DB::raw("DATE_FORMAT(mov_detalle_ra.f_doc, '%d/%m/%Y') as f_doc"),
                DB::raw("UPPER(mae_tipo_documento_venta.c_des) as c_des"),
                DB::raw("UPPER(mae_tipo_documento_venta.c_nom) as tDoc"),
            ])
         ->where('mov_ra.fk_suc_id','=',$sucursal)
         ->orderBy('mov_ra.pk_ra_id', 'desc')
        //->where('mae_cliente.c_num_doc','like','%'.$doc.'%')
        ->get();
        
        return  $query;
    }

    public function scopeFecha($query,$fec="")
    {
        if(trim($fec) != ""){

            $query->where('mov_ra.f_baja','>=',$fec);
        }
    }

    public function scopeFechaFin($query,$fecFin="")
    {
        if(trim($fecFin) != ""){

            $query->where('mov_ra.f_baja','<=',$fecFin);
        }
    }

    public function scopeCorrelativo($query)
    {
       $query = DB::select(
        "select c_num from mov_ra order by pk_ra_id desc limit 1 
        ");

        return  $query;
    }
}
