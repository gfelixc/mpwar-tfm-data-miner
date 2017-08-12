<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\DataType\Timestamp;

class ResultWasFoundEvent
{
    const NAME = 'result.found';

    private $service;
    private $keyword;
    private $result;
    private $occurredOn;

    public function __construct(
        string $service,
        string $keyword,
        string $result
    ) {
        $this->service    = $service;
        $this->keyword    = $keyword;
        $this->result     = $result;
        $this->occurredOn = Timestamp::now();
    }

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
    public function keyword(): string
    {
        return $this->keyword;
    }

    /**
     * @return string
     */
    public function result(): string
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
