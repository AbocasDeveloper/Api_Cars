<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    //Nombre de la tabla que va a utilizar en la BBDD
    protected $table = 'cars';

    //Relacion - de muchos a uno -
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
