<?php

use App\Http\Search\Actions\GlobalSearchAction;
use App\Http\Song\Actions\ImportYoutubeAction;
use App\Http\Song\Actions\ImportYoutubeStatusAction;
use App\Http\Song\Actions\ListSongsAction;
use App\Http\Song\Actions\PlayedSongAction;
use App\Http\Song\Actions\RecentlyAddedAction;
use App\Http\Song\Actions\StreamAction;
use App\Http\Song\Actions\TopAlbumsAction;
use App\Http\Song\Actions\TopArtistsAction;
use App\Http\Song\Actions\TopSongsAction;

Route::get('/stream/{song}', StreamAction::class);

Route::get('/songs', ListSongsAction::class);
Route::get('/songs/recently-added', RecentlyAddedAction::class);

Route::get('/search/{query?}', GlobalSearchAction::class);

Route::get('/songs/played/{song}', PlayedSongAction::class);

Route::get('/songs/top-songs', TopSongsAction::class);
Route::get('/songs/top-albums', TopAlbumsAction::class);
Route::get('/songs/top-artists', TopArtistsAction::class);

Route::post('/songs/import-youtube', ImportYoutubeAction::class);
Route::get('/songs/import-youtube/{jobId}', ImportYoutubeStatusAction::class);
