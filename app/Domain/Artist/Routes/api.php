<?php


use App\Http\Artist\Actions\GetArtistAction;
use App\Http\Artist\Actions\ListArtistsAction;

Route::get('/artists', ListArtistsAction::class);
Route::get('/artists/{artist}', GetArtistAction::class);
