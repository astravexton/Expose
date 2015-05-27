<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__ . '/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    'Illuminate\Contracts\Http\Kernel',
    'Expose\Http\Kernel'
);

$app->singleton(
    'Illuminate\Contracts\Console\Kernel',
    'Expose\Console\Kernel'
);

$app->singleton(
    'Illuminate\Contracts\Debug\ExceptionHandler',
    'Expose\Exceptions\Handler'
);

$app->bindIf('influxdb', function ($app) {
    $options = new \InfluxDB\Options();

    // Configure options
    $options->setHost(env('INFLUXDB_HOST', '127.0.0.1'));
    $options->setDatabase(env('INFLUXDB_DB'));
    $options->setUsername(env('INFLUXDB_USER', 'root'));
    $options->setPassword(env('INFLUXDB_PASS', 'root'));

    if (env('INFLUXDB_ADAPTER', 'http') == 'http') {
        $adapter = new \InfluxDB\Adapter\HttpAdapter($options);
    } else {
        $adapter = new \InfluxDB\Adapter\UdpAdapter($options);
    }

    $client = new \InfluxDB\Client();
    $client->setAdapter($adapter);
    $client->setFilter(new \InfluxDB\Filter\ColumnsPointsFilter());

    return $client;
});

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
