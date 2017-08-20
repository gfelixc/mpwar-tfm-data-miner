<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Source;
use Mpwar\Test\Infrastructure\Stub;

class SourceStub extends Stub
{
    public static function create($id, $value)
    {
        return new Source($id, $value);
    }
    public static function random()
    {
        return self::create(
            self::factory()->uuid,
            self::factory()->domainName
        );
    }
}
