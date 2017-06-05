<?php

namespace Mpwar\DataMiner\Domain\Keyword;

class Keyword
{
    private function __construct(string $keyword)
    {
        $this->value = $keyword;
    }

    public static function fromString(string $keyword): self
    {
        return new static($keyword);
    }
}