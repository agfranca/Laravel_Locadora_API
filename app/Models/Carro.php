<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $fillable=['modelo_id','placa','disponivel','km'];

    //Relacionamento com a Modelo
    public function modelo(){
        return $this->belongsTo(Modelo::class);
    } 

    //Relacionamento com Locacao
    public function locacao(){
        return $this->hasMany(Locacao::class);
    } 
}
