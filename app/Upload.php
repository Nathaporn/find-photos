<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    //
    protected $table = 'upload';

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
       return $this->hasOne('App\User');
    }
}
