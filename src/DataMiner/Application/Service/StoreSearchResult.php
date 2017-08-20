<?php

namespace Mpwar\DataMiner\Application\Service;

use Mpwar\DataMiner\Domain\DocumentRepository;
use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\Service\ParserService;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;

class StoreSearchResult
{
    /**
     * @var ParserService
     */
    private $service;
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    public function __construct(ParserService $service, DocumentRepository $documentRepository)
    {
        $this->service            = $service;
        $this->documentRepository = $documentRepository;
    }

    public function execute(ServiceRecord $record, Keyword $keyword)
    {
        $document = $this->service()->parse($record, $keyword);
        $this->documentRepository()->save($document);

        return $document;
    }

    /**
     * @return ParserService
     */
    public function service(): ParserService
    {
        return $this->service;
    }

    /**
     * @return DocumentRepository
     */
    public function documentRepository(): DocumentRepository
    {
        return $this->documentRepository;
    }
}
