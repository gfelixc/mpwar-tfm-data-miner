<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\Keyword\Keyword;

class KeywordWasRetrievedEvent
{
    const NAME = 'keyword.retrieved';
    private $keyword;

    public function __construct(Keyword $keyword)
    {
        $this->keyword = $keyword;
    }
}