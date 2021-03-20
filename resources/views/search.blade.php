@extends('layout/main')

@section('content')
<div class="mt-5"></div>

<div class="container">
    <div>
        <form method="GET" class="row">
            <div class="col-md-5 my-1">
                <select class="form-control" name="countryCode">
                    <option value="all" selected>Select country</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ Request::get('countryCode') === $country->id ? 'selected' : ' ' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 my-1 w-100">
                <select class="form-control mul-select" name="categories[]" multiple>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ Request::has('categories') ? ( in_array($category->id, Request::get('categories')) ? 'selected' : ' ' ) : ' ' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 my-1">
                <select class="form-control" name="sort">
                    <option value="none">Select order by</option>
                    @foreach($orderBy as $sort)
                    <option value="{{ $sort }}" {{ Request::get('sort') === $sort ? 'selected' : ' ' }}>{{ ucfirst($sort) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 my-1">
                <button class="btn btn-primary w-100" type="submit">Search</button>
            </div>
        </form>
    </div>

    <div>
        @if(count($webcams) > 0)
            @foreach($webcams as $webcam)
            <div class="card webcam-item-se my-1">
                <a href="{{ url('/webcam/'.$webcam->id) }}" class="row no-gutters">
                    <div class="col-md-3">
                        <img class="card-img-top" src="{{ $webcam->image->daylight->thumbnail ?? $webcam->image->current->thumbnail }}" alt="{{ $webcam->title }}">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body px-2 py-2">
                            <h5 class="card-title">{{ $webcam->title }}</h5>
                            <p class="card-text">{{ $webcam->location->region ?? '-' }}, {{ $webcam->location->country }}</p>
                            <p class="card-text text-muted">Last updated {{ floor( (time()-$webcam->image->update)/60 ) }} mins ago</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        @else
            Not Available
        @endif
    </div>

    <button class="rounded-circle border-0" onclick="goToTop()" id="btnTop" title="Go to top">&uarr;</button>
</div>

<script>
    $(document).ready(function(){
        $(".mul-select").select2({
            placeholder: "Select category",
            tags: true,
            tokenSeparators: ['/',',',';'," "] 
        });
    });

    window.onscroll = function() {scroll()};
    function scroll() {
        if(document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
            btnTop.style.display = "block";
        }
        else {
            btnTop.style.display = "none";
        }
    }

    let btnTop = document.getElementById("btnTop");
    function goToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
@endsection
