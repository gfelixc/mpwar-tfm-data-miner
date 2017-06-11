<?php

namespace Mpwar\DataMiner\Domain\Document;

class DocumentContent
{

    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString($tweet)
    {
        $jsonEncodedValue = json_encode($tweet);
        return new static($jsonEncodedValue);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }
}
