<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
        html, body {
            height: 100vh;
        }
        .main {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            padding: 10px;
        }
        .results {
            padding: 10px;
            height: 300px;
            overflow-x: auto;
        }
        .alert-success,.alert-danger {
            position: fixed;
            top: 0;
            width: 100%;
        }
        </style>
    </head>
    <body>
        <div class="container main">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @elseif(!session('success') && \Session::has('store_location'))
            <div class="alert alert-danger">
                <ul>
                @foreach(session('store_location') as $locationErr)
                    <li> @if(isset( $locationErr['message'] ) ){{  $locationErr['message'] }} @endif</li>
                @endforeach
                </ul>
            </div>
            @php \Session::forget('store_location'); @endphp
            @endif
            <div class="form-container">
                <form method="POST" action="{{ url('/location') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">City</label>
                        <input type="text" class="form-control" name="city" aria-describedby="city" placeholder="ex. Berlin">
                        @if ($errors->has('city'))
                            <span class="text-danger">{{ $errors->first('city') }}</span>
                        @endif                    
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Country</label>
                        <input type="text" class="form-control" name="country" placeholder="ex. Germany">
                        @if ($errors->has('country'))
                            <span class="text-danger">{{ $errors->first('country') }}</span>
                        @endif   
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="results">
                @if(count($data) > 0)
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">City</th>
                        <th scope="col">Country</th>
                        <th scope="col">Temperature</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $location)
                        <tr>
                            <th scope="row">{{ $location->id }}</th>
                            <td>{{ $location->city }}</td>
                            <td>{{ $location->country }}</td>
                            <td>{{ $location->temperature->temp }} &#176;C</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-warning">
                    <strong>Sorry!</strong> No results found.
                </div> 
                @endif
            </div>
        </div>
    </body>
</html>
