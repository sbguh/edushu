<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Events\ReportCreatedEvent;

class Report extends Model
{
    //
    use  SoftDeletes; //软删除
    protected $table = 'reports';
    protected $fillable = [
        'report_number',
        'title',
        'detail',
        'description',
        'userclassroom_id',
        'delivery',
        'public',
        'date_time',
        'teacher',
        'extras'
    ];

    protected $casts = [
        'delivery'    => 'boolean',
        'public'  => 'boolean',
        'extras'     => 'json',
    ];

    protected $dispatchesEvents = [

      'created' => ReportCreatedEvent::class,


    ];

    public function comments()
      {
          return $this->morphMany('App\Models\Comment', 'commentable');
      }
      

    public function userclassroom()
    {
        return $this->belongsTo('App\Models\UserClassRoom','userclassroom_id');
    }


    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 no 字段为空
            if (!$model->report_number) {
                // 调用 findAvailableNo 生成订单流水号
                $model->report_number = static::findAvailableNo();
                // 如果生成失败，则终止创建订单
                if (!$model->report_number) {
                    return false;
                }
            }
        });
    }


    public static function findAvailableNo()
    {
        // 订单流水号前缀
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            // 判断是否已经存在
            if (!static::query()->where('report_number', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find order no failed');

        return false;
    }


}
