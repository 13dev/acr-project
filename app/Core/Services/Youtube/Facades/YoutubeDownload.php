<?php


namespace App\Core\Services\Youtube\Facades;


use App\Core\Services\Youtube\YoutubeDownload as YoutubeDownloadConcrete;
use Illuminate\Support\Facades\Facade;

class YoutubeDownload extends Facade
{
    protected static function getFacadeAccessor()
    {
        return YoutubeDownloadConcrete::class;
    }
}
