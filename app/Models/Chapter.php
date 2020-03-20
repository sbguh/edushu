<?php

namespace App\Models;

use App\Events\ChapterAudioEvent;

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

    protected $dispatchesEvents = [
       //'saved' => ChapterAudioEvent::class,
       //'updated' => ChapterAudioEvent::class,
   ];


    protected $fillable = ['title','url','content', 'book_id', 'extras','images','sort','state','read_count','word_count','word_count','audio','video'];


    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'book_id');
    }

    public function setAudioAttribute($value)
        {
            $attribute_name = "audio";
            $disk = "edushu";
            $destination_path = "books/audio";

            $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
        }

   public function setVideoAttribute($value)
            {
                $attribute_name = "video";
                $disk = "edushu";
                $destination_path = "books/video";

                $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

            // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
            }

     public function audios()
         {
             return $this->hasOne('App\Models\ChapterAudio','chapter_id');
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
