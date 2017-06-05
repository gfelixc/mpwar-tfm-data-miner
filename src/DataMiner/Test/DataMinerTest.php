<?php

namespace Mpwar\DataMiner\Test;

use Mockery\MockInterface;
use Mpwar\DataMiner\Application\DataMiner;
use Mpwar\DataMiner\Domain\EventDispatcher;
use Mpwar\DataMiner\Domain\Keyword\KeywordsRepository;
use Mpwar\DataMiner\Test\Infrastructure\KeywordsCollectionStub;
use Mpwar\DataMiner\Test\Infrastructure\KeywordStub;
use Mpwar\DataMiner\Test\Infrastructure\KeywordWasRetrievedEventStub;
use Mpwar\Test\Infrastructure\UnitTestCase;

class DataMinerTest extends UnitTestCase
{
    /** @var  MockInterface|KeywordsRepository */
    private $keywordsRepository;
    /** @var  MockInterface|EventDispatcher */
    private $eventDispatcher;
    /** @var  DataMiner */
    private $dataMiner;

    protected function setUp()
    {
        parent::setUp();

        $this->keywordsRepository = $this->mock(KeywordsRepository::class);
        $this->eventDispatcher    = $this->mock(EventDispatcher::class);

        $this->dataMiner          = new DataMiner(
            $this->keywordsRepository,
            $this->eventDispatcher
        );
    }

    /**
     * @test
     */
    public function it_should_retrieve_one_keyword_and_dispatch()
    {
        $keyword = KeywordStub::random();
        $keywordsList = KeywordsCollectionStub::create(
            [
                $keyword
            ]
        );

        $this->keywordsRepository->shouldReceive('all')
                                 ->once()
                                 ->withNoArgs()
                                 ->andReturn($keywordsList);

        $this->eventDispatcher->shouldReceive('dispatch')
                              ->once()
                              ->with(
                                  'keyword.retrieved',
                                  KeywordWasRetrievedEventStub::fromKeyword($keyword)
                              )
                              ->andReturnNull();

        $this->assertNull($this->dataMiner->execute());
    }

}