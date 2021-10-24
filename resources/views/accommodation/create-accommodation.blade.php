@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <h2 class="card-header">@lang('messages.add-hotel')</h2>
                    <div class="card-body">
                        <form id="add-hotel-section" enctype="multipart/form-data" role="form"
                              action="{{ url('/save-hotel') }}" method="POST">
                            @csrf
                            <div id="hotel-name-and-description-section">
                                <input type="text" id="hotel-name" name="name"
                                       placeholder="@lang('messages.hotel-name')">
                                <textarea style="height: 50px;" name="description" type="text" id="hotel-description"
                                          placeholder="@lang('messages.hotel-description')"></textarea>
                                <div class="rating-container">
                                    <h5>@lang('messages.select-rating')</h5>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                                <input type="text" name="country" id="country" placeholder="@lang('messages.country')">
                                <input type="text" name="city" id="city" placeholder="@lang('messages.city')">
                                <input id="price" name="price" type="number" min="0"
                                       placeholder="@lang('messages.lei-pe-noapte')">
                                <input type="text" name="address" id="address" placeholder="@lang('messages.address')">
                                <input type="hidden" name="stars" id="stars">

                                <button type="submit" class="btn btn-primary">@lang('messages.add-hotel')</button>
                                <div id="error-section">
                                    @if(!empty($validationErrors))
                                        @foreach($validationErrors->getMessages() as $key => $error)
                                            <li>{{ ($error[0]) }}</li>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/add-accommodation.js') }}"></script>
@endsection
