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
        $errors = [];

        $wsRes = app('weatherstack')->init($request->validated())->request();
        if($wsRes->errors)
            $errors['ws'] = $wsRes->getErrors();

        $owmRes = app('openweathermap')->init($request->validated())->request();
        if($owmRes->errors)
            $errors['owm'] = $owmRes->getErrors();

        if(empty($errors)) {
            $result = $this->location->store($request->validated(), [$wsRes, $owmRes]);
        }

        $data       = isset($result) ? $result : $errors;
        $statusCode = !empty($errors) ? 400 : 200;

        return response()->json($data, $statusCode);
    }
}
