<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'mov_correo';
    protected $primaryKey = 'pk_cor_id';

    public $incrementing = false;
    public $timestamps = false;

}
