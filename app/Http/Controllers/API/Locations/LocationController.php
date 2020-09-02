<?php

namespace App\Http\Controllers\API\Locations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Location\Location;
use App\Http\Requests\Location\SaveLocation;

class LocationController extends Controller
{
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function store(SaveLocation $request)
    {
        $event = new \App\Events\OnBeforeSaveLocationEvent($this->location, $request);
        event($event);
        
        if(empty($event->errors)) {
            $result = $this->location->store($request->validated(), collect($event->sources));
            \Cache::forever('hasNewLocation', true);
        }

        $data       = isset($result) ? $result : $event->errors;
        $statusCode = !empty($errors) ? 400 : 200;

        return response()->json($data, $statusCode);
    }
}
