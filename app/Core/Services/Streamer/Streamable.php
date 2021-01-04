<?php


namespace App\Core\Services\Streamer;

use Symfony\Component\HttpFoundation\Response;

interface Streamable
{
    public function stream(): Response;
}
