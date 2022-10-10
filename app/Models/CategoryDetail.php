<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CategoryDetail extends Model{

    public $table = 'detalle_categoria';
    public $primaryKey='detalle_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'detalle_id', 'nombre',
        'descripcion',
        'ruta_imagen',
        'categoria_id',
    ];

  

}
