<?php


namespace App\Core\Services\Streamers;


use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface Streamable
{
    public function stream(): ?BinaryFileResponse;
}
