<?php

namespace Mpwar\DataMiner\Infrastructure\Ui;

use Doctrine\ODM\MongoDB\Types\Type;
use Mpwar\DataMiner\Infrastructure\Application\DocumentToMessage;
use Mpwar\DataMiner\Application\Service\StoreSearchResult;
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
        $app['finder.twitter'] = new \Mpwar\DataMiner\Domain\Service\SocialNetwork\TwitterFinderService(
            $app['config']['twitter.config']['consumer_key'],
            $app['config']['twitter.config']['consumer_secret'],
            $app['config']['twitter.config']['access_token'],
            $app['config']['twitter.config']['access_token_secret']
        );
        $app['parser.twitter'] = new \Mpwar\DataMiner\Domain\Service\SocialNetwork\TwitterParserService(
            $app['document.factory']
        );

        $app['document.repository'] = $app['mongodbodm.dm']
            ->getRepository(\Mpwar\DataMiner\Infrastructure\Domain\Document\DoctrineDocument::class);


        $app['message_bus'] = new \Mpwar\DataMiner\Infrastructure\Application\AmazonSqsMessageBus(
            $app['aws']->createSqs(),
            $app['config']['mpwar.miner']['queue_url']
        );

        $app['document.transformer'] = new DocumentToMessage();

        $app['application.store_search_result'] = new StoreSearchResult(
            $app['parser.twitter'],
            $app['document.repository']
        );

        $app['application.find_keyword'] = new \Mpwar\DataMiner\Application\Service\FindKeyword(
            $app['finder.twitter'],
            $app['application.store_search_result'],
            $app['document.transformer'],
            $app['message_bus']
        );
    }
}
