<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Location\Location;
use App\Http\Requests\Location\SaveLocation;

class LocationController extends Controller
{
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function fetch()
    {
        return view('welcome', ['data' => $this->location->get([], ['temperature']) ]);
    }

    public function store(SaveLocation $request)
    {
        $event = new \App\Events\OnBeforeSaveLocationEvent($this->location, $request);
        event($event);

        if(empty($event->errors)) {
            $location = $this->location->store($request->validated(), collect($event->sources));
            $request->session()->flash('success', true);
            $request->session()->flash('message', 'Your location temperature is ' . $location->temperature->temp);
            \Cache::forever('hasNewLocation', true);
        } else {
            $request->session()->flash('success', false);
            $request->session()->put(['store_location' => $event->errors]);
        }

        return redirect('/');
    }
}
