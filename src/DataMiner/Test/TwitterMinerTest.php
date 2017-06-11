<?php

namespace Mpwar\DataMiner\Test;

use Mockery\Mock;
use Mpwar\DataMiner\Application\Twitter\Repository\TweetsRepository;
use Mpwar\DataMiner\Application\Twitter\TwitterMiner;
use Mpwar\DataMiner\Domain\Document\Document;
use Mpwar\DataMiner\Domain\Document\DocumentsRepository;
use Mpwar\DataMiner\Domain\Service\ServicesRepository;
use Mpwar\DataMiner\Test\Infrastructure\KeywordStub;
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
    public function givenAKeywordShouldStoreADocument()
    {
        $keyword          = KeywordStub::random();
        $since            = null;
        $tweet            = '';
        $tweetsCollection = [$tweet];
        $this->servicesRepository->shouldReceive('lastVisitWithService')
                                 ->once()
                                 ->with($keyword->value(), 'twitter')
                                 ->andReturn($since);

        $this->tweetsRepository
            ->shouldReceive('findKeywordSince')
            ->once()
            ->with($keyword->value(), $since)
            ->andReturn($tweetsCollection);

        $this->documentsRepository
            ->shouldReceive('save')
            ->once()
            ->with(Document::class)
            ->andReturnNull();

        $this->assertNull($this->twitterMiner->execute($keyword));

    }
}
