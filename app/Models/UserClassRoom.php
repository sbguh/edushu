<?php

namespace App\Models;


use App\Events\UserClassRoomCreatedEvent;
use App\Events\UserClassRoomCreatingEvent;
use App\Events\UserClassRoomDeletingEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserClassRoom extends Model
{
    //
    use  SoftDeletes; //软删除
    protected $table = 'userclassrooms';

    protected $fillable = [
                    'classroom_id','user_id','hours','remark','deleted_at','created_at','updated_at'

                      ];


    protected $dispatchesEvents = [
      'creating' => UserClassRoomCreatingEvent::class,
      'created' => UserClassRoomCreatedEvent::class,
      'deleting' => UserClassRoomDeletingEvent::class,


    ];


    public function classroom()
    {
        return $this->belongsTo('App\Models\ClassRoom', 'classroom_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report','userclassroom_id');
    }


}
