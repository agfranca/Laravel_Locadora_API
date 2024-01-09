<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
    ];

    //Relacionamento com Locacao
    public function locacao(){
        return $this->hasMany(Locacao::class);
    } 
}
