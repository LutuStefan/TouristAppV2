<?php

namespace App\Http\Controllers;

use App\Repositories\HotelRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use File;
use Illuminate\Support\Facades\Storage;
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
            $paths = public_path('images/profile/' . $userId . '/');
            $filesInFolder = \File::files($paths);
            $file = pathinfo($filesInFolder[0]);
            $userData->profileImg = $file['filename']. '.jpg';
        } catch (\Exception $e) {
            $userData->profileImg = null;
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
        $img = Image::make(Input::file('file'))->orientate();
        $img->resize(200, 250)->save($path. $userId .'/profile.jpg', 100);
        return 'images/profile/'. $userId .'/profile.jpg';
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

//function correctImageOrientation($filename) {
//    if (function_exists('exif_read_data')) {
//        $exif = exif_read_data($filename);
//        if($exif && isset($exif['Orientation'])) {
//            $orientation = $exif['Orientation'];
//            if($orientation != 1){
//                $img = imagecreatefromjpeg($filename);
//                $deg = 0;
//                switch ($orientation) {
//                    case 3:
//                        $deg = 180;
//                        break;
//                    case 6:
//                        $deg = 270;
//                        break;
//                    case 8:
//                        $deg = 90;
//                        break;
//                }
//                if ($deg) {
//                    $img = imagerotate($img, $deg, 0);
//                }
//                // then rewrite the rotated image back to the disk as $filename
//                imagejpeg($img, $filename, 95);
//            } // if there is some rotation necessary
//        } // if have the exif orientation info
//    } // if function exists
//}
