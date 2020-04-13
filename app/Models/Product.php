<?php

namespace App\Models;
//use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Spatie\Translatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
//use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\Relation;

class Product extends Model
{
    //use CrudTrait;
    //use Sluggable, SluggableScopeHelpers;
    //use HasTranslations;
  //  use HasTranslations;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
                    'name','sub_title','count', 'description', 'image', 'on_sale',
                    'rating', 'sold_count', 'review_count', 'price','details','features','images','image','category_id','extras','virtual'
    ];

    protected $table = 'products';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $casts = [
        'on_sale' => 'boolean', // on_sale 是一个布尔类型的字段
        'features'       => 'object',
        'extra_features' => 'object',
        'images'       => 'array',
        'virtual' => 'boolean',
    ];

    public $translatable = ['features', 'extras'];

    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }

    public function users()
    {



    }


/*
    public function getImageUrlAttribute()
        {

            // 如果 image 字段本身就已经是完整的 url 就直接返回
            if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])) {
                return $this->attributes['image'];
            }
            return \Storage::disk('edushu')->url($this->attributes['image']);
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

*/





public function tags()
{
    return $this->belongsToMany('App\Models\Tag', 'product_tag');
}

public function categories()
{
    return $this->morphToMany('App\Models\Category', 'categoryables');
}
public function favorites()
   {
      return $this->morphMany('App\Models\Favorite', 'favoriteable');
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
