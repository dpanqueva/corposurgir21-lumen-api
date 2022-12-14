<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryDetail;

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
    ];

    public function categoryDetail(){
      return $this->hasMany(CategoryDetail::class,'categoria_id','categoria_id');
    }
}
