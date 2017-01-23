<?php

namespace League\Flysystem\Azure\Providers;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Azure\AzureAdapter;
use League\Flysystem\Filesystem;
use MicrosoftAzure\Storage\Common\ServicesBuilder;
use Storage;


class AzureServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        Storage::extend('azure', function ($app, $config) {

            $endpoint = sprintf(
                'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
                $config['account-name'],
                $config['api-key']
            );

            $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($endpoint);
            $filesystem = new Filesystem(new AzureAdapter($blobRestProxy, $config['my-container']));
            return $filesystem;
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
