<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AllianceImage extends Model{

    public $table = 'imagen_alianza';
    public $primaryKey='imagen_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombre',
        'ruta_imagen',
        'detalle_alianza_id',
    ];


}