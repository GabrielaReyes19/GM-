<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Cliente extends Model
{
    protected $table = 'mae_cliente';
    protected $primaryKey = 'pk_cli_id';
    protected $fillable = [
        'fk_tip_doc_id', 'c_num_doc', 'c_raz', 'c_pri_ape', 'c_seg_ape', 'c_nom', 'c_dir', 'c_tel', 'c_cor', 'c_rep', 'n_est'
    ];

    public function scopeBusqueda($query)
    {
        $query = Cliente
        ::leftJoin('mae_tipo_documento', 'mae_tipo_documento.pk_tip_doc_id', '=', 'mae_cliente.fk_tip_doc_id')
        ->leftJoin('mae_distrito', 'mae_distrito.pk_dis_id', '=', 'mae_cliente.fk_dis_id')
        ->leftJoin('mae_provincia', 'mae_provincia.pk_pvi_id', '=', 'mae_distrito.fk_pvi_id')
        ->leftJoin('mae_departamento', 'mae_departamento.pk_dep_id', '=', 'mae_provincia.fk_dep_id')
        ->select('mae_cliente.pk_cli_id',
                'mae_cliente.fk_dis_id',
                'mae_cliente.c_num_doc',
                'mae_cliente.c_raz',
                'mae_cliente.c_pri_ape',
                'mae_cliente.c_seg_ape',
                'mae_cliente.c_nom',
                'mae_cliente.c_dir',
                'mae_cliente.c_cor',
                'mae_cliente.c_tel',
                'mae_cliente.c_rep',
                'mae_tipo_documento.c_abr',
                'mae_cliente.n_est')
        // ->where('mae_cliente.c_num_doc','like','%'.$doc.'%')
        ->orderBy('mae_cliente.pk_cli_id', 'desc')
        ->get();



		// $query = DB::table('clients')
  //       ->select('clients.id',
  //               'clients.district_id',
  //               'clients.number',
  //               'clients.business_name',
  //               'clients.surname',
  //               'clients.second_surname',
  //               'clients.name',
  //               'clients.address',
  //               'clients.mail',
  //               'clients.phone',
  //               'clients.representative',
  //               'documents.name as document_name')
  //       ->leftJoin('documents', 'documents.id', '=', 'clients.document_id')
  //       ->leftJoin('districts', 'districts.id', '=', 'clients.district_id')
  //       ->leftJoin('provinces', 'provinces.id', '=', 'districts.province_id')
  //       ->leftJoin('departments', 'departments.id', '=', 'provinces.department_id')
  //       ->where('clients.number','like','%'.$doc.'%')
  //        //->where('countries.country_name', $country)
  //       //->paginate(10);
		// ->get();
        return  $query;
    }


    public function scopeClienteTipo($query,$id="")
    {
        if(trim($id) == "01"){
          $query->where('mae_cliente.fk_tip_doc_id','=','2');
        }else if(trim($id) == "03"){
          $query->whereNotIn('mae_cliente.fk_tip_doc_id', [2]);
        }

    }
}
