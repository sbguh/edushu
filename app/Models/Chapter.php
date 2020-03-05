<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'chapters';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    public $casts = [
        'details'       => 'object',
        'extras' => 'object',
    ];

    protected $fillable = ['title','url','content', 'book_id', 'extras','images','sort','state','read_count','word_count','word_count'];


    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'book_id');
    }

/*
    public function nextchapter()
    {
        return $this->belongsTo('App\Models\Book', 'book_id');
    }

    public function previouschapter()
    {
        return $this->belongsTo('App\Models\Book', 'book_id');
    }
*/

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
