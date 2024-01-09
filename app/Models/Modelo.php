<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable=[
        'marca_id',
        'nome',
        'imagem',
        'numero_portas',
        'lugares',
        'air_bag',
        'abs'
    ];

     //Relacionamento com a Marca
     public function marca(){
        return $this->belongsTo(Marca::class);
    }    

    //Relacionamento com Carro
    public function carro(){
        return $this->hasMany(Carro::class);
    }    
}
