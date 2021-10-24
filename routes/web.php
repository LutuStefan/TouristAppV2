<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@getHomePage');

Auth::routes();

Route::get('/home', 'HomeController@getHomePage')->name('home');
Route::get('/add-hotel', 'HomeController@addHotel');
Route::get('/profile', 'UserController@getUserProfile');
Route::get('accomodation', 'HotelController@viewHotel');
Route::get('/edit-accommodation', 'HotelController@editHotelPage');

//Route::post('/save-image', 'HomeController@saveImage');
Route::post('/save-image', 'ImageController@storeHotelImage');
Route::post('save-hotel', 'HomeController@saveHotelNameAndDescription');
//Route::post('/save-profile-picture', 'UserController@uploadProfilePicture');
Route::post('/save-profile-picture', 'UserController@storeUserProfilePicture');
Route::post('/update-user-data', 'UserController@updateUserData');
Route::post('make-booking', 'HotelController@makeBooking');
Route::post('/edit-accommodation' , 'HotelController@saveHotelDerailsOnEdit')->name('edit-accommodation-post');
Route::get('/health-check', 'HomeController@getHomePage');

Route::get('/img', 'ImageController@create');
Route::post('/img', 'ImageController@store');
Route::get('/img/{image}', 'ImageController@show');

Route::get('/create-accommodation', 'AccommodationController@addAccommodation');
Route::post('/accommodation-store-img', 'ImageController@storeHotelImage');

