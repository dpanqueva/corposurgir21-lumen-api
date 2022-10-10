<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AllianceImage;


class AllianceDetail extends Model{

    public $table = 'detalle_alianza';
    public $primaryKey='detalle_alianza_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'descripcion_completa',
        'telefono',
        'correo',
        'direccion',
        'ciudad',
        'pagina',
        'alianza_id',
    ];
    public function allianceImage(){
        return $this->hasMany(AllianceImage::class,'detalle_alianza_id','detalle_alianza_id');
      }

}