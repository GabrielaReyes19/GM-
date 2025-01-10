<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Empresa extends Model
{
    protected $table = 'mae_empresa';

    public function scopeEmpresa()
    {
        $query = Empresa::
        leftJoin('mae_sucursal', 'mae_sucursal.fk_epr_id', '=', 'mae_empresa.pk_epr_id')
        ->leftJoin('mae_distrito', 'mae_distrito.pk_dis_id', '=', 'mae_empresa.fk_dis_id')
        ->leftJoin('mae_provincia', 'mae_provincia.pk_pvi_id', '=', 'mae_distrito.fk_pvi_id')
        ->leftJoin('mae_departamento', 'mae_departamento.pk_dep_id', '=', 'mae_provincia.fk_dep_id')
        ->select([
                'mae_empresa.pk_epr_id',
                'mae_empresa.c_num',
                'mae_empresa.c_raz_soc',
                'mae_empresa.c_nom_com',
                'mae_empresa.c_pag_web',
                'mae_empresa.c_tel',
                'mae_empresa.c_tel_sop',
                'mae_empresa.c_cor',
                'mae_empresa.c_fir',
                'mae_empresa.c_dir_emp',
                'mae_sucursal.c_dir',
                DB::raw("UPPER(mae_distrito.c_nom) as distrito"),
                DB::raw("UPPER(mae_provincia.c_nom) as provincia"),
                DB::raw("UPPER(mae_departamento.c_nom) as departamento")
            ])

        ->where('mae_sucursal.pk_suc_id','=', session('pk_suc_id'))
        ->get();
        
        return  $query;
    }
}
