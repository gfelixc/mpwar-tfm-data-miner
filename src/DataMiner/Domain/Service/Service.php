<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\Keyword\Keyword;

abstract class Service
{
    private $serviceName;
    private $visitsRepository;


    public function __construct(
        ServiceName $serviceName,
        ServiceVisitsRepository $visitsRepository
    ) {
        $this->setServiceName($serviceName);
        $this->setVisitsRepository($visitsRepository);
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

    private function visitsRepository(): ServiceVisitsRepository
    {
        return $this->visitsRepository;
    }

    public function find(Keyword $keyword): ServiceRecordsCollection
    {
        $lastVisit = $this->visitsRepository()->lastVisitWithService(
            $keyword,
            $this->serviceName()
        );

        $records = $this->findSince(
            $keyword,
            $lastVisit ? $lastVisit->lastRecordVisited() : null
        );

        $this->visitsRepository()->registerVisit(
            new ServiceVisit(
                $this->serviceName(),
                $keyword,
                $records->lastRecordVisited()
            )
        );

        return $records;
    }

    abstract protected function findSince(
        Keyword $keyword,
        ?LastRecordVisited $serviceVisit
    ): ServiceRecordsCollection;

    public function serviceName(): ServiceName
    {
        return $this->serviceName;
    }
}
