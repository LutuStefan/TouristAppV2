<?php

namespace App\Http\Controllers;


class AccommodationController extends Controller
{
    public function addAccommodation()
    {
        return view('accommodation.create-accommodation');
    }
}
