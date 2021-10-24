<?php

namespace App\Http\Controllers;

use App\Hotels;
use App\Repositories\HotelRepository;
use App\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Http\Request as RequestInput;
use File;
use Illuminate\Support\Facades\App;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
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

    public function getUserProfile(Request $request)
    {
        $userId = $request->input('userId');
        $userData = $this->repository->getUserById($userId);

        if(!empty($userData->owner)) {
            $userHotels = $this->repository->getUserHotels($userId);
            $userData->hotels = $userHotels;
        }

        try {
            $userImage = User::getUserProfileImage($userId);
            $userData->userImage = $userImage;
        } catch (\Exception $e) {
            $userData->userImage = null;
        }

        return view('user-profile', compact('userData'));
    }


    public function uploadProfilePicture(Request $request)
    {
        $userId = $request->input('userId');
        $path = public_path('images/profile/');

        try {
            $folderPath = public_path('images/profile/' . $userId);
            mkdir($folderPath);
        } catch (\Exception $e) {

        }

        ini_set('memory_limit', '-1');
        $img = Image::make(app(RequestInput::class)->file('file'))->orientate();
        $img->resize(200, 250)->save($path. $userId .'/profile.jpg', 100);
        return 'images/profile/'. $userId .'/profile.jpg';
    }

    public function storeUserProfilePicture(Request $request)
    {
        $userId = $request->input('userId');
        $user = User::find($userId);

        ImageController::deleteImage('profileImage'. $userId . '.jpg');
        if (App::environment() === "local") {
            $path = ImageController::storeImageAs($request, 'image', 'profileImage'. $userId . '.jpg', 'public/images/profile/' . $userId);
            $image = ImageController::storeImagePathIntoDB($path, $user);
        } else {
            $path = ImageController::storeImageAs($request, 'image', 'profileImage'. $userId . '.jpg', 'public/images/profile/' . $userId, 's3');
            $image = ImageController::storeImagePathIntoDB($path, $user, 's3');
        }

        return $image->url;
    }

    public function updateUserData(Request $request)
    {
        $userData = $request->input();
        $status = $this->repository->updateUserData($userData);

        if($status === 'success') {
            $response= 'Datele au fost salvate cu succes!';
        } else {
            $response = 'A aparut o problema! Fiti siguri ca ati completat datele corect!';
        }
        return $response;
    }

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}
