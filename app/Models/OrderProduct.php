<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = ['amount', 'price', 'rating', 'review', 'reviewed_at','order_id','commentable_id','commentable_type'];
    protected $dates = ['reviewed_at'];
    public $timestamps = false;
    protected $table = 'order_products';



    public function OrderProductAble()
    {
        return $this->morphTo();
    }

    public function getProductAttribute()
    {
        return (new $this->commentable_type)::find($this->commentable_id);
    }

    public function getProductNameAttribute()
    {

      $product = (new $this->commentable_type)::find($this->commentable_id);
      if(isset($product->product->name)){
          return $product->product->name.":".(new $this->commentable_type)::find($this->commentable_id)->title;
      }else{
        return (new $this->commentable_type)::find($this->commentable_id)->title;
      }

    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
