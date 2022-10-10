<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AllianceDetail;

class CentralImage extends Model{

    public $table = 'imagen_central';
    public $primaryKey='imagen_central_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombre',
        'ruta_imagen',
        'snactivo',
        'imagen_principal'
    ];

}