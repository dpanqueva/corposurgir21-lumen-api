<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Contact extends Model{

    public $table = 'contactanos';
    public $primaryKey='contacto_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'contacto_id',
		'correo',
        'numero_contacto',
		'tipo_contacto',
		'mensaje'
    ];

}
