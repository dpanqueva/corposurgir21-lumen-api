<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SocialNetworkCompany;

class CompanyInfo extends Model{

    public $table = 'informacion_empresa';
    public $primaryKey='info_empresa_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'info_empresa_id',
        'nombre_empresa',
        'direccion',
        'ciudad_pais',
        'numero_fijo',
        'numero_celular',
        'correo'
    ];

    public function caracteristicas(){
        return $this->hasMany(SocialNetworkCompany::class,'info_empresa_id','info_empresa_id');
      }
}