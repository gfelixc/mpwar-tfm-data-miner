<?php

namespace Mpwar\DataMiner\Application\Command;

class ParseResultCommand
{
    /**
     * @return string
     */
    public function service(): string
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function result(): string
    {
        return $this->record;
    }

    /**
     * @var string
     */
    private $service;
    /**
     * @var string
     */
    private $record;

    public function __construct(string $service, string $record)
    {
        $this->service = $service;
        $this->record  = $record;
    }
}
