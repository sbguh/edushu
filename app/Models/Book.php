<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public $casts = [
        'features'       => 'object',
        'details'       => 'object',
        'extras' => 'object',
        'images'       => 'array',
    ];

    protected $table = 'books';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['name','slug','barcode','audio','video','sold_count','review_count','stock','on_sale','author','press','press_date','price', 'description', 'details', 'features', 'category_id', 'extras','images','image','sort','state','read_count','last_chapter','word_count'];

    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    public function category()
    {
        return $this->belongsTo('Backpack\NewsCRUD\app\Models\Category', 'category_id');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }



    public function setImagesAttribute($value)
    {
        $attribute_name = "images";
        $disk = "public";
        $destination_path = "images/products";

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }


    public function setImageAttribute($value)
        {
            $attribute_name = "image";
            $disk = config('backpack.base.root_disk_name'); // or use your own disk, defined in config/filesystems.php
            $destination_path = "public/uploads/images/products"; // path relative to the disk above

            // if the image was erased
            if ($value==null) {
                // delete the image from disk
                \Storage::disk($disk)->delete($this->{$attribute_name});

                // set null in the database column
                $this->attributes[$attribute_name] = null;
            }

            // if a base64 was sent, store it in the db
            if (starts_with($value, 'data:image'))
            {
                // 0. Make the image
                $image = \Image::make($value)->encode('jpg', 90);
                // 1. Generate a filename.
                $filename = md5($value.time()).'.jpg';
                // 2. Store the image on disk.
                \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                // 3. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it from the root folder
            // that way, what gets saved in the database is the user-accesible URL
                $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
                $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
            }
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

    public function chapters()
    {
        return $this->hasMany('App\Models\Chapter');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'book_id');
    }



    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'book_tag');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'book_category');
    }

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
