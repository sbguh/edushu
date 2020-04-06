<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Events\UserClassRoomCreatedEvent;
use App\Events\UserClassRoomCreatingEvent;

class UserClassRoom extends Pivot
{
    //
    protected $table = 'classroom_user';

    protected $fillable = [
                    'classroom_id','user_id'

                      ];


    protected $dispatchesEvents = [
      'creating' => UserClassRoomCreatingEvent::class,
      'created' => UserClassRoomCreatedEvent::class,


    ];


}
