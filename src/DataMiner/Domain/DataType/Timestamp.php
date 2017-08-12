<?php

namespace Mpwar\DataMiner\Domain\DataType;

use DateTimeInterface;

abstract class Timestamp
{
    public static function now(): string
    {
        return self::defaultFormat(new \DateTimeImmutable());
    }

    public static function toString(DateTimeInterface $date):string
    {
        return self::defaultFormat($date);
    }

    private static function defaultFormat(DateTimeInterface $date): string
    {
        return $date->format(DATE_ATOM);
    }
}
