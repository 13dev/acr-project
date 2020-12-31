<?php


namespace App\Core\Services\Streamers;

use Symfony\Component\HttpFoundation\Response;

interface Streamable
{
    public function stream(): Response;
}
