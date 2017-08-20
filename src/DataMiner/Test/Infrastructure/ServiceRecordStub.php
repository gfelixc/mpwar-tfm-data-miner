<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Service\ServiceRecord;
use Mpwar\Test\Infrastructure\Stub;

class ServiceRecordStub extends Stub
{
    public static function create($value)
    {
        return new ServiceRecord($value);
    }
    public static function random()
    {
        return self::create(self::factory()->text());
    }
}
