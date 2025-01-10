<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class TipoOperacion extends Model
{
    protected $table = 'mae_tipo_operacion';

    public function scopeTipoOperacion($query)
    {
        $query = DB::table('mae_tipo_operacion')
        ->select('pk_tip_ope_id',
                'c_nom')
        ->where('n_est','1')
        ->get();
        
        return  $query;
    }
}
