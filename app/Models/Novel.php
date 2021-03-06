<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Rent;
class Novel extends BaseModel
{
    //
    use  SoftDeletes;

    protected $table = 'novels';
    protected $fillable = [
                    'title','sub_title','count', 'description', 'image', 'on_sale',
                    'rating', 'sold_count', 'review_count', 'price','rent_price','sale_price','thumbnail','image','stock','extras','barcode','audio','author','press','press_date','features','rent_count','deleted_at'
    ];
    protected $casts = [
        'on_sale' => 'boolean', // on_sale 是一个布尔类型的字段
        'extras' => 'object',
        'features'  => 'object',
    ];
/*
    public function getRentCountAttribute()
    {
        return $this->users()->count();
    }
*/

public function decreaseStock($amount)
{
    if ($amount < 0) {
        //throw new InternalException('减库存不可小于0');
    }

    return $this->where('id', $this->id)->where('stock', '>=', $amount)->decrement('stock', $amount);
}


public function getCurrentRentAttribute()
{
    $count = Rent::where('novel_id',$this->id)->where('state', '借阅中')->count();

    return $count;
}

    public function users()
      {
          return $this->belongsToMany('App\User', 'novel_user')->withPivot(['note','created_at','updated_at'])->withTimestamps()->using('App\Models\NovelUser');

      }


    public function rents()
        {
            return $this->hasMany('App\Models\Rent');
        }

        public function comments()
          {
              return $this->morphMany('App\Models\Comment', 'commentable');
          }

    public function favorites()
        {
             return $this->morphMany('App\Models\Favorite', 'favoriteable');
        }


          public function tags()
          {
              return $this->morphToMany('App\Models\Tag', 'taggable');
          }

          public function categories()
          {
              return $this->morphToMany('App\Models\Category', 'categoryables');
          }


}
