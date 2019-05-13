<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libro_usuario extends Model
{
    protected $guarded = [];
    public function users(){
        return $this->belongsTo('\App\User','user_id');

    }
    public function libros(){
        return $this->belongsTo('\App\Libro','libro_id');

    }
}
