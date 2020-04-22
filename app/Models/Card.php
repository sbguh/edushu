<?php

namespace App\Models;

//use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\CardCreatedEvent;
use App\Events\CardUpdatedEvent;

class Card extends Model
{
  //  use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    use  SoftDeletes; //软删除

    protected $table = 'cards';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected $fillable = [
        'type_id',
        'user_id',
        'card_number',
        'start_date',
        'end_date',
        'active',
        'enable',
        'duration',
        'deleted_at'

    ];

    protected $casts = [
        'active'  => 'boolean',
        'enable'  => 'boolean',
        'start_date'  => 'date',
        'end_date'  => 'date',
    ];

    protected $dispatchesEvents = [
    //  'creating' => RentCreatingEvent::class,
      'created' =>  CardCreatedEvent::class,
      'updated' => CardUpdatedEvent::class,


    ];

/*
    public function setEndDateAttribute($value)
             {
                 $attribute_name = "end_date";
                 $this->attributes['end_date'] = $value;

                 $this->attributes['duration'] = 0;

             // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
             }

*/
    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 no 字段为空
            if (!$model->card_number) {
                // 调用 findAvailableNo 生成订单流水号
                $model->card_number = static::findAvailableNo();
                // 如果生成失败，则终止创建订单
                if (!$model->card_number) {
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
            $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            // 判断是否已经存在
            if (!static::query()->where('card_number', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find order no failed');

        return false;
    }






    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }



}
