<?php

namespace App\Core\Console\Commands;

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
        ini_set('memory_limit', '200M');
        set_time_limit(0);

        $folder =  $this->argument('folder');

        $disk = Storage::disk('spaces');
        $files = Storage::allFiles($folder);

        $bar = $this->getOutput()->createProgressBar(count($files));

        $bar->start();
        $this->newLine();

        foreach ($files as $file) {
            $this->info(sprintf('Uploading [%s] to Digital Ocean...', $file));
            $this->newLine();

            $disk->put($file, file_get_contents(storage_path('app/'. $file)));

            $bar->advance();
            $this->newLine();
        }

        $bar->finish();
        $this->newLine();
        $this->comment('Done.');
        return 0;
    }
}
