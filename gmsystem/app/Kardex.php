<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
	protected $table = 'mov_kardex';
	protected $primaryKey = 'pk_kar_id';
	public $timestamps = false;
}
