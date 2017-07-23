<?php

namespace Mpwar\DataMiner\Infrastructure\Ui;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DataMinerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['keywords.repository'] = new \Mpwar\DataMiner\Infrastructure\Domain\Keyword\InMemoryKeywordsRepository();
        $app['event.dispatcher'] = new \Mpwar\DataMiner\Infrastructure\Application\SymfonyEventDispatcher($app);

        $app['application.data_miner'] = new \Mpwar\DataMiner\Application\DataMiner(
            $app['keywords.repository'],
            $app['event.dispatcher']
        );

        $app['service.visits.repository'] = new \Mpwar\DataMiner\Infrastructure\Domain\Service\FakeServiceVisitsRepository();

        $app['service.twitter'] = new \Mpwar\DataMiner\Domain\Service\SocialNetwork\Twitter(
            $app['service.visits.repository'],
            $app['credentials.twitter.consumer_key'],
            $app['credentials.twitter.consumer_secret'],
            $app['credentials.twitter.access_token'],
            $app['credentials.twitter.access_token_secret']
        );

        $app['document.factory'] = new \Mpwar\DataMiner\Infrastructure\Domain\Document\DoctrineDocumentFactory();
        $app['document.repository'] = $app['orm.em']
            ->getRepository('Mpwar\DataMiner\Infrastructer\Domain\Document\DoctrineDocument');


        $app['application.service.twitter'] = new \Mpwar\DataMiner\Application\FindKeyword(
            $app['service.twitter'],
            $app['document.factory'],
            $app['document.repository'],
            $app['event.dispatcher']
        );

        $app['application.send_documents'] = new \Mpwar\DataMiner\Application\SendDocumentsToMessageBus(
            $app['message_bus']
        );

        $app['message_bus'] = new \Mpwar\DataMiner\Infrastructure\Application\AmazonSqsMessageBus(
            $app['aws']->createSqs(),
            $app['mpwar.miner']['queue_url']
        );
    }
}
