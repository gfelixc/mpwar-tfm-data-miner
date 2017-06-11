<?php

namespace Mpwar\DataMiner\Domain\DataType;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    private $value;

    private function __construct($value)
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidArgumentException();
        }
        $this->value = $value;
    }

    public static function new()
    {
        $ramseyUuid = RamseyUuid::uuid4()
                                ->toString();

        return new static($ramseyUuid);
    }

    public static function fromString(string $uuid)
    {
        return new static($uuid);
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
