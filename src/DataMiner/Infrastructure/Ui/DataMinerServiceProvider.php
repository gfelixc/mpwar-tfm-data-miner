<?php

namespace Mpwar\DataMiner\Infrastructure\Ui;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DataMinerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['keywords.repository'] = new \Mpwar\DataMiner\Infrastructure\Domain\Keyword\InMemoryKeywordsRepository();
        $app['service.visits.repository'] = new \Mpwar\DataMiner\Infrastructure\Domain\Service\FakeServiceVisitsRepository();
        $app['service.twitter'] = new \Mpwar\DataMiner\Domain\Service\SocialNetwork\Twitter(
            $app['service.visits.repository'],
            $app['config']['twitter.config']['consumer_key'],
            $app['config']['twitter.config']['consumer_secret'],
            $app['config']['twitter.config']['access_token'],
            $app['config']['twitter.config']['access_token_secret']
        );

        $app['document.factory'] = new \Mpwar\DataMiner\Infrastructure\Domain\Document\DoctrineDocumentFactory();
        $app['document.repository'] = $app['mongodbodm.dm']
            ->getRepository(\Mpwar\DataMiner\Infrastructure\Domain\Document\DoctrineDocument::class);


        $app['message_bus'] = new \Mpwar\DataMiner\Infrastructure\Application\AmazonSqsMessageBus(
            $app['aws']->createSqs(),
            $app['config']['mpwar.miner']['queue_url']
        );

        $app['application.service.twitter'] = new \Mpwar\DataMiner\Application\CommandHandler\FindKeyword(
            $app['service.twitter'],
            $app['document.factory'],
            $app['document.repository'],
            $app['message_bus']
        );

        $app['application.send_documents'] = new \Mpwar\DataMiner\Application\SendDocumentsToMessageBus(
            $app['message_bus']
        );

        $app['event.dispatcher'] = new \Mpwar\DataMiner\Infrastructure\Application\InMemoryEventDispatcher($app);
        $app['application.data_miner'] = new \Mpwar\DataMiner\Application\CommandHandler\ReadKeywords(
            $app['keywords.repository'],
            $app['event.dispatcher']
        );
    }
}
