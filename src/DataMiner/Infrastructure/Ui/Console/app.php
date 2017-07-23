<?php

require_once __DIR__ . '/../../../../../vendor/autoload.php';

$app = new Silex\Application();

$config = \Symfony\Component\Yaml\Yaml::parse(
    file_get_contents(__DIR__ . '/../../../../../resources/config/config.yaml')
);

foreach ($config as $key => $value) {
    $app[$key] = $value;
}

$app->register(
    new \Saxulum\DoctrineMongoDb\Provider\DoctrineMongoDbProvider,
    [
        "mongodb.options" => [
            "server" => "mongodb://ec2-52-51-201-144.eu-west-1.compute.amazonaws.com:27017"
        ],
    ]
);
$app->register(
    new Saxulum\DoctrineMongoDbOdm\Provider\DoctrineMongoDbOdmProvider,
    [
        "mongodbodm.proxies_dir" => "/storage/mongodb/proxies",
        "mongodbodm.hydrator_dir" => "/storage/mongodb/hydrator",
        "mongodbodm.dm.options" => [
            "database" => "miner",
            "mappings" => [
                [
                    "type" => "simple_yml",
                    "namespace" => "Mpwar\DataMiner",
                    "path" => __DIR__ . "/../../../../../src/DataMiner/Infrastructure/Domain/Document/mappings",
                ]
            ],
        ],
    ]
);
$app->register(new \Aws\Silex\AwsServiceProvider());
$app->register(
    new \Mpwar\DataMiner\Infrastructure\Ui\DataMinerServiceProvider()
);

return $app;