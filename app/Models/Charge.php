<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

use App\Events\ChargeCreateEvent;

class Charge extends Model
{
    //

    protected $fillable = [
                    'charge_number', 'user_id', 'amount', 'remark','type'
    ];

    protected $table = 'charges';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];


    protected $dispatchesEvents = [
       'created' => ChargeCreateEvent::class,

   ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setAmountAttribute($value)
    {

      $this->attributes['amount'] = $value;
      //\Log::info("this user:".$this->user);
      if($this->user){
        $this->user->balance +=$value;
        $this->user->save();

      }

    }

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 no 字段为空
            if (!$model->charge_number) {
                // 调用 findAvailableNo 生成订单流水号
                $model->charge_number = static::findAvailableNo();
                // 如果生成失败，则终止创建订单
                if (!$model->charge_number) {
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
            $no = 'pay'.$prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            // 判断是否已经存在
            if (!static::query()->where('charge_number', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find order no failed');

        return false;
    }


}
