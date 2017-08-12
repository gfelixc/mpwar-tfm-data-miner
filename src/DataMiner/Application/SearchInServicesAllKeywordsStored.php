<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\Document\DocumentFactory;
use Mpwar\DataMiner\Domain\Document\DocumentRepository;
use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Keyword\KeywordsRepository;
use Mpwar\DataMiner\Domain\Service\Service;
use Mpwar\DataMiner\Domain\Service\Visit;
use Mpwar\DataMiner\Domain\Service\ServiceVisitsRepository;

class SearchInServicesAllKeywordsStored
{
    /**
     * @var KeywordsRepository
     */
    private $keywordsRepository;
    /**
     * @var Service
     */
    private $service;
    /**
     * @var ServiceVisitsRepository
     */
    private $visitsRepository;
    /**
     * @var DocumentFactory
     */
    private $documentFactory;
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    public function __construct(
        Service $service,
        ServiceVisitsRepository $visitsRepository,
        DocumentFactory $documentFactory,
        DocumentRepository $documentRepository
    ) {
        $this->service            = $service;
        $this->visitsRepository   = $visitsRepository;
        $this->documentFactory    = $documentFactory;
        $this->documentRepository = $documentRepository;
    }

    public function find(Keyword $keyword)
    {
        $lastVisitByKeyword       = $this->visitsRepository->lastByKeyword($keyword, $this->service->name());
        $lastRecordVisited        = ($lastVisitByKeyword) ? $lastVisitByKeyword->lastRecordVisited() : null;
        $serviceRecordsCollection = $this->service->findSince($keyword, $lastRecordVisited);

        if ($serviceRecordsCollection->lastRecordVisited()) {
            $this->visitsRepository->registerVisit(
                new Visit(
                    $this->service->name(), $keyword, $serviceRecordsCollection->lastRecordVisited()
                )
            );
        }

        return $serviceRecordsCollection;
    }
}
