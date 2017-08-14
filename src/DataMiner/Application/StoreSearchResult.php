<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\DocumentRepository;
use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\Service\Service;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;

class StoreSearchResult
{
    /**
     * @var Service
     */
    private $service;
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    public function __construct(Service $service, DocumentRepository $documentRepository)
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
     * @return Service
     */
    public function service(): Service
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
