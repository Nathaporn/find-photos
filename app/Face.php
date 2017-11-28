<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Face extends Model
{
    //
    protected $table = 'faces';

    protected $fillable = [
        'photo','owner_id'
    ];

    public function owner()
    {
       return $this->belongsTo('App\Person');
    }
}
