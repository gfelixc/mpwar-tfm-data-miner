<?php

namespace Mpwar\DataMiner\Infrastructure\Ui;

use Doctrine\ODM\MongoDB\Types\Type;
use Mpwar\DataMiner\Application\DocumentToArray;
use Mpwar\DataMiner\Application\StoreSearchResult;
use Mpwar\DataMiner\Infrastructure\Persistence\AuthorType;
use Mpwar\DataMiner\Infrastructure\Persistence\CreatedAtType;
use Mpwar\DataMiner\Infrastructure\Persistence\HashtagCollectionType;
use Mpwar\DataMiner\Infrastructure\Persistence\ImageCollectionType;
use Mpwar\DataMiner\Infrastructure\Persistence\KeywordCollectionType;
use Mpwar\DataMiner\Infrastructure\Persistence\LanguageType;
use Mpwar\DataMiner\Infrastructure\Persistence\LinkCollectionType;
use Mpwar\DataMiner\Infrastructure\Persistence\SourceType;
use Mpwar\DataMiner\Infrastructure\Persistence\TextCollectionType;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DataMinerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        Type::addType('AuthorType', AuthorType::class);
        Type::addType('CreatedAtType', CreatedAtType::class);
        Type::addType('HashtagCollectionType', HashtagCollectionType::class);
        Type::addType('ImageCollectionType', ImageCollectionType::class);
        Type::addType('KeywordCollectionType', KeywordCollectionType::class);
        Type::addType('LanguageType', LanguageType::class);
        Type::addType('LinkCollectionType', LinkCollectionType::class);
        Type::addType('SourceType', SourceType::class);
        Type::addType('TextCollectionType', TextCollectionType::class);

        $app['document.factory'] = new \Mpwar\DataMiner\Infrastructure\Domain\Document\DoctrineDocumentFactory();
        $app['keywords.repository'] = new \Mpwar\DataMiner\Infrastructure\Domain\Keyword\InMemoryKeywordsRepository();
        $app['service.visits.repository'] = new \Mpwar\DataMiner\Infrastructure\Domain\Service\FakeServiceVisitsRepository();
        $app['service.twitter'] = new \Mpwar\DataMiner\Domain\Service\SocialNetwork\Twitter(
            $app['service.visits.repository'],
            $app['document.factory'],
            $app['config']['twitter.config']['consumer_key'],
            $app['config']['twitter.config']['consumer_secret'],
            $app['config']['twitter.config']['access_token'],
            $app['config']['twitter.config']['access_token_secret']
        );

        $app['document.repository'] = $app['mongodbodm.dm']
            ->getRepository(\Mpwar\DataMiner\Infrastructure\Domain\Document\DoctrineDocument::class);


        $app['message_bus'] = new \Mpwar\DataMiner\Infrastructure\Application\AmazonSqsMessageBus(
            $app['aws']->createSqs(),
            $app['config']['mpwar.miner']['queue_url']
        );

        $app['document.transformer'] = new DocumentToArray();

        $app['application.store_search_result'] = new StoreSearchResult(
            $app['service.twitter'],
            $app['document.repository']
        );

        $app['application.find_keyword'] = new \Mpwar\DataMiner\Application\FindKeyword(
            $app['service.twitter'],
            $app['application.store_search_result'],
            $app['document.transformer'],
            $app['message_bus']
        );

        $app['application.send_documents'] = new \Mpwar\DataMiner\Application\SendDocumentsToMessageBus(
            $app['message_bus']
        );

        $app['application.data_miner'] = new \Mpwar\DataMiner\Application\DataMiner(
            $app['keywords.repository'],
            $app['event.dispatcher']
        );
    }
}
