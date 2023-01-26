<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AllianceFeatures;

class Alliance extends Model{

    public $table = 'alianza';
    public $primaryKey='alianza_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'alianza_id',
		'nombre',
		'descripcion',
		'ruta_imagen',
		'snactivo',
		'pagina_web',
		'direccion',
		'barrio'
    ];

    public function caracteristicas(){
        return $this->hasMany(AllianceFeatures::class,'alianza_id','alianza_id');
      }
}