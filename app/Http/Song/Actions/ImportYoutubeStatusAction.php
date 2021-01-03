<?php


namespace App\Http\Song\Actions;

use Illuminate\Http\Resources\Json\JsonResource;
use Imtigger\LaravelJobStatus\JobStatus;

class ImportYoutubeStatusAction
{
    public function __invoke(string $jobId)
    {
        return new JsonResource(JobStatus::where('id', $jobId)->firstOrFail());
    }
}
