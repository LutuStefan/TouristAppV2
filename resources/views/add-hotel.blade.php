@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <h2 class="card-header">@lang('messages.add-hotel')</h2>

                    <div class="card-body">
                        <form id="add-hotel-section" enctype="multipart/form-data" role="form">

                            <div id="hotel-name-and-description-section">
                                <input type="text" id="hotel-name" placeholder="@lang('messages.hotel-name')">
                                <textarea style="height: 50px;" type="text" id="hotel-description" placeholder="@lang('messages.hotel-description')"></textarea>
                                <div class="rating-container">
                                    <h5>@lang('messages.select-rating')</h5>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                                <input type="text" id="country" placeholder="@lang('messages.country')">
                                <input type="text" id="city" placeholder="@lang('messages.city')">
                                <input id="price" type="number" min="0" placeholder="@lang('messages.lei-pe-noapte')">
                                <input type="text" id="address" placeholder="@lang('messages.address')">
                                <div id="save-hotel">@lang('messages.add-hotel')</div>
                            </div>

                            <div id="add-pictore-section">
                                <h3 style="margin: 20px 0; align-self: flex-start;">@lang('messages.add-pictures-for-your-hotel')</h3>
                                <div>
                                    <input type="file" id="hotel-img">
                                    <label for="hotel-img">@lang('messages.select-the-image')</label>
                                    <div id="add-picture">@lang('messages.add-picture')</div>
                                </div>
                                <div id="added-images-section">
                                </div>
                            </div>

                            <div id="error-section">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/general.js') }}"></script>
@endsection
