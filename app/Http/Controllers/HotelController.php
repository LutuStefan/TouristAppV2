<?php

namespace App\Http\Controllers;

use App\Repositories\HotelRepository;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use File;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repository;
    protected $hotelRepository;

    public function __construct(Repository $repository, HotelRepository $hotelRepository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
        $this->hotelRepository = $hotelRepository;
    }

    public function viewHotel(Request $request)
    {
        if(!empty($request->input('hotel'))) {
            $hotelId = $request->input('hotel');
        }

        $hotelData = $this->hotelRepository->getHotelInfo($hotelId);
        $hotelData->bookings = $this->hotelRepository->getBookedDatesForHotel($hotelId);
        $listOfImages = [];

        $paths = public_path('images/' . $hotelId . '/');
        $filesInFolder = \File::files($paths);
        foreach ($filesInFolder as $file) {
            $fileName = pathinfo($file)['basename'];
            array_push($listOfImages, $fileName);
        }


        $hotelData->images = $listOfImages;

        try {
            $aa = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $hotelData->h_city . '&key=AIzaSyA8Kw2if1GnH4Eh7fQS8_4IvfdpbREWL0w';
            $aaa = ['address' => 'Bucuresti', 'key' => 'AIzaSyA8Kw2if1GnH4Eh7fQS8_4IvfdpbREWL0w'];
            $jsonData = CallAPI('POST', $aa, $aaa);
            $hotelData->location = json_decode($jsonData)->results[0]->geometry->location;
        } catch (\Exception $e) {
            $hotelData->location = 'error';
        }

        return view('accomodation', compact('hotelData'));
    }

    public function makeBooking(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $bookings = $this->hotelRepository->getBookedDatesForHotel($request->input('hotelId'));
        foreach ($bookings as $booking) {
            if($booking->b_start_date <= $start && $booking->b_end_date >= $start) {
                return 'error';
            }
            if($booking->b_start_date <= $end && $booking->b_end_date >= $end) {
                return 'error';
            }
            if($booking->b_start_date >= $start && $booking->b_end_date <= $end) {
                return 'error';
            }
        }

        return $this->hotelRepository->makeBooking($request->input());
    }

    public function editHotelPage(Request $request)
    {
        if(!empty($request->input('hotel'))) {
            $hotelId = $request->input('hotel');
        }

        $hotelData = $this->hotelRepository->getHotelInfo($hotelId);
        $hotelData->bookings = $this->hotelRepository->getBookedDatesForHotel($hotelId);
        $listOfImages = [];

        $paths = public_path('images/' . $hotelId . '/');
        $filesInFolder = \File::files($paths);
        foreach ($filesInFolder as $file) {
            $fileName = pathinfo($file)['basename'];
            array_push($listOfImages, $fileName);
        }


        $hotelData->images = $listOfImages;

        return view('editHotel', compact('hotelData'));
    }

    public function saveHotelDerailsOnEdit(Request $request)
    {
        $updatedStatus = $this->hotelRepository->editHotel($request->input());
        if($updatedStatus === true) {
            return redirect()->back();
        }
    }
}

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
