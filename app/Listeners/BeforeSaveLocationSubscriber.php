<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BeforeSaveLocationSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
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

    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\OnBeforeSaveLocationEvent',
            'App\Listeners\BeforeSaveLocationSubscriber@getSources'
        );
    }

    public function getSources($event)
    {
        $event->sources->wsRes = app('weatherstack')->init($event->request->validated())->request();

        if($event->sources->wsRes->errors)
            $event->errors['ws'] = $event->sources->wsRes->getErrors();

        $event->sources->owmRes = app('openweathermap')->init($event->request->validated())->request();

        if($event->sources->owmRes->errors)
            $event->errors['owm'] = $event->sources->owmRes->getErrors();
    }
}
