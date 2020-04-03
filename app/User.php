<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Backpack\CRUD\app\Models\Traits\CrudTrait;
//use Spatie\Permission\Traits\HasRoles;
//use Laravel\Nova\Actions\Actionable; // 用于显示活动日志 Action Log

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\NovelUserEvent;

class User extends Authenticatable implements MustVerifyEmail
{
    use  Notifiable;
    use  SoftDeletes; //软删除
  //  use CrudTrait;
    //use HasRoles;
  //  use CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','extras','phonenumber','openid','check_subscribe','phone_number','description','wechat_description','card_id','real_name','birthday','gender','deposit','balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fakeColumns = [
        'extras',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'extras' => 'object',
        'birthday' => 'datetime',

    ];



    public function addresses()
    {
        return $this->hasMany("App\Models\UserAddress");
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany("App\Models\Product", 'user_favorite_products')
            ->withTimestamps()
            ->orderBy('user_favorite_products.created_at', 'desc');
    }

    public function favoriteBooks()
    {
        return $this->belongsToMany("App\Models\Book", 'user_favorite_book')
            ->withTimestamps()
            ->orderBy('user_favorite_book.created_at', 'desc');
    }

    public function lasturl()
    {
        return $this->hasOne('App\Models\UserLastUrl','user_id');
    }


    public function cartItems()
    {
        return $this->hasMany("App\Models\CartItem");
    }

    public function cartProducts()
    {
        return $this->hasMany("App\Models\CartProduct");
    }


    public function activies()
    {
        //return $this->hasMany("App\Models\Activity");
        return $this->belongsToMany('App\Models\Activity', 'activity_user');
    }


    public function vipcard()
    {
        return $this->hasOne('App\Models\VipCard','user_id');
    }


    public function logs()
    {
        return $this->hasMany('App\Models\UserLog','user_id');
    }

    public function orders()
    {
        return $this->hasMany("App\Models\Order");
    }

    public function order_items()
    {

        return $this->hasManyThrough(
            'App\Models\OrderItem',
            'App\Models\Order',

        );
    }

    public function novels()
    {
        return $this->belongsToMany('App\Models\Novel','novel_user')->withTimestamps()->withPivot(['note','created_at','updated_at'])->using('App\Models\NovelUser');
    }

    public function history_novels()
    {
        return $this->belongsToMany('App\Models\Novel','novel_user_history','user_id','novel_id')->withTimestamps()->withPivot(['type','created_at','updated_at'])->using('App\Models\NovelUserHistory');
    }




}
