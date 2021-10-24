<?php

namespace App\Http\Controllers;

use App\Image;
use App\Repositories\HotelRepository;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use File;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentUser = $this->repository->currentUser();
        return view('home', compact('currentUser'));
    }

    public function addHotel()
    {
        $currentUser = $this->repository->currentUser();
        return view('add-hotel');
    }

    public function saveImage(Request $request)
    {
//      get Hotel ID
        $hotelId = $request->input('hotelId');

        /* Getting file name */
        $filename = $_FILES['file']['name'];

        $path = public_path('images/' . $hotelId . '/');
        if(!File::isDirectory($path)){

            File::makeDirectory($path, 0777, true, true);

        }

        /* Location */
        $location = $path .$filename;
        $uploadOk = 1;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);

        /* Valid Extensions */
        $valid_extensions = array("jpg","jpeg","png");
        /* Check file extension */
        if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
            $uploadOk = 0;
        }

        if($uploadOk == 0){
            echo 0;
        } else {
            /* Upload file */
            if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                echo $location;
            }else{
                echo 0;
            }
        }
    }

    public function saveHotelNameAndDescription(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),
            [
                'name' => 'max:50|required',
                'description' => 'max:300|required',
                'stars' => 'required',
                'city' => 'max:30|required',
                'country' => 'max:30|required',
                'address' => 'max:100|required',
                'price' => 'numeric|required',
            ]);
            if ($validator->fails()) {
                return view('accommodation.create-accommodation', ['validationErrors' => $validator->errors()]);
            }


            $hotelId = $this->hotelRepository->addHotel($request->input());
            return view('accommodation.accommodation-img', ['hotelId' => $hotelId]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getHomePage(Request $request)
    {
        $input = $request->input();
        if(count($input)) {
            $hotels = $this->hotelRepository->getHotelsFiltered($input);
        } else {
            $hotels = $this->hotelRepository->hotelsByStars();
        }

        foreach ($hotels as $hotel) {
            $hotel->images = Image::getAllImagesForOwner($hotel->h_id, 'App\Hotels');
        }
        return view('home', compact('hotels'));
    }
}
