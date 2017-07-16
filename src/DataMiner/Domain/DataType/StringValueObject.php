<?php

namespace Mpwar\DataMiner\Domain\DataType;

abstract class StringValueObject
{
    private $value;

    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function setValue(string $value): void
    {
        $this->value = $value;
    }

}
