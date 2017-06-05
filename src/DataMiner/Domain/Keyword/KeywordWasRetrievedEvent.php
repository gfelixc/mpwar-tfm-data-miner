<?php

namespace Mpwar\DataMiner\Domain\Keyword;

class KeywordWasRetrievedEvent
{
    const NAME = 'keyword.retrieved';
    private $keyword;

    public function __construct(Keyword $keyword)
    {
        $this->keyword = $keyword;
    }
}