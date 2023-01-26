<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AllianceFeatures extends Model{

    public $table = 'alianza_caracteristica';
    public $primaryKey='alianza_caracteristica_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'descripcion',
        'codigo_nombre',
        'nombre_caracteristica',
        'alianza_id',
    ];

}