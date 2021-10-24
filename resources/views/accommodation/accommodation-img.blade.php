@extends('layouts.app')
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
@section('content')
    <div class="card" style="margin-top: 30px; min-height: 25vh;">
        <div class="card-body">
            <div id="add-picture-section">
                <div class="max-w-lg mx-auto py-8">
                    <h3 style="margin: 20px 0; align-self: flex-start;">@lang('messages.add-pictures-for-your-hotel')</h3>
                    <form action="/accommodation-store-img" method="post"
                          class="flex items-center justify-between border border-gray-300 p-4 rounded"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="file" name="image" id="image">

                        <input type="hidden" name="hotelId" value="{{ $hotelId }}">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload File
                        </button>
                    </form>
                    <div id="added-images-section">
                        @if(!empty($images))
                            @foreach($images as $image)
                                <img src="{{ $image->url }}">
                            @endforeach
                        @endif
                    </div>
                    <button type="button"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <a href="{{ URL::route('home') }}" style="color: white" >Finish</a>
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
