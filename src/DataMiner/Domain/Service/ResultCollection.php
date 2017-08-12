<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\DataType\ArrayCollection;

class ResultCollection extends ArrayCollection
{
    private $lastRecordVisited;

    public function __construct(...$items)
    {
        parent::__construct(...$items);
        $this->lastRecordVisited = null;
    }

    public function lastRecordVisited(): ?LastRecordVisited
    {
        return $this->lastRecordVisited;
    }

    protected function typeOfCollection(): string
    {
        return ServiceRecord::class;
    }

    public function setLastRecordVisited(string $name, string $value)
    {
        $this->lastRecordVisited = new LastRecordVisited($name, $value);
    }
}
