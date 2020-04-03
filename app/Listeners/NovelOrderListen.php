<?php

namespace App\Listeners;

use App\Events\NovelUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use App\Events\NovelUserCreatedEvent;

class NovelOrderListen
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NovelUserEvent $event)
    {
        //
        //  \Log::info("1111111111");
        $novelUser = $event->getNovelUser();
    }

    /**
     * Handle the event.
     *
     * @param  NovelUser  $event
     * @return void
     */
    public function handle(NovelUserEvent $event)
    {
        //
    }
}
