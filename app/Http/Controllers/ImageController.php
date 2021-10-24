<?php

namespace App\Http\Controllers;

use App\Hotels;
use App\Image;
use App\ImageMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use function Symfony\Component\Translation\t;

class ImageController extends Controller
{
    public function create()
    {
        return view('images.create');
    }

    public function store(Request $request)
    {
        if (App::environment() === "local") {
            $path = $this->storeImage($request, 'image', 'images');
            $image = $this->storeImagePathIntoDB($path);
        } else {
            $path = $this->storeImage($request, 'image', 'images', 's3');
            $image = $this->storeImagePathIntoDB($path, 's3');
        }

//        $path = $request->file('image')->store('images', 's3');

//        Storage::disk('s3')->setVisibility($path, 'public');
//        $image = Image::create([
//            'filename' => basename($path),
//            'url' => Storage::disk('s3')->url($path)
//        ]);

        return $image;
    }

    public function storeHotelImage(Request $request)
    {
        $accommodationId = $request->input('hotelId');
        $accommodation = Hotels::find($accommodationId);
        if (App::environment() === "local") {
            $path = $this->storeImage($request, 'image', 'public/images/' . $accommodationId);
            $this->storeImagePathIntoDB($path, $accommodation);
        } else {
            $path = $this->storeImage($request, 'image', 'images/' . $accommodationId, 's3');
            $this->storeImagePathIntoDB($path, $accommodation, 's3');
        }

        $images = Image::getAllImagesForOwner($accommodationId, get_class($accommodation));

        return view('accommodation.accommodation-img', ['hotelId' => $accommodationId, 'images' => $images]);
    }


    /**
     * @param Request $request
     * @param string $imageName
     * @param string|null $path
     * @param string|null $storeOption
     */
    public static function storeImage(Request $request, string $imageName, string $path = null, string $storeOption = null)
    {
        /** here we decide if we store the image into Aws S3 or in the local storage */
        if ($path && $storeOption) {
            return $request->file($imageName)->store($path, $storeOption);
        }

        return $request->file($imageName)->store($path);

    }

    /**
     * @param Request $request
     * @param string $imageInputName
     * @param string $imageName
     * @param string|null $path
     * @param string|null $storeOption
     * @return false|string
     */
    public static function storeImageAs(Request $request, string $imageInputName, string $imageName, string $path = null, string $storeOption = null)
    {
        /** here we decide if we store the image into Aws S3 or in the local storage */
        if ($path && $storeOption) {
            return $request->file($imageInputName)->storeAs($path, $imageName, $storeOption);
        }

        return $request->file($imageInputName)->storeAs($path, $imageName);
    }

    /**
     * @param string $path
     * @param Model $model
     * @param string|null $option
     * @return mixed
     */
    public static function storeImagePathIntoDB(string $path, Model $model, string $option = null)
    {
        $url = !empty($option) ? Storage::disk($option)->url($path) : Storage::disk()->url($path);

        $image = Image::create([
            'filename' => basename($path),
            'url' => $url
        ]);

        ImageMapper::create([
            'image_id' => $image->id,
            'owner_id' => $model->getKey(),
            'owner_type' => get_class($model)
        ]);

        return $image;
    }

    /**
     * @param Image $image
     * @return StreamedResponse
     */
    public function show(Image $image)
    {
        if (App::environment() === "local") {
            return Storage::disk()->response('images/' . $image->filename);
        }

        return Storage::disk('s3')->response('images/' . $image->filename);

    }

    /**
     * @param Image $image
     * @param string $hotelId
     * @param string|null $option
     * @return StreamedResponse
     */
    public function showAccommodationImage(Image $image, string $hotelId, string $option = null): StreamedResponse
    {
        return Storage::disk()->response('/images/' . $hotelId . '/' . $image->filename);
    }

    /**
     * @param string $imageName
     */
    public static function deleteImage(string $imageName)
    {
        try {
            $images = Image::where('filename', $imageName)->get();

            foreach ($images as $image) {
                $imageMapper = ImageMapper::where('image_id', $image->id)->first();
                if ($imageMapper !== null) {
                    $imageMapper->delete();
                }
                $image->delete();
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

    }
}
