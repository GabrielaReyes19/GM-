<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
	protected $table = 'mov_almacen_producto';
	protected $primaryKey = 'pk_alm_prod_id';
	public $timestamps = false;
}
