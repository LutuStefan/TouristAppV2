<?php

namespace App\Repositories;

use http\Env\Request;
use Illuminate\Support\Facades\DB;
use App\Hotels;
use App\Booking;

class HotelRepository implements HotelInterface
{
    public function addHotel($hotelFields)
    {
        $hotel = new Hotels();
        $hotel->h_name = $hotelFields['name'];
        $hotel->h_description = $hotelFields['description'];
        $hotel->h_admin = $user = auth()->user()->id;
        $hotel->h_stars = $hotelFields['stars'];
        $hotel->h_country = $hotelFields['country'];
        $hotel->h_city = $hotelFields['city'];
        $hotel->h_address = $hotelFields['address'];
        $hotel->h_price = $hotelFields['price'];
        $hotel->save();

        return $hotel->h_id;
    }

    public function editHotel($hotelFields)
    {
        try {
            $fieldsToUpdate = [];
            foreach ($hotelFields as $field => $value) {
                if (!empty($value) && $field != 'hotel-id' && $field != '_token') {
                    $fieldsToUpdate[$field] = $value;
                }
            }

            Hotels::where('h_id', $hotelFields['hotel-id'])
                ->update($fieldsToUpdate);
            return true;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function hotelsByStars()
    {
        $hotel = DB::table('hotels')
                ->orderBy( 'h_stars','desc')
                ->orderBy( 'created_at','desc')
                ->limit(5)
                ->get();
        return $hotel;
    }

    public function getHotelsFiltered($data)
    {
        $hotel = DB::table('hotels');

        if(!empty($data['nrOfStars'])) {
            $hotel->where('h_stars', $data['nrOfStars']);
        }

        if(!empty($data['price'])) {
            $hotel->where('h_price','<=' ,$data['price']);
        }

        if(!empty($data['nameOrAddress'])) {
            $hotel->where('h_name', 'like', '%'. $data['nameOrAddress']. '%')
                ->orWhere('h_address', 'like', '%'. $data['nameOrAddress']. '%');
        }

        $hotel = $hotel->get();

        $bookedHotels = [];
        $hotelByDate = DB::table('hotels')
            ->join('bookings', 'b_h_id', 'h_id')->get();

        if(!empty($data['start']) && !empty($data['end'])) {
            foreach ($hotelByDate as $key => $itemHotel) {
                if($itemHotel->b_start_date <= $data['start'] && $itemHotel->b_end_date >= $data['start']) {
                    if(!in_array($itemHotel->h_id, $bookedHotels)) {
                        array_push($bookedHotels, $itemHotel->h_id);
                    }
                }
                if($itemHotel->b_start_date <= $data['end'] && $itemHotel->b_end_date >= $data['end']) {
                    if(!in_array($itemHotel->h_id, $bookedHotels)) {
                        array_push($bookedHotels, $itemHotel->h_id);
                    }
                }
                if($itemHotel->b_start_date >= $data['start'] && $itemHotel->b_end_date <= $data['end']) {
                    if(!in_array($itemHotel->h_id, $bookedHotels)) {
                        array_push($bookedHotels, $itemHotel->h_id);
                    }
                }
            }

            foreach ($hotel as $key => $value) {
                foreach ($bookedHotels as $bValue) {
                    if( $value->h_id == $bValue ) {
                        unset($hotel[$key]);
                    }
                }
            }
        }

        return $hotel;
    }

    public function getHotelInfo($hotelId)
    {
        $hotel = DB::table('hotels')
            ->where('h_id', $hotelId)
            ->first();

        return $hotel;
    }

    public function makeBooking($data)
    {
        try {
            $booking = new Booking();
            $booking->b_u_id = $data['userId'];
            $booking->b_h_id = $data['hotelId'];
            $booking->b_start_date = $data['start'];
            $booking->b_end_date = $data['end'];
            $booking->save();
            return $booking->id;
        } catch (\Exception $e) {
            return 'error';
        }
    }

    public function getBookedDatesForHotel($hotelId)
    {
        try {
            $data = DB::table('bookings')
                ->select('b_id', 'b_start_date', 'b_end_date')
                ->where('b_h_id', $hotelId)
                ->get();

            return $data;
        } catch (\Exception $e) {
            return 'error';
        }
    }

}
