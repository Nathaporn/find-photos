<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    //
    protected $table = 'targets';

    protected $fillable = [
        'photo','name','gender',
    ];

    public function search()
    {
       return $this->hasOne('App\Search');
    }
}
