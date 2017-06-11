<?php

namespace Mpwar\DataMiner\Test;

use Mockery\Mock;
use Mpwar\DataMiner\Application\DataMiner;
use Mpwar\DataMiner\Domain\EventDispatcher;
use Mpwar\DataMiner\Domain\Keyword\KeywordsRepository;
use Mpwar\DataMiner\Domain\Keyword\KeywordWasRetrievedEvent;
use Mpwar\DataMiner\Test\Infrastructure\KeywordsCollectionStub;
use Mpwar\DataMiner\Test\Infrastructure\KeywordStub;
use Mpwar\Test\Infrastructure\UnitTestCase;

class DataMinerTest extends UnitTestCase
{
    /** @var  Mock|KeywordsRepository */
    private $keywordsRepository;
    /** @var  Mock|EventDispatcher */
    private $eventDispatcher;
    /** @var  DataMiner */
    private $dataMiner;

    protected function setUp()
    {
        parent::setUp();

        $this->keywordsRepository = $this->mock(KeywordsRepository::class);
        $this->eventDispatcher = $this->mock(EventDispatcher::class);

        $this->dataMiner          = new DataMiner(
            $this->keywordsRepository,
            $this->eventDispatcher
        );
    }

    /**
     * @test
     */
    public function itShouldRetrieveOneKeywordAndDispatch()
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
                                  KeywordWasRetrievedEvent::class
                              )
                              ->andReturnNull();

        $this->assertNull($this->dataMiner->execute());
    }

}