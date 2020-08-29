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
        return view('welcome', ['data' => $this->location->get([],['temperature'])]);
    }

    public function store(SaveLocation $request)
    {
        $errors = [];

        $wsRes = app('weatherstack')->init($request->validated())->request();
        
        if($wsRes->errors)
            $errors['ws'] = $wsRes->getErrors();

        $owmRes = app('openweathermap')->init($request->validated())->request();

        if($owmRes->errors)
            $errors['owm'] = $owmRes->getErrors();

        if(empty($errors)) {
            $location = $this->location->store($request->validated(), [$wsRes, $owmRes]);
            $request->session()->flash('success', true);
            $request->session()->flash('message', 'Your location temperature is ' . $location->temperature->temp);
        } else {
            $request->session()->flash('success', false);
            $request->session()->put(['store_location' => $errors]);
        }

        return redirect('/');
    }
}
