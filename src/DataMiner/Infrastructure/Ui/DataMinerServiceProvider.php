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
            "tQztCZgNcGaTbjtbBtX0Mw",
            "UBhByoTWvyOQTzXpwiTJOeb6k5vVNCmURFD4MzkygU",
            "148461182-8hrZfmzyTCSnNcZL53eLIXl6oNHJTKZZDNScQYJP",
            "jGXq1mnG9uF9jV33ppwvQ2PQ5pdOvMSnv5ncgdCfnAEeB"
//            $app['credentials.twitter.consumer_key'],
//            $app['credentials.twitter.consumer_secret'],
//            $app['credentials.twitter.access_token'],
//            $app['credentials.twitter.access_token_secret']
        );

        $app['document.factory'] = new \Mpwar\DataMiner\Infrastructure\Domain\Document\DoctrineDocumentFactory();
        $app['document.repository'] = $app['mongodbodm.dm']
            ->getRepository('Mpwar\DataMiner\Infrastructure\Domain\Document\DoctrineDocument');


        $app['message_bus'] = new \Mpwar\DataMiner\Infrastructure\Application\AmazonSqsMessageBus(
            $app['aws']->createSqs(),
            $app['mpwar.miner']['queue_url']
        );

        $app['application.service.twitter'] = new \Mpwar\DataMiner\Application\FindKeyword(
            $app['service.twitter'],
            $app['document.factory'],
            $app['document.repository'],
            $app['message_bus']
        );

        $app['application.send_documents'] = new \Mpwar\DataMiner\Application\SendDocumentsToMessageBus(
            $app['message_bus']
        );

        $app['event.dispatcher'] = new \Mpwar\DataMiner\Infrastructure\Application\InMemoryEventDispatcher($app);
        $app['application.data_miner'] = new \Mpwar\DataMiner\Application\DataMiner(
            $app['keywords.repository'],
            $app['event.dispatcher']
        );
    }
}
