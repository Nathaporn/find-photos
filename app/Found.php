<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Found extends Model
{
    //
    protected $table = 'found';

    protected $fillable = [
        'search_id','csv_path',
    ];
}
