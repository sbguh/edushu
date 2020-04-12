<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\RentCreatingEvent;
use App\Events\RentDeletedEvent;
use App\Events\RentCreatedEvent;
use Illuminate\Database\Eloquent\SoftDeletes;


class Rent extends Model
{
    //
    use  SoftDeletes; //软删除
    protected $table = 'rents';
    protected $fillable = [
        'rent_number',
        'novel_id',
        'user_id',
        'return_time',
        'fee',
        'note',
        'state',
        'return_at',
        'deleted_at'
    ];

    protected $casts = [
        'return_time'   => 'date',
        'return_at' => 'date',

    ];


    protected $dispatchesEvents = [
    //  'creating' => RentCreatingEvent::class,
      'created' =>  RentCreatedEvent::class,
      //'deleting' => RentDeletingEvent::class,
      'deleted' => RentDeletedEvent::class,


    ];

    public function novel()
    {
        return $this->belongsTo('App\Models\Novel', 'novel_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments()
      {
          return $this->morphMany('App\Models\Comment', 'commentable');
      }

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 no 字段为空
            if (!$model->rent_number) {
                // 调用 findAvailableNo 生成订单流水号
                $model->rent_number = static::findAvailableNo();
                // 如果生成失败，则终止创建订单
                if (!$model->rent_number) {
                    return false;
                }
            }
        });
    }

    public static function findAvailableNo()
    {
        // 订单流水号前缀
        $prefix = date('Ymd');
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            $no = $prefix.str_pad(random_int(0, 999999), 3, '0', STR_PAD_LEFT);
            // 判断是否已经存在
            if (!static::query()->where('rent_number', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find order no failed');

        return false;
    }


}
