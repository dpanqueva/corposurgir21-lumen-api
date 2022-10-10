<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model{

    public $table = 'menu';
    public $primaryKey='menu_id';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombre',
        'snactivo'
    ];

}