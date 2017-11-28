<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    protected $table = 'persons';

    protected $fillable = [
        'name','age','gender',
    ];

    public function faces()
    {
       return $this->hasMany('App\Face');
    }
}
