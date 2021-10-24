@extends('layouts.app')

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="css/accomodation.css">
@endsection

@section('content')
    <link rel="stylesheet" href="css/home.css">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div id="search-section" class="card-header">

                    <h3>@lang('messages.search-hotel')</h3>
                    <div>
                        <div class="input-group mb-3">
                            <input id="filter-by-name" type="text" class="form-control" placeholder="@lang('messages.name-or-address')" aria-label="@lang('messages.name-or-address')" aria-describedby="basic-addon1">
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control daterange" placeholder="Select a date interval" name="daterange"/>
                        </div>

                        <div class="input-group mb-3">
                            <input id="filter-by-price" type="number" min="0" class="form-control" placeholder="@lang('messages.lei-pe-noapte')" aria-label="@lang('messages.name-or-address')" aria-describedby="basic-addon1">
                        </div>

                        <div class="input-group mb-3">
                            <div style="display: inline-block;">Filtreaza dupa Numarul de stele:</div>
                            <div class="rating-container filter-rating-container" style="display: inline-block;">
                                <span class="fa fa-star sort-by-rating"></span>
                                <span class="fa fa-star sort-by-rating"></span>
                                <span class="fa fa-star sort-by-rating"></span>
                                <span class="fa fa-star sort-by-rating"></span>
                                <span class="fa fa-star sort-by-rating"></span>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="filter" class="btn btn-success" data-toggle="modal" data-target="#select-payment-method">@lang('messages.search')</button>

                </div>
                <div>
                    <h2 class="card-header">@lang('messages.most-appriciated-hotels')</h2>
                    @if(!empty($hotels))
                        @foreach($hotels as $hotel)
                            <div class="hotel-element">
                                @foreach($hotel->images as $img)
                                    <img class="card-img-top" src="{{ $img->url }}" alt="asdas">
                                    @break
                                @endforeach
                                <div class="card-body">
                                    <h5 class="card-title">{{ $hotel->h_name }}</h5>
                                    <span>{{ $hotel->h_price }} Lei/Noapte</span>
                                    @if(!empty($hotel->h_stars))
                                        <div class="rating-container">
                                            @for($i=0; $i<intval($hotel->h_stars); $i++)
                                                <span class="fa fa-star checked"></span>
                                            @endfor
                                        </div>
                                    @endif
                                    <p class="card-text">{{ $hotel->h_description }}</p>
                                    <a href="/accomodation?hotel={{ $hotel->h_id }}" class="btn btn-primary">@lang('messages.learn-more')</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="/js/home.js"></script>
@endsection
