<?php

namespace Mpwar\DataMiner\Domain\Keyword;

class Keyword
{
    private $value;

    private function __construct(string $keyword)
    {
        $this->value = $keyword;
    }

    public static function fromString(string $keyword): self
    {
        return new static($keyword);
    }

    public function value()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }
}
