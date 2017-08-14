<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\Document;
use Mpwar\DataMiner\Domain\DocumentFactory;
use Mpwar\DataMiner\Domain\Keyword;

abstract class Service
{
    private $serviceName;
    private $visitsRepository;
    private $documentFactory;

    public function __construct(
        ServiceName $serviceName,
        ServiceVisitsRepository $visitsRepository,
        DocumentFactory $documentFactory
    ) {
        $this->setServiceName($serviceName);
        $this->setVisitsRepository($visitsRepository);
        $this->setDocumentFactory($documentFactory);
    }

    private function setServiceName(ServiceName $serviceName): void
    {
        $this->serviceName = $serviceName;
    }

    private function setVisitsRepository(
        ServiceVisitsRepository $visitsRepository
    ): void {
        $this->visitsRepository = $visitsRepository;
    }

    public function find(Keyword $keyword): ServiceRecordsCollection
    {
        $lastVisit = $this->visitsRepository()
                          ->lastVisitWithService(
                              $keyword,
                              $this->serviceName()
                          );

        $records = $this->findSince(
            $keyword,
            $lastVisit ? $lastVisit->lastRecordVisited() : null
        );

        $this->visitsRepository()
             ->registerVisit(
                 new ServiceVisit(
                     $this->serviceName(), $keyword, $records->lastRecordVisited()
                 )
             );

        return $records;
    }

    private function visitsRepository(): ServiceVisitsRepository
    {
        return $this->visitsRepository;
    }

    public function serviceName(): ServiceName
    {
        return $this->serviceName;
    }

    abstract protected function findSince(
        Keyword $keyword,
        ?LastRecordVisited $serviceVisit
    ): ServiceRecordsCollection;

    abstract public function parse(ServiceRecord $record, Keyword $searchedKeyword): Document;

    private function setDocumentFactory(DocumentFactory $documentFactory): void
    {
        $this->documentFactory = $documentFactory;
    }

    /**
     * @return mixed
     */
    protected function documentFactory(): DocumentFactory
    {
        return $this->documentFactory;
    }
}
