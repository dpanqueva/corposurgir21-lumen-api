<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AllianceDetail;

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
        'descripcion',
        'ruta_imagen',
        'snactivo'
    ];

    public function allianceDetail(){
        return $this->hasMany(AllianceDetail::class,'alianza_id','alianza_id');
      }
}