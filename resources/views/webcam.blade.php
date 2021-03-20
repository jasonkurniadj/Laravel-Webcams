@extends('layout/main')

@section('content')
<div class="container mt-5 mb-3">
    @if($isOK)
    <div>
        <div class="row">
            <div class="col-md-5">
                <img src="{{ $webcam->image->current->preview }}" alt="{{ $webcam->title }}" width="100%">
            </div>
            <div class="col-md-7">
                <h3>{{ $webcam->title }}</h3>
                <small class="{{ $webcam->status === 'active' ? 'webcam-active' : 'webcam-inactive' }}">{{ ucfirst($webcam->status) }}</small>
                <small class="text-muted">Last updated {{ gmdate('Y-m-d H:i:s T', $webcam->image->update) }}</small>
                <div class="mt-4 webcam-info">
                    <table>
                        <tr>
                            <td>City</td>
                            <td>:</td>
                            <td>{{ $webcam->location->city }}</td>
                        </tr>
                        <tr>
                            <td>Region</td>
                            <td>:</td>
                            <td>{{ $webcam->location->region }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>:</td>
                            <td>{{ $webcam->location->country }}</td>
                        </tr>
                        <tr>
                            <td>Coordinate</td>
                            <td>:</td>
                            <td>
                                <a href="https://www.google.com/maps/{{ '@'.$webcam->location->latitude }},{{ $webcam->location->longitude }},17z" target="_blank">
                                    {{ $webcam->location->latitude }}, {{ $webcam->location->longitude }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-top">Category</td>
                            <td class="align-top">:</td>
                            <td>
                                @foreach($webcam->category as $category)
                                <a href="{{ url('search?categories%5B%5D='.$category->id) }}" class="btn btn-secondary btn-sm">{{ $category->name }}</a>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-2">
            <ul class="nav nav-pills flex-column" id="cartHeader">
                @foreach( array_keys(json_decode(json_encode($webcam->player, true), true)) as $idx=>$key )
                <li class="nav-item">
                    <a class="nav-link text-center {{ $idx === 1 ? 'active' : ' ' }}" data-toggle="tab" href="#{{ $key }}">{{ ucfirst($key) }}</a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-10 mt-1">
            <div class="tab-content webcam-player">
                @foreach( array_keys(json_decode(json_encode($webcam->player, true), true)) as $idx=>$key )
                <div class="tab-pane {{ $idx === 1 ? 'active' : ' ' }}" id="{{ $key }}">
                    @if($webcam->player->$key->available === true)
                    <embed type="video/webm" src="{{ $webcam->player->$key->embed }}">
                    @else
                    <div>
                        <i class="fa fa-times my-3" aria-hidden="true"></i>
                        <h3>Not Available</h3>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="text-center webcam-invalid">
        <i class="fa fa-ban my-3" aria-hidden="true"></i>
        <h3>Cannot find Webcam ID</h3>
        <small>{{ config('app.debug') ? $webcam : '' }}</small>
    </div>
    @endif
</div>
@endsection
