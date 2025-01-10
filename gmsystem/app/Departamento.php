<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'mae_departamento';
    protected $primaryKey = 'pk_dep_id';

    public $incrementing = false;
    public $timestamps = false;

    static function idByDescription($description)
    {
        $code = static::where('c_nom', $description)->get();
        if (count($code) > 0) {
            return $code[0]->pk_dep_id;
        }
        return '15';
    }
}
