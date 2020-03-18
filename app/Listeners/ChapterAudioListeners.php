<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\ChapterAudioEvent;

class ChapterAudioListeners
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ChapterAudioEvent $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}
