<?php


namespace App\Http\Song\Actions;


use App\Core\Jobs\ImportFromYoutubeJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportYoutubeAction
{
    use DispatchesJobs;

    public function __invoke(Request $request)
    {
        $job = new ImportFromYoutubeJob($request->get('url'));
        $this->dispatch($job);

        return new JsonResource([
            'job_id' => $job->getJobStatusId(),
        ]);
    }
}
