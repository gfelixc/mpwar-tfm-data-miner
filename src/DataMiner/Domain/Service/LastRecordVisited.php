<?php

namespace Mpwar\DataMiner\Domain\Service;

class LastRecordVisited
{
    private $name;
    private $value;

    public function __construct(string $name, string $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->value;
    }

}
