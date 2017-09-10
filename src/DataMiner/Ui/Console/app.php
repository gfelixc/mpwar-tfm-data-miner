<?php

$rootPath = __DIR__ . '/../../../../../mpwar-tfm-data-miner/';
require_once $rootPath . 'vendor/autoload.php';

$app = new Silex\Application();

$app->register(new DerAlex\Silex\YamlConfigServiceProvider($rootPath . 'resources/config/config.yml'));

$app->register(
    new \Saxulum\DoctrineMongoDb\Provider\DoctrineMongoDbProvider(),
    ['mongodb.options' => $app['config']['mongodb.options']]
);
$app->register(
    new \Saxulum\DoctrineMongoDbOdm\Provider\DoctrineMongoDbOdmProvider(),
    $app['config']['mongodbodm.options']
);
$app['aws.config'] = $app['config']['aws.config'];
$app->register(new \Aws\Silex\AwsServiceProvider());
$app->register(
    new \Mpwar\DataMiner\Ui\DataMinerServiceProvider()
);

return $app;