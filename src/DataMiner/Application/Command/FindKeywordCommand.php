<?php

namespace Mpwar\DataMiner\Application\Command;

class FindKeywordCommand
{

    /**
     * @var string
     */
    private $keyword;

    public function __construct(string $keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @return string
     */
    public function keyword(): string
    {
        return $this->keyword;
    }
}
