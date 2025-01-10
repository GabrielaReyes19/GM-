<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'mae_distrito';
    protected $primaryKey = 'pk_dis_id';

    static function idByDescription($description, $provincia)
    {
        $code = static::where('c_nom', $description)->where('fk_pvi_id', $provincia)->get();

        if (count($code) > 0) {
            
            return $code[0]->pk_dis_id;

        }
        return '15';
    }
}
