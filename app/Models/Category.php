<?php

namespace App\Models;

//use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
  //  use CrudTrait;
  //  use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'categories';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'slug','image','enable', 'parent_id'];
    // protected $hidden = [];
    // protected $dates = [];


    public function categoryable()
        {
            return $this->morphTo();
        }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
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

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }


    public function books()
      {
          return $this->belongsToMany('App\Models\Book', 'book_category');
      }

    public function hasManyChildren(){
        return $this->hasMany('App\Models\Category', "parent_id");
    }

    public function belongsToParent(){
    return $this->belongsTo("App\Models\Category", "parent_id");
}


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
                    ->orWhere('depth', null)
                    ->orderBy('lft', 'ASC');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->name;
    }

/*
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
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
