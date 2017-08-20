<?php

namespace Mpwar\DataMiner\Test\Application;

use Mockery\Mock;
use Mpwar\DataMiner\Application\Service\StoreSearchResult;
use Mpwar\DataMiner\Domain\DocumentRepository;
use Mpwar\DataMiner\Domain\Service\Service;
use Mpwar\DataMiner\Test\Infrastructure\DocumentStub;
use Mpwar\DataMiner\Test\Infrastructure\KeywordStub;
use Mpwar\DataMiner\Test\Infrastructure\ServiceRecordStub;
use Mpwar\Test\Infrastructure\UnitTestCase;

class StoreSearchResultTest extends UnitTestCase
{
    /**
     * @return Mock|Service
     */
    public function service()
    {
        return $this->service;
    }

    /**
     * @return Mock|DocumentRepository
     */
    public function documentRepository()
    {
        return $this->documentRepository;
    }

    /**
     * @return StoreSearchResult
     */
    public function storeSearchResult(): StoreSearchResult
    {
        return $this->storeSearchResult;
    }
    /** @var  Mock|Service */
    private $service;
    /** @var  Mock|DocumentRepository */
    private $documentRepository;
    /** @var  StoreSearchResult */
    private $storeSearchResult;

    public function setUp()
    {
        parent::setUp();

        $this->service = $this->mock(Service::class);
        $this->documentRepository = $this->mock(DocumentRepository::class);

        $this->storeSearchResult = new StoreSearchResult(
            $this->service,
            $this->documentRepository
        );
    }

    /**
    * @test
    */
    public function givenRecordAndKeywordShouldParseItAndStoreDocument()
    {
        $serviceRecord = ServiceRecordStub::random();
        $keyword = KeywordStub::random();

        $documentExpected = DocumentStub::random();

        $this->service()
            ->shouldReceive('parse')
            ->once()
            ->with($serviceRecord, $keyword)
            ->andReturn($documentExpected);

        $this->documentRepository()
            ->shouldReceive('save')
            ->once()
            ->with($documentExpected)
            ->andReturn();

        $document = $this->storeSearchResult()->execute($serviceRecord, $keyword);

        $this->assertEquals($document, $documentExpected);
    }

}
