<?php


namespace App\Services\Streamers;


use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface Streamable
{
    public function stream(): ?BinaryFileResponse;
}
