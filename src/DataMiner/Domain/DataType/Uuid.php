<?php

namespace Mpwar\DataMiner\Domain\DataType;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

abstract class Uuid
{
    private $value;

    private function __construct($value)
    {
        $this->setValue($value);
    }

    private function setValue($value): void
    {
        $this->isValid($value);
        $this->value = $value;
    }

    private function isValid($value): void
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidArgumentException();
        }
    }

    public static function new(): self
    {
        $ramseyUuid = RamseyUuid::uuid4()
                                ->toString();

        return new static($ramseyUuid);
    }

    public static function fromString(string $uuid): self
    {
        return new static($uuid);
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): string
    {
        return $this->value;
    }
}
