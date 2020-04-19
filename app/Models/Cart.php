<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $table = 'carts';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'amount',
        'user_id',
        'commentable_id',
        'commentable_type'
    ];


    public function cartable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }



}
