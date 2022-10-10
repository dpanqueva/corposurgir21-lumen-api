<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'logo',
        'posicion',
        'informacion',
        'nombre',
        'snactivo'
    ];
}