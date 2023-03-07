<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Donation extends Model{

    public $table = 'donacion';
    public $primaryKey='donacion_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'donacion_id',
		'banco_entidad',
        'tipo_cuenta',
		'numero_cuenta',
		'logo'
    ];

}
