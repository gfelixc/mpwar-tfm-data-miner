<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Service\ServiceRecordsCollection;
use Mpwar\Test\Infrastructure\Stub;

class ServiceRecordCollectionStub extends Stub
{
    public static function create(...$value)
    {
        return new ServiceRecordsCollection(...$value);
    }
    public static function random()
    {
        return self::create(ServiceRecordStub::random());
    }

    public static function empty()
    {
        return self::create();
    }
}
