<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\LinkUrl;
use Mpwar\Test\Infrastructure\Stub;

class LinkUrlStub extends Stub
{
    public static function create($value)
    {
        return new LinkUrl($value);
    }
    public static function random()
    {
        return self::create(self::factory()->url);
    }
}
