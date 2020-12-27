<?php

use App\Http\Search\Actions\GlobalSearchAction;
use App\Http\Song\Actions\ListSongsAction;
use App\Http\Song\Actions\RecentlyAddedAction;
use App\Http\Song\Actions\StreamAction;

Route::get('/stream/{song}', StreamAction::class);

Route::get('/songs', ListSongsAction::class);
Route::get('/songs/recently-added', RecentlyAddedAction::class);

Route::get('/search/{query?}', GlobalSearchAction::class);
