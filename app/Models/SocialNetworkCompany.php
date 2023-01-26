<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetworkCompany extends Model{

    public $table = 'redes_sociales_empresa';
    public $primaryKey='red_social_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'red_social_id',
        'nombre',
        'url_red_social',
        'logo',
        'info_empresa_id'
    ];
}