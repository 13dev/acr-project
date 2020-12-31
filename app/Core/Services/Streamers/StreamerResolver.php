<?php


namespace App\Core\Services\Streamers;


use App\Domain\Song\Song;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class StreamerResolver
{
    /**
     * Get all streamers on $streams and try to choose the one has no exceptions.
     * @param array $streams
     * @param Song $song
     * @return mixed
     * @throws Exception
     */
    public static function resolve(array $streams, Song $song): Response {
        foreach ($streams as $stream) {
            $stream = new $stream();

            if(!($stream instanceof Streamer)) {
                continue;
            }

            try {
                $stream->setSong($song);
                $response = $stream->stream();

                dump("using streamer", $stream);
                return $response;
            } catch (Exception $ex) {
                continue;
            }
        }

        throw new Exception('Cant resolve the stream.');
    }
}
