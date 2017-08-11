<?php

namespace Mpwar\DataMiner\Test\Application;

use Mockery\Mock;
use Mpwar\DataMiner\Application\CommandHandler\ReadKeywords;
use Mpwar\DataMiner\Application\EventDispatcher;
use Mpwar\DataMiner\Domain\Keyword\KeywordsRepository;
use Mpwar\DataMiner\Application\KeywordWasRetrievedEvent;
use Mpwar\DataMiner\Test\Infrastructure\KeywordsCollectionStub;
use Mpwar\DataMiner\Test\Infrastructure\KeywordStub;
use Mpwar\Test\Infrastructure\UnitTestCase;

class DataMinerTest extends UnitTestCase
{
    /** @var  Mock|KeywordsRepository */
    private $keywordsRepository;
    /** @var  Mock|EventDispatcher */
    private $eventDispatcher;
    /** @var  ReadKeywords */
    private $dataMiner;

    /**
     * @test
     */
    public function withEmptyRepositoryShouldPass()
    {
        $keywordsList = KeywordsCollectionStub::empty();

        $this->keywordsRepository->shouldReceive('all')
                                 ->once()
                                 ->withNoArgs()
                                 ->andReturn($keywordsList);

        $this->assertNull($this->dataMiner->execute());
    }

    /**
     * @test
     */
    public function itShouldRetrieveOneKeywordAndDispatch()
    {
        $keyword      = KeywordStub::random();
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

    protected function setUp()
    {
        parent::setUp();

        $this->keywordsRepository = $this->mock(KeywordsRepository::class);
        $this->eventDispatcher    = $this->mock(EventDispatcher::class);

        $this->dataMiner = new ReadKeywords(
            $this->keywordsRepository, $this->eventDispatcher
        );
    }

}