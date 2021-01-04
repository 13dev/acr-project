<?php


namespace App\Domain\Album\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadCoverService
{
    public function __invoke(UploadedFile $file)
    {
        $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/public/covers'), $fileName);
        return $fileName;
    }
}
