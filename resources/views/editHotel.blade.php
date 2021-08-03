@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="css/accomodation.css">
@endsection

@section('content')
    <style>
        .close-button {
            position: absolute;
            top: 5px;
            right: 5px;
            color: transparent;
        }

        .list-group-image {
            height: 100%;
            border-radius: 5px;
        }

        #add-image {
            width: 40px;
        }
    </style>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="image_outer_container">
                <div class="image_inner_container">
                    <h1>{{ $hotelData->h_name }}</h1>
                </div>
            </div>
        </div>

        <!-- Slider section -->
        <div class="d-flex justify-content-center info-section">
            <div id="carouselExampleIndicators" class="carousel " data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach($hotelData->images as $key => $img)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="@if($key == 0) active @endif"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach($hotelData->images as $key => $img)
                        <div class="carousel-item @if($key == 0) active @endif">
                            <img class="rounded img-fluid d-block img-slider" src="images/{{ $hotelData->h_id }}/{{ $img }}" alt="">
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <h4 style="margin-top: 25px;">@lang('messages.accomodation-description')</h4>

        <form method="POST" action="{{ route('edit-accommodation-post') }}">
            @csrf

            <div class="form-group">
                <label for="hotel-name"></label>
                <input type="text" name="h_name" class="form-control" id="hotel-name" placeholder="{{ $hotelData->h_name ?? '' }}">
            </div>
            <div class="form-group">
                <label for="h_price">@lang('messages.price'):</label>
                <input type="number" name="h_price" class="form-control" id="hotel-price" placeholder="{{ $hotelData->h_price ?? '' }}">
            </div>
            <div class="form-group">
                <label for="h_description">@lang('messages.accomodation-description')</label>
                <textarea class="form-control" name="h_description" aria-label="With textarea" style="height: 150px;" placeholder="{{ $hotelData->h_description }}"></textarea>
            </div>
            <div class="form-group">
                <label for="h_stars">@lang('messages.select-rating')</label>
                <select class="form-control" id="stars-number" name="h_stars">
                    <option>{{ $hotelData->h_stars }}</option>
                    @for($i=1; $i<=5; $i++)
                        @if($i !== $hotelData->h_stars)
                            <option>{{ $i }}</option>
                        @endif
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label for="h_country">@lang('messages.country'):</label>
                <input type="text" name="h_country" class="form-control" id="hotel-country" placeholder="{{ $hotelData->h_country ?? '' }}">
            </div>
            <div class="form-group">
                <label for="h_city">@lang('messages.city'):</label>
                <input type="text" name="h_city" class="form-control" id="hotel-city" placeholder="{{ $hotelData->h_city ?? '' }}">
            </div>
            <div class="form-group">
                <label for="h_address">@lang('messages.address'):</label>
                <input type="text" name="h_address" class="form-control" id="hotel-address" placeholder="{{ $hotelData->h_address ?? '' }}">
            </div>
            <input type="hidden" name="hotel-id" value="{{ $hotelData->h_id }}">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- Edit images section -->
        <div class="row" style="position: relative">
            @foreach($hotelData->images as $key => $img)
                <div class="card" style="width: 18rem;">
                    <img src="images/{{ $hotelData->h_id }}/{{ $img }}" class="card-img-top list-group-image" alt="image is not available">
                    <button type="button" class="close close-button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
                <div>
                    <img id="add-image" src="images/add.svg" class="list-group-image" alt="image is not available">
                </div>
        </div>
    </div>

    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
    <input type="hidden" id="userID" value="{{ auth()->user()->id }}">

    <script src="/js/accomodation.js"></script>
    <script src="{{ asset('js/general.js') }}"></script>
@endsection
