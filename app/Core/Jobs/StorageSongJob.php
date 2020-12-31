<?php

namespace App\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File as FileFacade;
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
        $filePath = storage_path('app/' . $this->file);

        $fileHandler = fopen($filePath, 'rb+');
        if (Storage::disk('spaces')->putFile($this->file, new File($filePath), $fileHandler)) {
            //        flock($fileHandler,  LOCK_EX | LOCK_NB);
            //        ftruncate($fileHandler, 0);
            //        fclose($fileHandler);
            fclose($fileHandler);
            FileFacade::delete($filePath);
        }
    }

}
