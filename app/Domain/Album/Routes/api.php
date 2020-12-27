<?php

use App\Http\Album\Actions\GetAlbumAction;
use App\Http\Album\Actions\ListAlbumsAction;

Route::get('/albums', ListAlbumsAction::class);
Route::get('/albums/{album}', GetAlbumAction::class);
