<?php

namespace App\Core\Console\Commands;

use App\Core\Jobs\StorageSongJob;
use Artisan;
use Aws\S3\Transfer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Storage;

class UploadToSpacesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:spaces {folder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload Files in {folder} to Digital Ocean Spaces';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $folder = $this->argument('folder');

        $this->newLine();

        foreach (Storage::allFiles($folder) as $file) {
            $this->info(sprintf('Uploading "%s" to Digital Ocean...', $file));
            dispatch(new StorageSongJob($file));
        }

        $this->newLine();
        $this->comment('Done.');
        return 0;
    }
}
