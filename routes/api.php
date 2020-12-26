<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Album\AlbumController;
use App\Http\Search\SearchController;
use App\Http\Song\RecentlyAddedController;
use App\Http\Song\SongController;
use App\Http\Song\StreamController;
use App\Http\User\ArtistController;

Route::get('/stream/{song}', [StreamController::class, 'show']);

Route::get('/songs', [SongController::class, 'index']);
Route::get('/songs/recently-added', [RecentlyAddedController::class, 'index']);

Route::get('/artists', [ArtistController::class, 'index']);
Route::get('/artists/{artist}', [ArtistController::class, 'show']);

Route::get('/albums', [AlbumController::class, 'index']);
Route::get('/albums/{album}', [AlbumController::class, 'show']);

Route::get('/search/{query?}', [SearchController::class, 'index']);

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
