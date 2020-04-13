<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
    protected $table = 'favorites';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'favoriteable_id',
        'favoriteable_type'
    ];

    public $casts = [
        'enable' => 'boolean',
    ];

    public function favoriteable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


}
