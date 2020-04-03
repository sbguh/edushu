<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Events\NovelUserCreatedEvent;
use App\Events\NovelUserDeletedEvent;
use App\Events\NovelUserCreatingEvent;


class NovelUser extends Pivot
{
    //
    protected $table = 'novel_user';

    protected $fillable = [
                    'novel_id','user_id', 'note'

                      ];


    protected $dispatchesEvents = [
      'creating' => NovelUserCreatingEvent::class,
      'created' => NovelUserCreatedEvent::class,
      'deleted' => NovelUserDeletedEvent::class,

    ];


}
