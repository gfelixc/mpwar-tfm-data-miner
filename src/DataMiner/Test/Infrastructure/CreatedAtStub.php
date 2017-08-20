<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\CreatedAt;
use Mpwar\Test\Infrastructure\Stub;

class CreatedAtStub extends Stub
{
    public static function create($value)
    {
        return new CreatedAt($value);
    }
    public static function random()
    {
        return self::create(self::factory()->date(DATE_ATOM));
    }
}
