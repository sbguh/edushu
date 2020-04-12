<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassRoom extends Model
{
    //
    use  SoftDeletes;
    protected $table = 'classrooms';
    protected $fillable = [
        'name',
        'teacher',
        'image',
        'media_id',
        'image_group',
        'detail',
        'description',
        'begain_time',
        'start_time',
        'address',
        'hours',
        'extras'
    ];

    protected $casts = [
        'delivery'    => 'boolean',
        'public'  => 'boolean',
        'extras'     => 'json',
    ];

    public function reports()
    {
        return $this->hasMany('App\Models\Reports');
    }


    public function users()
      {
          return $this->hasMany('App\Models\UserClassRoom','classroom_id');
      }

      public function comments()
        {
            return $this->morphMany('App\Models\Comment', 'commentable');
        }

      public function setMediaIdAttribute($value)
      {

        $attribute_name = "media_id";

        if($this->mediaid){
          $this->attributes['media_id'] =$this->mediaid;
        }else{
          $this->attributes['media_id'] = $value;
        }

      }

      public function setImageGroupAttribute($value)
          {
              $attribute_name = "image_group";
              $disk = config('backpack.base.root_disk_name'); // or use your own disk, defined in config/filesystems.php
              $destination_path = "public/uploads/images"; // path relative to the disk above

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

                  //dd($destination_path);
                  // 3. Save the public path to the database
              // but first, remove "public/" from the path, since we're pointing to it from the root folder
              // that way, what gets saved in the database is the user-accesible URL
                  $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
                  $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;

                  $app = app('wechat.official_account');
                  $material_result = $app->material->uploadImage(base_path(). '/public/'.$this->attributes[$attribute_name]);

                  $this->attributes['media_id'] =  $material_result['media_id'];

                  //dd($this->attributes['media_id']);

                  $this->mediaid =  $material_result['media_id'];
              }
          }


      public function setDescriptionAttribute($value)
          {
            $attribute_name = "description";
            $value = str_replace(array("<p>","</p>"),"",$value);
            $this->attributes['description'] = $value;
            $app = app('wechat.official_account');
          //  dd($this->attributes['image']);
              if( $value ){
                $id =   $this->attributes['id'];
                if($this->users()->count()){
                  $users = $this->users()->get();
                  foreach($users as $user){
                    //dd($user->name);

                    $app->customer_service->message($value)->to($user->openid)->send();

                  }
                }

              }

          }






}
