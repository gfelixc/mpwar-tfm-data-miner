<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\Keyword\Keyword;

class ServiceVisit
{
    private $serviceName;
    private $keyword;
    private $lastRecordVisited;
    private $occurredOn;

    public function __construct(
        ServiceName $serviceName,
        Keyword $keyword,
        LastRecordVisited $lastRecordVisited
    ) {
        $this->serviceName = $serviceName;
        $this->keyword = $keyword;
        $this->lastRecordVisited = $lastRecordVisited;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function keyword(): Keyword
    {
        return $this->keyword;
    }

    public function serviceName(): ServiceName
    {
        return $this->serviceName;
    }

    public function lastRecordVisited(): LastRecordVisited
    {
        return $this->lastRecordVisited;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
