<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $guarded = [];
    const DISPONIBLE = 'disponible';
    const PRESTADO = 'prestado';

    
}
