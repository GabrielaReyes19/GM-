<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ResumenRc extends Model
{
   protected $table = 'mov_rc';

    public function scopeBusqueda($query, $fec="", $fecFin="")
    {
        $sucursal=session('pk_suc_id');
        $query = ResumenRc::Fecha($fec)->FechaFin($fecFin)
        ->select([
        		'pk_rc_id',
                'fk_suc_id',
                'c_cod',
                'c_num',
                'c_num_tic',
                'c_ar_sun',
                'n_est',
                'c_cod',
                'n_cant_doc',
                'n_est_anu',
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                DB::raw("DATE_FORMAT(f_gen, '%d/%m/%Y') as f_gen"),
                DB::raw("DATE_FORMAT(f_emi, '%d/%m/%Y') as f_emi")
            ])
        ->where('fk_suc_id','=',$sucursal)
        ->where('n_est_anu','=',"1")
        ->orderBy('pk_rc_id', 'desc')
        //->where('mae_cliente.c_num_doc','like','%'.$doc.'%')
        ->get();
        
        return  $query;
    }

    public function scopeBusquedaAnulado($query, $fec="", $fecFin="")
    {
        $sucursal=session('pk_suc_id');
        $query = ResumenRc::Fecha($fec)->FechaFin($fecFin)
        ->join('mov_detalle_rc', 'mov_detalle_rc.fk_rc_id', '=', 'mov_rc.pk_rc_id')
        ->join('mov_comprobante', 'mov_comprobante.pk_cpb_id', '=', 'mov_detalle_rc.fk_cpb_id')
        ->join('mae_tipo_documento_venta', 'mae_tipo_documento_venta.pk_tip_doc_ven_id', '=', 'mov_comprobante.fk_tip_doc_ven_id')
        ->select([
                'mov_rc.pk_rc_id',
                'mov_rc.fk_suc_id',
                'mov_rc.c_cod',
                'mov_rc.c_num',
                'mov_rc.c_num_tic',
                'mov_rc.c_ar_sun',
                'mov_rc.n_est',
                'mov_rc.c_cod',
                'mov_rc.n_cant_doc',
                'mov_rc.n_est_anu',
                'mov_detalle_rc.c_num_ser',
                'mov_detalle_rc.c_num_doc',
                'mov_detalle_rc.c_mot',
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                DB::raw("DATE_FORMAT(mov_rc.f_gen, '%d/%m/%Y') as f_gen"),
                DB::raw("DATE_FORMAT(mov_rc.f_emi, '%d/%m/%Y') as f_emi"),
                DB::raw("UPPER(mae_tipo_documento_venta.c_des) as c_des")
            ])
        ->where('mov_rc.fk_suc_id','=',$sucursal)
        ->where('mov_rc.n_est_anu','=',"2")
        ->orderBy('mov_rc.pk_rc_id', 'desc')
        //->where('mae_cliente.c_num_doc','like','%'.$doc.'%')
        ->get();
        
        return  $query;
    }

    public function scopeFecha($query,$fec="")
    {
        if(trim($fec) != ""){

            $query->where('f_gen','>=',$fec);
        }

    }

    public function scopeFechaFin($query,$fecFin="")
    {
        if(trim($fecFin) != ""){

            $query->where('f_gen','<=',$fecFin);
        }

    }

    public function scopeBusqueda2($query,$fecha="")
    {
        $sucursal=session('pk_suc_id');
        DB::statement(DB::raw('set @rownum=0'));
        $query = Comprobante
        ::leftJoin('mae_cliente', 'mae_cliente.pk_cli_id', '=', 'mov_comprobante.fk_cli_id')
        ->leftJoin('mae_sucursal', 'mae_sucursal.pk_suc_id', '=', 'mov_comprobante.fk_suc_id')
        ->leftJoin('mae_tipo_documento_venta', 'mae_tipo_documento_venta.pk_tip_doc_ven_id', '=', 'mov_comprobante.fk_tip_doc_ven_id')
        ->leftJoin('mae_tipo_documento', 'mae_tipo_documento.pk_tip_doc_id', '=', 'mae_cliente.fk_tip_doc_id')
        ->leftJoin('usu_mae_usuario', 'usu_mae_usuario.pk_usu_id', '=', 'mov_comprobante.fk_usu_id')
        ->leftJoin('mae_moneda', 'mae_moneda.pk_mon_id', '=', 'mov_comprobante.fk_mon_id')
        ->select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'mov_comprobante.pk_cpb_id',
                'mov_comprobante.fk_usu_id',
                'mov_comprobante.fk_cli_id',
                'mov_comprobante.fk_tip_doc_ven_id',
                'mov_comprobante.fk_suc_id',
                'mov_comprobante.c_doc',
                'mov_comprobante.f_hor_fac',
                'mov_comprobante.n_sub_tot',
                'mov_comprobante.n_igv',
                'mov_comprobante.n_tot',
                'mov_comprobante.n_est',
                'mov_comprobante.c_ar_sun',
                'mov_comprobante.c_mod_num_ser',
                'mov_comprobante.c_mod_doc',
                'mae_cliente.c_num_doc',
                'mae_tipo_documento_venta.c_num',
                DB::raw("DATE_FORMAT(mov_comprobante.f_hor_fac, '%d/%m/%Y') as f_hor_fac"),
                DB::raw("UPPER(usu_mae_usuario.c_log) as empleado"),
                DB::raw("UPPER(mae_tipo_documento_venta.c_des) as c_des"),
                DB::raw("UPPER(mov_comprobante.c_num_ser) as c_num_ser"),
                DB::raw("UPPER(mae_moneda.c_abr) as c_abr"),
                DB::raw("CONCAT(UPPER(mae_tipo_documento.c_nom),': ',UPPER(mae_cliente.c_num_doc), '  ',UPPER(mae_cliente.c_raz)) as cliente")
            ])
        ->whereIn('mov_comprobante.fk_tip_doc_ven_id', [2,3,4])
        ->where('mov_comprobante.f_hor_fac','like','%'.$fecha.'%')
        ->where('mov_comprobante.n_est_rc','=','1')
        ->where('mov_comprobante.fk_suc_id','=',$sucursal)
        ->get();
        
        return  $query;
    }

    public function scopeBusquedaVerDetalleResumenPorId($query,$id="")
    {
        $sucursal=session('pk_suc_id');
        $query = ResumenDetalleRc::
        leftJoin('mov_comprobante', 'mov_comprobante.pk_cpb_id', '=', 'mov_detalle_rc.fk_cpb_id')
        ->leftJoin('mae_cliente', 'mae_cliente.pk_cli_id', '=', 'mov_comprobante.fk_cli_id')
        ->leftJoin('mae_sucursal', 'mae_sucursal.pk_suc_id', '=', 'mov_comprobante.fk_suc_id')
        ->leftJoin('mae_tipo_documento_venta', 'mae_tipo_documento_venta.pk_tip_doc_ven_id', '=', 'mov_comprobante.fk_tip_doc_ven_id')
        ->leftJoin('mae_tipo_documento', 'mae_tipo_documento.pk_tip_doc_id', '=', 'mae_cliente.fk_tip_doc_id')
        ->leftJoin('usu_mae_usuario', 'usu_mae_usuario.pk_usu_id', '=', 'mov_comprobante.fk_usu_id')
        ->leftJoin('mae_moneda', 'mae_moneda.pk_mon_id', '=', 'mov_comprobante.fk_mon_id')
        ->select([
            'mov_comprobante.pk_cpb_id',
            'mov_comprobante.fk_usu_id',
            'mov_comprobante.fk_cli_id',
            'mov_comprobante.fk_tip_doc_ven_id',
            'mov_comprobante.fk_suc_id',
            'mov_comprobante.c_doc',
            'mov_comprobante.f_hor_fac',
            'mov_comprobante.n_sub_tot',
            'mov_comprobante.n_igv',
            'mov_comprobante.n_tot',
            'mov_comprobante.n_est as nEstCom',
            'mov_comprobante.c_ar_sun',
            'mae_cliente.c_num_doc',
            DB::raw("DATE_FORMAT(mov_comprobante.f_hor_fac, '%d/%m/%Y') as f_hor_fac"),
            DB::raw("UPPER(usu_mae_usuario.c_log) as empleado"),
            DB::raw("UPPER(mae_tipo_documento_venta.c_des) as c_des"),
            DB::raw("UPPER(mov_comprobante.c_num_ser) as c_num_ser"),
            DB::raw("UPPER(mae_moneda.c_abr) as c_abr"),
            DB::raw("CONCAT(UPPER(mae_tipo_documento.c_nom),': ',UPPER(mae_cliente.c_num_doc), '  ',UPPER(mae_cliente.c_raz)) as cliente")
        ])
        ->where('mov_detalle_rc.fk_rc_id','=',$id)
        ->where('mov_comprobante.fk_suc_id','=',$sucursal)
        // ->where('mov_comprobante.n_est','=','1')
        // ->where('mov_comprobante.n_est_sun','=','1')
        ->get();
        
        return  $query;
    }


    public function scopeTotal($query)
    {
       $query = DB::select(
        "select count(*) as total from mov_comprobante");

        return  $query;
    }

    public function scopeCorrelativo($query)
    {
       $query = DB::select(
        "select c_num from mov_rc order by pk_rc_id desc limit 1 
        ");

        return  $query;
    }


    public function scopeActivarComprobante($query, $id="")
    {
        $query = Comprobante::select([
            'mov_comprobante.pk_cpb_id',
            'mov_comprobante.fk_rc_id'
        ])

        ->where('mov_comprobante.fk_rc_id','=', $id)
        ->get();
        
        return  $query;
    }
}
