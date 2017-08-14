<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

$console = new Symfony\Component\Console\Application();
$console->setHelperSet(
    new Symfony\Component\Console\Helper\HelperSet(
        array(
            'documentManager' => new \Doctrine\ODM\MongoDB\Tools\Console\Helper\DocumentManagerHelper(
                $app['mongodbodm.dm']
            ),
        )
    )
);
$console->addCommands(
    [
//        new \Mpwar\DataMiner\Infrastructure\Ui\Console\Command\DataMinerCommand(
//            $app['application.find_keyword']
//        ),
        new \Mpwar\DataMiner\Infrastructure\Ui\Console\Command\FindKeywordCommand(
            $app['application.find_keyword']
        ),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\CreateCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\DropCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\Schema\UpdateCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateHydratorsCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateProxiesCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateDocumentsCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\GeneratePersistentCollectionsCommand(),
        new \Doctrine\ODM\MongoDB\Tools\Console\Command\GenerateRepositoriesCommand()
    ]
);

return $console;