<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable=['nome','imagem'];

         //Relacionamento com a Modelo
         public function modelos(){
            return $this->hasMany(Modelo::class);
        } 

}
