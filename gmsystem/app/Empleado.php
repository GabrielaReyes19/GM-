<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'mae_empleado';
    protected $primaryKey = 'pk_emp_id';
}
