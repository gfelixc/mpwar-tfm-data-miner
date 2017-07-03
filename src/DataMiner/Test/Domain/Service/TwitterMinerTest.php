<?php

namespace Mpwar\DataMiner\Test\Domain\Service;

use Mockery\Mock;
use Mpwar\DataMiner\Domain\Service\Twitter\Repository\TweetsRepository;
use Mpwar\DataMiner\Domain\Service\Twitter\TwitterMiner;
use Mpwar\DataMiner\Domain\Document\ContentFoundEvent;
use Mpwar\DataMiner\Domain\Document\Document;
use Mpwar\DataMiner\Domain\Document\DocumentsRepository;
use Mpwar\DataMiner\Domain\EventDispatcher;
use Mpwar\DataMiner\Domain\Service\ServiceName;
use Mpwar\DataMiner\Domain\Service\ServicesRepository;
use Mpwar\DataMiner\Test\Infrastructure\KeywordStub;
use Mpwar\DataMiner\Test\Infrastructure\ServiceNameStub;
use Mpwar\DataMiner\Test\Infrastructure\TweetsCollectionStub;
use Mpwar\Test\Infrastructure\UnitTestCase;

class TwitterMinerTest extends UnitTestCase
{
    /** @var  Mock|ServicesRepository */
    private $servicesRepository;
    /** @var  Mock|TweetsRepository */
    private $tweetsRepository;
    /** @var  Mock|DocumentsRepository */
    private $documentsRepository;
    /** @var  TwitterMiner */
    private $twitterMiner;

    public function setUp()
    {
        parent::setUp();

        $this->servicesRepository  = $this->mock(ServicesRepository::class);
        $this->tweetsRepository    = $this->mock(TweetsRepository::class);
        $this->documentsRepository = $this->mock(DocumentsRepository::class);
        $this->twitterMiner        = new TwitterMiner(
            $this->servicesRepository,
            $this->tweetsRepository,
            $this->documentsRepository
        );
    }

    /** @test */
    public function noMatchKeyword()
    {
        $keyword          = KeywordStub::random();
        $serviceLastVisit = null;
        $serviceName = ServiceNameStub::create('twitter');
        $tweetsCollection = TweetsCollectionStub::empty();
        $this->findLastVisitFlagInServicesRepository(
            $keyword,
            $serviceName,
            $serviceLastVisit
        );

        $this->findKeywordInRepositorySinceLastVisit(
            $keyword,
            $serviceLastVisit,
            $tweetsCollection
        );

        $this->registerLastVisitFlagInServiceRepository(
            $serviceName,
            $tweetsCollection
        );

        $this->assertNull($this->twitterMiner->execute($keyword));

    }

    /** @test */
    public function firstVisitOnlyOneContentFound()
    {
        $keyword          = KeywordStub::random();
        $serviceLastVisit = null;
        $tweetsCollection = TweetsCollectionStub::random();
        $serviceName = ServiceNameStub::create('twitter');
        $this->findLastVisitFlagInServicesRepository(
            $keyword,
            $serviceName,
            $serviceLastVisit
        );

        $this->findKeywordInRepositorySinceLastVisit(
            $keyword,
            $serviceLastVisit,
            $tweetsCollection
        );

        $this->documentsRepository
            ->shouldReceive('save')
            ->once()
            ->with(Document::class);

        $this->registerLastVisitFlagInServiceRepository(
            $serviceName,
            $tweetsCollection
        );

        $this->assertNull($this->twitterMiner->execute($keyword));

    }

    /**
    * @test
    */
    public function recurrentVisitOnlyOneContentFound()
    {

        $keyword          = KeywordStub::random();
        $tweetsCollection = TweetsCollectionStub::random();
        $serviceLastVisit = $tweetsCollection->maxId();
        $serviceName = ServiceNameStub::create('twitter');
        $this->findLastVisitFlagInServicesRepository(
            $keyword,
            $serviceName,
            $serviceLastVisit
        );

        $this->findKeywordInRepositorySinceLastVisit(
            $keyword,
            $serviceLastVisit,
            $tweetsCollection
        );

        $this->documentsRepository
            ->shouldReceive('save')
            ->once()
            ->with(Document::class);

        $this->registerLastVisitFlagInServiceRepository(
            $serviceName,
            $tweetsCollection
        );

        $this->assertNull($this->twitterMiner->execute($keyword));
    }

    /**
     * @param $serviceName
     * @param $tweetsCollection
     */
    private function registerLastVisitFlagInServiceRepository(
        $serviceName,
        $tweetsCollection
    ): void {
        $this->servicesRepository->shouldReceive('registerVisit')
                                 ->once()
                                 ->with(
                                     equalTo($serviceName),
                                     $tweetsCollection->maxId()
                                 )
                                 ->andReturn();
    }

    /**
     * @param $keyword
     * @param $serviceLastVisit
     * @param $tweetsCollection
     */
    private function findKeywordInRepositorySinceLastVisit(
        $keyword,
        $serviceLastVisit,
        $tweetsCollection
    ): void {
        $this->tweetsRepository->shouldReceive('findKeywordSince')
                               ->once()
                               ->with($keyword, $serviceLastVisit)
                               ->andReturn($tweetsCollection);
    }

    /**
     * @param $keyword
     * @param $serviceName
     * @param $serviceLastVisit
     */
    private function findLastVisitFlagInServicesRepository(
        $keyword,
        $serviceName,
        $serviceLastVisit
    ): void {
        $this->servicesRepository->shouldReceive('lastVisitWithService')
                                 ->once()
                                 ->with($keyword, equalTo($serviceName))
                                 ->andReturn($serviceLastVisit);
    }
}
