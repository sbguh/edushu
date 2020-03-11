<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use CrudTrait;
    use HasRoles;
    use CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','extras','phonenumber','openid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'extras' => 'object',
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


    public function cartItems()
    {
        return $this->hasMany("App\Models\CartItem");
    }


}
