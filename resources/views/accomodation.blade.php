@extends('layouts.app')
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>--}}
{{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"></head>--}}

{{--<link rel="stylesheet/less" type="text/css" href="styles.less" />--}}
{{--<script src="less.js" type="text/javascript"></script>--}}
@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="css/accomodation.css">
@endsection

@section('content')
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

        <!-- datepicker section -->
        <div class="acomodation-description">
            <div id="description-wraper">
                <h4>@lang('messages.accomodation-description')</h4>
                <p class="card-text">{{ $hotelData->h_description }}</p>
                <div class="order-button">
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#show-date-selector" role="button" aria-expanded="false" aria-controls="show-date-selector">@lang('messages.choose-a-date')</a>
                    </p>
                    <div class="row">
                        <div class="col">
                            <div class="collapse multi-collapse" id="show-date-selector">

                                <div style="padding-bottom: 25px; display: flex; justify-content: center">
                                    <input type="text" class="form-control daterange" placeholder="Select a date interval" name="daterange"/>
                                    <button type="button" id="order" class="btn btn-success" data-toggle="modal" data-target="#select-payment-method">@lang('messages.order-now')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($hotelData->location !== 'error')
                    <button type="button" id="maps" class="btn btn-primary" data-toggle="modal" data-target="#show-map">@lang('messages.show-map-pozition')</button>
                @endif

                <div class="booking-success">@lang('messages.booking-success')</div>
                <div class="booking-fail">@lang('messages.booking-fail')</div>
            </div>
        </div>

    </div>

    <!-- Modal for peyment-method -->
    <div class="modal fade" id="select-payment-method" tabindex="-1" role="dialog" aria-labelledby="select-payment-method" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('messages.choose-payment-method')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">@lang('messages.options')</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01">
                            <option value="1">@lang('messages.cash')</option>
                            <option value="2" disabled>@lang('messages.card')</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="confirm-reservation" class="btn btn-primary" data-dismiss="modal"
                            data-toggle="collapse" href="#show-date-selector" role="button" aria-expanded="false"
                            aria-controls="show-date-selector">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for google maps -->
    <div class="modal fade" id="show-map" tabindex="-1" role="dialog" aria-labelledby="show-map" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="maps-modal-title">@lang('messages.modal-map-title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="map"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var bookings = {!!  $hotelData->bookings !!};
        var locations = {!!  json_encode($hotelData) !!};
        locations = locations['location'];
        // console.log(locations);
    </script>
    <script>
        var map;
        function initMap() {
            var uluru = {lat: locations['lat'], lng: locations['lng']};
            map = new google.maps.Map(document.getElementById('map'), {
                center: uluru,
                zoom: 8
            });
            var marker = new google.maps.Marker({position: uluru, map: map});
        }
    </script>

    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
    <input type="hidden" id="userID" value="{{ auth()->user()->id }}">

    <script src="/js/accomodation.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8Kw2if1GnH4Eh7fQS8_4IvfdpbREWL0w&callback=initMap"
            type="text/javascript"></script>
@endsection
