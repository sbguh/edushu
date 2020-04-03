<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    //
    protected $table = 'user_logs';

    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected $fillable = [
        'user_id',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    

}
