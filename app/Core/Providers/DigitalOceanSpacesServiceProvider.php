<?php

namespace App\Core\Providers;

use Aws\S3\S3Client;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Storage;

class DigitalOceanSpacesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //extend the storage class and add the driver
        Storage::extend('spaces', function ($app, $config) {
            $client = new S3Client([
                //pass the client config directly into the constructor
                'credentials' => [
                    'key'    => $config['key'],
                    'secret' => $config['secret'],
                ],
                'version' => 'latest',
                'region' => $config['region'],
                'endpoint' => 'https://' . $config['region'] . '.digitaloceanspaces.com',
            ]);

            //create adapter and return the filesystem var
            return new Filesystem(
                new AwsS3Adapter($client, $config['bucket'])
            );
        });
    }
}
