<?php

namespace App\Models;

//use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Actionable;
use Illuminate\Notifications\Notifiable;
use App\Events\ActivityCreatedEvent;
use App\Events\ActivityUpdatedEvent;

class Activity extends Model
{
  //  use CrudTrait;
    use Actionable, Notifiable;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'activities';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    public $casts = [
        'extras' => 'object',
    ];

    public $mediaid="";

    protected $fillable = [
        'name',
        'slug',
        'image',
        'welcome_txt',
        'date_time',
        'address',
        'group_message',
        'description',
        'extras',
        'media_id',
        'image_group'

    ];

    protected $dispatchesEvents = [
    //  'creating' => RentCreatingEvent::class,
      'created' =>  ActivityCreatedEvent::class,
      'updated' => ActivityUpdatedEvent::class,


    ];



    public function users()
      {
          return $this->belongsToMany('App\User', 'activity_user');
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


      public function setGroupMessageAttribute($value)
          {
            $attribute_name = "group_message";
            $value = str_replace(array("<p>","</p>"),"",$value);
            $this->attributes['group_message'] = $value;
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




    public function setImageAttribute($value)
        {
          $attribute_name = "image";
          $this->attributes['image'] = $value;
        //  dd($this->attributes['image']);
            if( $value ==false){

              $app = app('wechat.official_account');
              $key = $this->attributes['slug'];
              //dd($key);
              $result = $app->qrcode->temporary($key, 6 * 24 * 3600);

              $url = $app->qrcode->url($result['ticket']);

               $content = file_get_contents($url); // 得到二进制图片内容
               file_put_contents(base_path(). '/public/uploads/images/qrcode/'.$result['ticket'].'.jpg', $content);

               $this->attributes['image'] = env('APP_URL').'/uploads/images/qrcode/'.$result['ticket'].'.jpg';


            }

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
