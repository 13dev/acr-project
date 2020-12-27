<?php

use App\Http\Song\Actions\StreamAction;

Route::get('/stream/{song}', StreamAction::class);

Route::get('/songs', [SongController::class, 'index']);
Route::get('/songs/recently-added', [RecentlyAddedController::class, 'index']);
