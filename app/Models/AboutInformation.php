<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AboutInformation extends Model{

    public $table = 'quienes_somos';
    public $primaryKey='quienes_somos_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'quienes_somos_id',
		'titulo',
		'descripcion',
		'logo',
		'clase'
    ];

}