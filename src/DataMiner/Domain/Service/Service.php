<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\DomainEventPublisher;
use Mpwar\DataMiner\Domain\Keyword\Keyword;

abstract class Service
{
    private $serviceName;
    public function __construct(
        ServiceName $serviceName
    ) {
        $this->setServiceName($serviceName);
    }

    private function setServiceName(ServiceName $serviceName): void
    {
        $this->serviceName = $serviceName;
    }

    public function name(): ServiceName
    {
        return $this->serviceName;
    }

    abstract public function findSince(
        Keyword $keyword,
        ?Visit $serviceVisit
    ): ResultCollection;

    protected function createServiceRecord(Keyword $keyword, string $data): ServiceRecord
    {

        $serviceRecord = new ServiceRecord($data);

        DomainEventPublisher::instance()->publish(
            new ResultWasFoundEvent(
                $this->name(),
                $keyword->value(),
                $data
            )
        );

        return $serviceRecord;
    }
}
