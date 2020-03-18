<?php

namespace App\Listeners;
use App\Models\Book;
use App\Models\BookAudio as BookAudioModel;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\BookAudio as BookAudioEvents;

class BookAudio
{
    /**
     * Create the event listener.
     *
     * @return void
     */
     public $book;
    public function __construct(BookAudioEvents $event)
    {
        //
        //dd($event->book);

        //die("test");

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
