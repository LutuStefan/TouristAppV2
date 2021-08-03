@extends('layouts.app')
<link rel="stylesheet" href="css/user.css">
@section('content')
    <div class="container" style="background-color: #0070a226;padding: 50px; height: unset !important;">
        <div class="d-flex justify-content-center">
            <div class="image_outer_container">
                <div class="image_inner_container">
                    @if(!empty($userData->profileImg))
                        <img id="user-profile-picture" src="images/profile/{{ $userData->id }}/{{ $userData->profileImg }}">
                    @else
                        <img id="user-profile-picture" src="images/profile/generalProfilePictures/profile.jpg">
                    @endif
                    <input type="file" id="add-user-img-input">
                    <label for="add-user-img-input">
                        <img id="add-user-img" src="/open-iconic/svg/camera-slr.svg">
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center info-section">
            <div class="col-md-8">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="username-tag">@lang('messages.name')</span>
                    </div>
                    <input placeholder="@lang('messages.name')" id="username" value="{{ $userData->name }}" type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-8">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="email-tag">@lang('messages.email')</span>
                    </div>
                    <input  placeholder="@lang('messages.email')" id="email" value="{{ $userData->email }}" type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-8">
                <div class="input-group mb-3">
                    <div class="input-group-prepend input-group-name">
                        <span class="input-group-text" id="phone-tag">@lang('messages.phone')</span>
                    </div>
                    <input placeholder="@lang('messages.phone')" id="phone" value="{{ !empty($userData->phone) ? $userData->phone : ''}}" type="number" class="form-control">
                </div>
            </div>
            <button id="save-user-data" class="btn btn-primary" type="submit">Save</button>
            <input type="hidden" id="userId" value="{{ $userData->id }}">
            <div id="change-status" class="general-message">Datele au fost salvate cu succes!</div>
        </div>
        @if(!empty($userData->owner))
            <div style="margin: 15px 0;">
                <h2>@lang('messages.your-accomodations')</h2>
                <ul class="list-group">
                    @foreach($userData->hotels as $key => $hotel)
                        <div class="card-body" style="background-color: white;">
                            <h5 class="card-title">{{ $hotel->h_name }}</h5>
                            <p class="card-text">{{ $hotel->h_description }}</p>
                            <a href="{{ url('/edit-accommodation'). '?hotel='. $hotel->h_id }}" class="btn btn-primary">@lang('messages.edit-accommodation')</a>
                        </div>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <script src="/js/profile.js"></script>
@endsection
