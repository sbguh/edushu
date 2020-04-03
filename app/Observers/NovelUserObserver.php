<?php

namespace App\Observers;
use App\Events\NovelUserCreatedEvent;
use App\Events\NovelUserDeletedEvent;
use App\Events\NovelUserCreatingEvent;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NoveUserObserver extends Pivot
{
    //
    protected $dispatchesEvents = [
      'creating' => NovelUserCreatingEvent::class,
      'created' => NovelUserCreatedEvent::class,
      'deleted' => NovelUserDeletedEvent::class,

    ];



}
