<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryFeature;

class Category extends Model{

  public $table = 'categoria';
  public $primaryKey='categoria_id';

  public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombre',
        'codigo',
        'snactivo',
        'logo',
        'descripcion',
        'bln_cinta_noticia',
        'fe_fin_cinta'
    ];

    public function caracteristicas(){
      return $this->hasMany(CategoryFeature::class,'categoria_id','categoria_id');
    }
}
