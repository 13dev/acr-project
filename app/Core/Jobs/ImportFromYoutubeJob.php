<?php

namespace App\Core\Jobs;

use App\Core\Services\Youtube\Facades\YoutubeDownload;
use App\Core\Services\Youtube\YoutubeMetadata;
use App\Core\Services\Youtube\YoutubeObject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Imtigger\LaravelJobStatus\Trackable;

class ImportFromYoutubeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    private string $url;
    private ?YoutubeMetadata $musicDetails;
    private ?YoutubeObject $music;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url)
    {
        $this->prepareStatus();
        $this->url = $url;
        $this->musicDetails = null;
        $this->music = null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->setProgressMax(100);

        $this->musicDetails = YoutubeDownload::from($this->url)->getYoutubeMetadata();

        $this->music = YoutubeDownload::from($this->url)
            ->thumbnail(config('songs.thumbnail_path'), Str::random())
            ->download(config('songs.path'), null, function ($line) {
                $this->setProgressNow((int) $line->progress->percentage);
            });
    }
}
