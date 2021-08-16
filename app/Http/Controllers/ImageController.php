<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function create()
    {
        return view('images.create');
    }

    public function store(Request $request)
    {
        $path = $request->file('image')->store('images', 's3');

//        Storage::disk('s3')->setVisibility($path, 'public');

        $image = Image::create([
            'filename' => basename($path),
            'url' => Storage::disk('s3')->url($path)
        ]);

        return $image;
    }

    public function show(Image $image)
    {
        return Storage::disk('s3')->response('images/' . $image->filename);
    }
}
