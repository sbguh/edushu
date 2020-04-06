<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $table = 'reports';
    protected $fillable = [
        'report_number',
        'title',
        'detail',
        'description',
        'classroom_id',
        'user_id',
        'delivery',
        'public',
        'date_time',
        'extras'
    ];

    protected $casts = [
        'delivery'    => 'boolean',
        'public'  => 'boolean',
        'extras'     => 'json',
    ];

    public function classroom()
    {
        return $this->belongsTo('App\Models\ClassRoom', 'classroom_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }




}
