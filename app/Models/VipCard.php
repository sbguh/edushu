<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\User;
class VipCard extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'vip_cards';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected $fillable = [
        'type_id',
        'user_id',
        'phone_number',
        'real_name',
        'birthday',
        'gender',
        'deposit',
        'balance'
    ];


    public function setPhoneNumberAttribute($value)
        {
            $attribute_name = "phone_number";
            /*
            $user =User::find($this->attributes['user_id']);
            if($user->check_subscribe){
              $app = app('wechat.official_account');
              $app->template_message->send([
                   'touser' => $user->openid,
                   'template_id' => 'AAK9uM9BkIG527QNQtU9H8UoS9ZO3BJMtjGHxpctpMA',
                   'data' => [
                       'first' => '您好，您的信息已绑定成功！',
                       'keyword1' => $this->attributes['real_name'],
                       'keyword2' => $user->name,
                       'keyword3' => $this->attributes['phone_number'],
                       'keyword4' => $this->attributes['created_at'],
                       'remark'=> "感谢您的使用"
                   ],
               ]);

            }
            */
            $this->attributes['phone_number'] = $value;
            //return $value;

            //die($value);

        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
        }


        public function setBalanceAttribute($value)
            {
                $attribute_name = "balance";
              //  $app = app('wechat.official_account');
              /*
              $user =User::find($this->attributes['user_id']);
              if($user->check_subscribe){
                if($value<5){
                //  dd("test");
                 $app = app('wechat.official_account');
                 $app->template_message->send([
                      'touser' => $user->openid,
                      'template_id' => 'SjypZ_bscJMdP0ri8rwftD3_K6KdEF9ZRCNbY9pf_zc',
                      'data' => [
                          'first' => '您的余额不足，请及时充值',
                          'keyword1' => $this->attributes['phone_number'],
                          'keyword2' => $value,
                          'remark'=> "若余额不足，将影响您的使用! 有问题及时联系客服"
                      ],
                  ]);

                }
              }
              */
              $this->attributes['balance'] = $value;

              //return $value;

                //die($value);

            // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
            }


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
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
