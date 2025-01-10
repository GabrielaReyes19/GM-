<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'mae_provincia';
    protected $primaryKey = 'pk_pvi_id';

    static function idByDescription($description)
    {
        $code = static::where('c_nom', $description)->get();
        if (count($code) > 0) {
            return $code[0]->pk_pvi_id;
        }
        return '15';
    }
}
