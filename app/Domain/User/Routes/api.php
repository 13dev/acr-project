<?php


use App\Http\User\Actions\GetArtistAction;
use App\Http\User\Actions\ListArtistsAction;

Route::get('/artists', ListArtistsAction::class);
Route::get('/artists/{artist}', GetArtistAction::class);
