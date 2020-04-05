<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['amount', 'price', 'rating', 'review', 'reviewed_at','order_id','product_id','product_sku_id'];
    protected $dates = ['reviewed_at'];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {

            // 如果模型的 no 字段为空
            if ($model->product_id==false) {
                // 调用 findAvailableNo 生成订单流水号
                $model->product_id = $model->productSku->product->id;

            }

        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class,'product_sku_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
