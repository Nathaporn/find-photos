<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    //
    protected $table = 'search';

    protected $fillable = [
        'user_id','target_id','url_id','result','feedback'
    ];

    public function user()
    {
       return $this->belongsTo('App\User');
    }

    public function target()
    {
        return $this->belongsTo('App\Target');
    }

    public function url()
    {
        return $this->belongsTo('App\URL');
    }
}
