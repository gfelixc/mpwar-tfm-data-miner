<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Service\ServiceName;
use Mpwar\Test\Infrastructure\Stub;

class ServiceNameStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->domainWord);
    }

    public static function create($value)
    {
        return new ServiceName($value);
    }
}
