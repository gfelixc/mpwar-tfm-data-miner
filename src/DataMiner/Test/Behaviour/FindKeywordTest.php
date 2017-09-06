<?php

namespace Mpwar\DataMiner\Test\Behaviour;

use Mockery\Mock;
use Mpwar\DataMiner\Application\DocumentTransformer;
use Mpwar\DataMiner\Application\MessageBus;
use Mpwar\DataMiner\Application\Service\FindKeyword;
use Mpwar\DataMiner\Application\Service\StoreSearchResult;
use Mpwar\DataMiner\Domain\Service\FinderService;
use Mpwar\DataMiner\Test\Infrastructure\DocumentStub;
use Mpwar\DataMiner\Test\Infrastructure\KeywordStub;
use Mpwar\DataMiner\Test\Infrastructure\ServiceRecordCollectionStub;
use Mpwar\DataMiner\Test\Infrastructure\ServiceRecordStub;
use Mpwar\Test\Infrastructure\UnitTestCase;

class FindKeywordTest extends UnitTestCase
{
    /** @var  Mock|FinderService */
    private $service;
    /** @var  Mock|StoreSearchResult */
    private $storeSearchResult;
    /** @var  Mock|DocumentTransformer */
    private $documentTransformer;
    /** @var  Mock|MessageBus */
    private $messageBus;
    /** @var  FindKeyword */
    private $findKeyword;

    /**
     * @return Mock|FinderService
     */
    public function service()
    {
        return $this->service;
    }

    /**
     * @return Mock|StoreSearchResult
     */
    public function storeSearchResult()
    {
        return $this->storeSearchResult;
    }

    /**
     * @return Mock|DocumentTransformer
     */
    public function documentTransformer()
    {
        return $this->documentTransformer;
    }

    /**
     * @return Mock|MessageBus
     */
    public function messageBus()
    {
        return $this->messageBus;
    }

    /**
     * @return FindKeyword
     */
    public function findKeyword(): FindKeyword
    {
        return $this->findKeyword;
    }

    public function setUp()
    {
        parent::setUp();

        $this->service             = $this->mock(FinderService::class);
        $this->storeSearchResult   = $this->mock(StoreSearchResult::class);
        $this->documentTransformer = $this->mock(DocumentTransformer::class);
        $this->messageBus          = $this->mock(MessageBus::class);

        $this->findKeyword = new FindKeyword(
            $this->service, $this->storeSearchResult, $this->documentTransformer, $this->messageBus
        );
    }

    /**
     * @test
     */
    public function givenAKeywordShouldFoundStoreResultAndSendMessage()
    {
        $keyword = KeywordStub::create('hooli');
        $record = ServiceRecordStub::create('We\'re more than the chat, mail, 
        search and phone that\'s crowned Hooli as the most respected brand in the world.');
        $recordsCollection = ServiceRecordCollectionStub::create($record);
        $document = DocumentStub::customKeywordText('hooli', 'We\'re more than the chat, mail, 
        search and phone that\'s crowned Hooli as the most respected brand in the world.');
        $message = json_encode([
            'eventName'  => 'RawDocumentWasStored',
            'occurredOn' => (new \DateTime())->format(DATE_ATOM),
            'data'       => []
        ]);

        $this->service()
            ->shouldReceive('find')
            ->once()
            ->with($keyword)
            ->andReturn($recordsCollection);

        $this->storeSearchResult()
            ->shouldReceive('execute')
            ->once()
            ->with($record, $keyword)
            ->andReturn($document);

        $this->documentTransformer()
            ->shouldReceive('transform')
            ->once()
            ->with($document)
            ->andReturn($message);

        $this->messageBus()
            ->shouldReceive('dispatch')
            ->once()
            ->with(equalTo($message))
            ->andReturn();

        $this->assertEquals(null, $this->findKeyword()->find($keyword));
    }
}