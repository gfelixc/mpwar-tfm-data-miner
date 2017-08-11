<?php

namespace Mpwar\DataMiner\Application\Command;

class ParseRecordCommand
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
    public function record(): string
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
