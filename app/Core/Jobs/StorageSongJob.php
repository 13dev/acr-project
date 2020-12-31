<?php

namespace App\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Str;
use Storage;

class StorageSongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $file;

    /**
     * Create a new job instance.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = new File(storage_path('app/' . $this->file));
        $fileHandler = fopen($file->getPathname(), 'rb+');

        //Remove the filename from the path
        $storagePath = Str::replaceFirst($file->getFilename(), '', $this->file);

        if (Storage::disk('spaces')->putFileAs($storagePath, $file, $file->getFilename(), $fileHandler)) {
            fclose($fileHandler);
            FileFacade::delete($file->getPathname());
        }
    }

}
