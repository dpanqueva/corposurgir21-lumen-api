<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CategoryFeature extends Model{

    public $table = 'categoria_caracteristica';
    public $primaryKey='detalle_id';

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
        'categoria_id',
        'bln_cinta_noticia',
        'fe_fin_cinta'
    ];

    public function category(){
        return $this->belongsTo(Category::class,'categoria_id');
      }

}