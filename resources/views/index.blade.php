@extends('layout/main')

@section('content')
<div class="container mt-5 mb-3">
    <div class="jumbotron col-md-7 m-auto text-center mb-3">
        <div class="tab-content my-2">
            <div class="tab-pane active" id="country">
                <form method="GET" action="{{ url('search') }}" id="formCountry">
                    <div class="input-group">
                        <select class="form-control custom-select" name="countryCode" required>
                            <option value="" disabled selected>Choose country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="coordinate">
                <form method="GET" action="{{ url('search') }}" id="formCoordinate" autocomplete="off">
                    <input type="text" name="type" value="coordinate" hidden required>
                    <div class="input-group">
                        <input type="text" class="form-control" name="lat" placeholder="Latitude" required>
                        <input type="text" class="form-control" name="long" placeholder="Longitude" required>
                        <input type="number" class="form-control col-md-2" name="rad" min="1" placeholder="Radius" required>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <ul class="nav nav-pills" id="cartHeader">
            <li class="nav-item">
                <a class="nav-link text-center active" data-toggle="tab" href="#country">Country</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" data-toggle="tab" href="#coordinate">Coordinate</a>
            </li>
        </ul>
    </div>

    <div class="card-columns">
        @foreach($webcams as $webcam)
        <a href="{{ url('/webcam/'.$webcam->id) }}" class="card webcam-item mx-1 my-2">
            <img class="card-img-top" src="{{ $webcam->image->daylight->thumbnail ?? $webcam->image->current->thumbnail }}" alt="{{ $webcam->title }}">
            <div class="card-body px-2 py-2">
                <h5 class="card-title">{{ $webcam->title }}</h5>
                <p class="card-text text-muted">{{ $webcam->location->country }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
