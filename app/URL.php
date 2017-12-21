<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class URL extends Model
{
    //
    protected $table = 'urls';

    protected $fillable = [
        'url','csv',
    ];

    public function searches()
    {
       return $this->hasMany('App\Search');
    }
}
