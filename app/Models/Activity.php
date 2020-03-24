<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use CrudTrait;

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

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'extras'
    ];


    public function users()
      {
          return $this->belongsToMany('App\User', 'activity_user');
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
              $result = $app->qrcode->temporary($value, 6 * 24 * 3600);

              $url = $app->qrcode->url($result['ticket']);

               $content = file_get_contents($url); // 得到二进制图片内容
               file_put_contents(base_path(). '/public/uploads/images/qrcode/'.$result['ticket'].'.jpg', $content);

               $this->attributes['image'] = base_path(). '/public/uploads/images/qrcode/'.$result['ticket'].'.jpg';


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
