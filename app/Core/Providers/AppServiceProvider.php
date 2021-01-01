<?php

namespace App\Core\Providers;

use App\Core\Services\Youtube\YoutubeDownload;
use Illuminate\Support\ServiceProvider;
use Request;
use Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(YoutubeDownload::class, function ($app, $param) {
            return new YoutubeDownload($param);
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('streamed', function ($type, $size, $name, $callback) {
            $start = 0;
            $length = $size;
            $status = 200;

            $headers = [
                'Content-Type' => $type,
                'Content-Length' => $size,
                'Accept-Ranges' => 'bytes'
            ];

            if (false !== $range = Request::server('HTTP_RANGE', false)) {
                list($param, $range) = explode('=', $range);

                if (strtolower(trim($param)) !== 'bytes') {
                    header('HTTP/1.1 400 Invalid Request');
                    exit;
                }

                [$from, $to] = explode('-', $range);

                if ($from === '') {
                    $end = $size - 1;
                    $start = $end - (int)$from;
                } elseif ($to === '') {
                    $start = (int)$from;
                    $end = $size - 1;
                } else {
                    $start = (int)$from;
                    $end = (int)$to;
                }

                if ($end >= $length) {
                    $end = $length - 1;
                }

                $length = $end - $start + 1;

                $status = 206;
                $headers['Content-Range'] = sprintf('bytes %d-%d/%d', $start, $end, $size);
                $headers['Content-Length'] = $length;
            }

            return Response::stream(function () use ($start, $length, $callback) {
                call_user_func($callback, $start, $length);
            }, $status, $headers);
        });
    }
}
