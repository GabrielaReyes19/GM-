<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Comprobante extends Model
{
    protected $table = 'mov_comprobante';
    protected $primaryKey = 'pk_cpb_id';

    // public function scopeBusqueda($query,$tDoc="",$fec="",$fecFin="",$est="")
    public function scopeBusqueda($query, $fec="", $fecFin="", $cli="", $doc="")
    {
        $sucursal=session('pk_suc_id');
        $query = Comprobante::Fecha($fec)->FechaFin($fecFin)->Cliente($cli)->Documento($doc)
        ->leftJoin('mae_cliente', 'mae_cliente.pk_cli_id', '=', 'mov_comprobante.fk_cli_id')
        ->leftJoin('mae_sucursal', 'mae_sucursal.pk_suc_id', '=', 'mov_comprobante.fk_suc_id')
        ->leftJoin('mae_tipo_documento', 'mae_tipo_documento.pk_tip_doc_id', '=', 'mae_cliente.fk_tip_doc_id')
        ->leftJoin('users', 'users.id', '=', 'mov_comprobante.fk_usu_id')
         // DB::raw("DATE_FORMAT(mov_comprobante.f_hor_fac, '%d/%m/%Y %h:%i:%s %p') as f_hor_fac"),
        ->select([
                'mov_comprobante.pk_cpb_id',
                'mov_comprobante.fk_usu_id',
                'mov_comprobante.fk_cli_id',
                'mov_comprobante.fk_suc_id',
                'mov_comprobante.fk_mon_id',
                'mov_comprobante.c_doc',
                'mov_comprobante.f_hor_fac',
                'mov_comprobante.n_sub_tot',
                'mov_comprobante.n_igv',
                'mov_comprobante.n_tot',
                'mov_comprobante.n_est',
                'mov_comprobante.n_est_cor',
                'mae_cliente.c_num_doc',
                'mae_cliente.c_raz',
                'mae_cliente.c_cor',
                DB::raw("DATE_FORMAT(mov_comprobante.f_hor_fac, '%d/%m/%Y') as f_hor_fac"),
                DB::raw("UPPER(users.name) as empleado"),
                'mae_sucursal.c_nom as sucursal',

            ])
        ->where('mov_comprobante.fk_suc_id','=',$sucursal)
        ->orderBy('mov_comprobante.pk_cpb_id', 'desc')
        ->get();
        return  $query;
    }

    public function scopeFecha($query,$fec="")
    {
        if(trim($fec) != ""){

            $query->where('mov_comprobante.f_hor_fac','>=',$fec);
        }

    }

    public function scopeFechaFin($query,$fecFin="")
    {
        if(trim($fecFin) != ""){

            $query->where('mov_comprobante.f_hor_fac','<=',$fecFin);
        }

    }

    public function scopeCliente($query,$cli="")
    {
        if(trim($cli) != ""){
            $query->where('mov_comprobante.fk_cli_id','=',$cli);
        }

    }

    public function scopeDocumento($query,$doc="")
    {
        if(trim($doc) != ""){
            $query->where('mov_comprobante.c_doc','=',$doc);
        }

    }

    public function scopeBusqueda2($query,$fecha="")
    {
        $sucursal=session('pk_suc_id');
        DB::statement(DB::raw('set @rownum=0'));
        $fechaReferencia = $fecha;

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
                'mov_comprobante.fk_suc_id',
                'mov_comprobante.c_doc',
                'mov_comprobante.f_hor_fac',
                'mov_comprobante.n_sub_tot',
                'mov_comprobante.n_igv',
                'mov_comprobante.n_tot',
                'mov_comprobante.n_est',
                'mov_comprobante.c_num_ser',
                'mov_comprobante.c_ar_sun',
                'mae_tipo_documento_venta.c_num',
                DB::raw("DATE_FORMAT(mov_comprobante.f_hor_fac, '%d/%m/%Y %h:%i:%s %p') as f_hor_fac"),
                DB::raw("UPPER(usu_mae_usuario.c_log) as empleado"),
                DB::raw("CONCAT(UPPER(mae_tipo_documento_venta.c_des),' ',UPPER(mov_comprobante.c_num_ser), ' - ',UPPER(mov_comprobante.c_doc)) as documento"),
                DB::raw("CONCAT(UPPER(mae_tipo_documento.c_nom),': ',UPPER(mae_cliente.c_num_doc), '  ',UPPER(mae_cliente.c_raz)) as cliente"),
                DB::raw("CONCAT(UPPER(mae_moneda.c_abr),' ',mov_comprobante.n_tot) as total"),
                'mae_sucursal.c_nom as sucursal'
            ])
        ->where('mov_comprobante.f_hor_fac','like','%'.$fecha.'%')
        ->where('mov_comprobante.fk_suc_id','=',$sucursal)
        ->get();
        
        return  $query;
    }

    public function scopeCboCliente($query, $id="")
    {
        $query = Cliente
        ::ClienteTipo($id)
        ->select(['mae_cliente.pk_cli_id',
                'mae_cliente.c_num_doc',
                'mae_cliente.fk_tip_doc_id',
            	DB::raw("UPPER(mae_cliente.c_raz) as c_raz"),
        		DB::raw("UPPER(mae_tipo_documento.c_nom) as tDoc")])
        ->join('mae_tipo_documento', 'mae_tipo_documento.pk_tip_doc_id', '=', 'mae_cliente.fk_tip_doc_id')
        ->where('mae_cliente.n_est','1')
         //->where('countries.country_name', $country)
        //->paginate(10);
        ->get();
        
        return  $query;
    }

    public function scopeCboSerie($query,$id="")
    {
        $query = DB::table('mae_sucursal_serie')
        ->select('mae_sucursal_serie.pk_suc_ser_id',
                'mae_sucursal_serie.c_num',
                'mae_sucursal_serie.c_num_fac_bol',
                DB::raw("mae_tipo_documento_venta.c_num as numTipo"))
        ->leftJoin('mae_tipo_documento_venta', 'mae_tipo_documento_venta.pk_tip_doc_ven_id', '=', 'mae_sucursal_serie.fk_tip_doc_ven_id')
        ->where('mae_sucursal_serie.fk_usu_id','8')
        ->where('mae_sucursal_serie.fk_suc_id','1')
        ->where('mae_sucursal_serie.fk_tip_doc_ven_id',$id)
        ->where('mae_sucursal_serie.n_est','1')
        ->get();
        
        return  $query;
    }

    public function scopeCboSerie2($query,$id,$id2)
    {
        $query = DB::table('mae_sucursal_serie')
        ->select('mae_sucursal_serie.pk_suc_ser_id',
                'mae_sucursal_serie.c_num',
                'mae_sucursal_serie.c_num_fac_bol')
        ->where('mae_sucursal_serie.fk_usu_id', Auth::user()->id)
        ->where('mae_sucursal_serie.fk_suc_id','1')
        ->where('mae_sucursal_serie.fk_tip_doc_ven_id',$id)
        ->where('mae_sucursal_serie.c_num_fac_bol','03')
        ->where('mae_sucursal_serie.n_est','1')
        ->get();
        
        return  $query;
    }

    public function scopeCboAlmacen($query)
    {
        $query = DB::table('mae_sucursal_almacen')
        ->select(
        		'mae_sucursal_almacen.fk_alm_id',
                'mae_sucursal_almacen.fk_suc_id',
            	DB::raw("UPPER(mae_almacen.c_nom) as c_nom")
            	)
        ->join('mae_almacen', 'mae_almacen.pk_alm_id', '=', 'mae_sucursal_almacen.fk_alm_id')
        ->join('mae_sucursal', 'mae_sucursal.pk_suc_id', '=', 'mae_sucursal_almacen.fk_suc_id')
        ->where('mae_sucursal_almacen.n_est','1')
        ->where('mae_sucursal_almacen.fk_suc_id','1')
        ->get();
        
        return  $query;
    }

    public function scopeCboProducto($query)
    {
        $query = DB::table('mae_producto')
        ->select(
            'mae_producto.pk_prd_id',
            'mae_producto.c_cod',
            DB::raw("UPPER(mae_producto.c_nom) as c_nom"),
            DB::raw("UPPER(mae_unidad_medida.c_nom) as nomUnidad"),
            'mae_producto.n_est',
            DB::raw("CONCAT(mae_producto.pk_prd_id,' - ',UPPER(mae_producto.c_nom)) as producto")
            )
        ->leftJoin('mae_unidad_medida', 'mae_unidad_medida.pk_uni_med_id', '=', 'mae_producto.fk_uni_med_id')
        ->where('mae_producto.n_est','1')
        ->get();
        
        return  $query;
    }

    // public function scopeCboProducto($query)
    // {
    //     $query = DB::table('mov_almacen_producto')
    //     ->select(
    //             'mov_almacen_producto.pk_alm_prod_id',
    //             'mov_almacen_producto.fk_prd_id',
    //             'mov_almacen_producto.n_can',
    //             'mae_producto.c_cod',
    //             DB::raw("UPPER(mae_producto.c_nom) as c_nom"),
    //             DB::raw("UPPER(mae_unidad_medida.c_nom) as nomUnidad"),
    //             'mae_producto.n_est',
    //             DB::raw("CONCAT(UPPER(mae_producto.c_cod),' ',UPPER(mae_producto.c_nom)) as producto")
    //             )
    //     ->leftJoin('mae_producto', 'mae_producto.pk_prd_id', '=', 'mov_almacen_producto.fk_prd_id')
    //     ->leftJoin('mae_unidad_medida', 'mae_unidad_medida.pk_uni_med_id', '=', 'mae_producto.fk_uni_med_id')
    //     ->get();
        
    //     return  $query;
    // }

    public function scopeCorrelativo($query)
    {
        $estado="";

        $query = DB::select(
            "SELECT 
                MAX( c_doc ) as c_doc 
            from 
                mov_comprobante 
            where 
                n_est=2
        ");

        return  $query;
    }

    public function scopeDatosCliente($query,$id="")
    {
        $query = DB::table('mae_cliente')
        ->select('pk_cli_id',
                'fk_tip_doc_id',
                'c_raz',
                'c_dir',
                'c_num_doc')
        ->where('pk_cli_id',$id)
        ->get();
        
        return  $query;
    }

    //     public function scopeDatosProducto($query,$id="",$id2="")
    // {
    //     $query = DB::table('mov_almacen_producto')
    //     ->select(
    //             'mov_almacen_producto.pk_alm_prod_id',
    //             'mov_almacen_producto.fk_prd_id',
    //             'mov_almacen_producto.n_can',
    //             'mae_producto.c_cod',
    //             'mae_producto.n_pre_ven',
    //             DB::raw("UPPER(mae_producto.c_nom) as c_nom"),
    //             DB::raw("UPPER(mae_unidad_medida.c_nom) as nomUnidad"),
    //             'mae_producto.n_est'
    //             )
    //     ->join('mae_producto', 'mae_producto.pk_prd_id', '=', 'mov_almacen_producto.fk_prd_id')
    //     ->join('mae_unidad_medida', 'mae_unidad_medida.pk_uni_med_id', '=', 'mae_producto.fk_uni_med_id')
    //     ->where('mov_almacen_producto.fk_alm_id',$id2)
    //     ->where('mov_almacen_producto.fk_suc_id',"1")
    //     ->where('mae_producto.c_cod',$id)
    //     ->get();
    //     return  $query;
    // }

    public function scopeCorreoCliente($query,$id="")
    {
        $query = DB::table('mae_cliente')
        ->select('pk_cli_id','c_cor')
        ->where('pk_cli_id',$id)
        ->get();
        
        return  $query;
    }


    public function scopeComprobanteCabecera($query, $id="")
    {
        $query = Comprobante::
        leftJoin('mae_cliente', 'mae_cliente.pk_cli_id', '=', 'mov_comprobante.fk_cli_id')
        ->leftJoin('mae_distrito', 'mae_distrito.pk_dis_id', '=', 'mae_cliente.fk_dis_id')
        ->leftJoin('mae_provincia', 'mae_provincia.pk_pvi_id', '=', 'mae_distrito.fk_pvi_id')
        ->leftJoin('mae_departamento', 'mae_departamento.pk_dep_id', '=', 'mae_provincia.fk_dep_id')
        ->leftJoin('mae_sucursal', 'mae_sucursal.pk_suc_id', '=', 'mov_comprobante.fk_suc_id')
        ->leftJoin('users', 'users.id', '=', 'mov_comprobante.fk_usu_id')
        ->leftJoin('mae_empleado', 'mae_empleado.pk_emp_id', '=', 'users.fk_emp_id')
        ->leftJoin('mae_moneda', 'mae_moneda.pk_mon_id', '=', 'mov_comprobante.fk_mon_id')
        ->leftJoin('mae_tipo_documento', 'mae_tipo_documento.pk_tip_doc_id', '=', 'mae_cliente.fk_tip_doc_id')
         // DB::raw("DATE_FORMAT(mov_comprobante.f_hor_fac, '%d/%m/%Y %h:%i:%s %p') as f_hor_fac"),
        ->select([
                'mov_comprobante.pk_cpb_id',
                'mov_comprobante.fk_usu_id',
                'mov_comprobante.fk_cli_id',
                'mov_comprobante.fk_suc_id',
                'mov_comprobante.fk_mon_id',
                'mov_comprobante.c_doc',
                'mov_comprobante.n_sub_tot',
                'mov_comprobante.n_igv',
                'mov_comprobante.n_tot',
                'mov_comprobante.n_tot_des',
                'mov_comprobante.n_des',
                'mov_comprobante.n_est',
                'mov_comprobante.c_obs',
                'mov_comprobante.c_asu',
                'mov_comprobante.f_hor_fac as fComprobante',
                'mae_cliente.pk_cli_id',
                'mae_cliente.fk_tip_doc_id',
                'mae_cliente.c_num_doc',
                'mae_cliente.c_raz',
                'mae_cliente.c_cor',
                'mae_cliente.c_dir',
                'mae_moneda.c_abr',
                'mae_distrito.c_nom as nomDistrito',
                'mae_provincia.c_nom as nomProvincia',
                'mae_departamento.c_nom as nomDepartamento',
                'mae_empleado.c_nom as nomEmpleado',
                'mae_empleado.c_pri_ape',
                'mae_empleado.c_seg_ape',
                'mae_empleado.c_tel',
                'mae_cliente.c_rep',
                'mae_tipo_documento.pk_tip_doc_id',
                DB::raw("DATE_FORMAT(mov_comprobante.f_ini_obra, '%d/%m/%Y') as f_ini_obra"),
                DB::raw("DATE_FORMAT(mov_comprobante.f_fin_obra, '%d/%m/%Y') as f_fin_obra"),
                DB::raw("DATE_FORMAT(mov_comprobante.f_hor_fac, '%d/%m/%Y') as f_hor_fac"),
                DB::raw("DATE_FORMAT(mov_comprobante.f_hor_fac_ven, '%d/%m/%Y') as f_hor_fac_ven"),
                DB::raw("UPPER(users.name) as empleado"),
                'mae_sucursal.c_nom as sucursal',
                DB::raw("CONCAT(UPPER(mae_tipo_documento.c_nom),': ',UPPER(mae_cliente.c_num_doc), '  ',UPPER(mae_cliente.c_raz)) as cliente")

            ])

        ->where('mov_comprobante.pk_cpb_id','=', $id)
        ->get();
        
        return  $query;
    }

    public function scopeComprobanteDetalleCabecera($query, $id="")
    {
        $query = Comprobante::
        leftJoin('mov_detalle_comprobante', 'mov_detalle_comprobante.fk_cpb_id', '=', 'mov_comprobante.pk_cpb_id')
        ->leftJoin('mae_producto', 'mae_producto.pk_prd_id', '=', 'mov_detalle_comprobante.fk_prd_id')
        ->leftJoin('mae_unidad_medida', 'mae_unidad_medida.pk_uni_med_id', '=', 'mov_detalle_comprobante.fk_uni_med_id')
        ->select([
                'mov_detalle_comprobante.fk_prd_id',
                'mov_detalle_comprobante.n_can',
                'mov_detalle_comprobante.n_pre',
                'mov_detalle_comprobante.n_igv',
                'mov_detalle_comprobante.n_sub_tot_sin_igv',
                'mov_detalle_comprobante.n_sub_tot',
                'mae_unidad_medida.c_abr',
                'mae_unidad_medida.pk_uni_med_id',
                'mov_detalle_comprobante.c_obs',
                'mae_producto.c_img',
                DB::raw("UPPER(mae_producto.c_nom) as nomProducto"),
                DB::raw("UPPER(mae_unidad_medida.c_nom ) as nomUnidadMedida"),
                DB::raw("UPPER(mae_producto.c_cod) as c_cod"),
                DB::raw("UPPER(mov_detalle_comprobante.c_nom) as c_nom"),
            ])

        ->where('mov_comprobante.pk_cpb_id','=', $id)
        ->get();
        
        return  $query;
    }


}
