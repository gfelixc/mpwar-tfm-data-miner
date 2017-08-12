<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\DataType\Timestamp;

class ResultWasAnalyzedEvent
{
    const NAME = 'result.analyzed';

    private $service;
    private $keyword;
    private $analysisResult;
    private $occurredOn;

    public function __construct(
        string $service,
        string $keyword,
        string $analysisResult
    ) {
        $this->service        = $service;
        $this->keyword        = $keyword;
        $this->analysisResult = $analysisResult;
        $this->occurredOn     = Timestamp::now();
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
    public function analysisResult(): string
    {
        return $this->analysisResult;
    }

    /**
     * @return string
     */
    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
