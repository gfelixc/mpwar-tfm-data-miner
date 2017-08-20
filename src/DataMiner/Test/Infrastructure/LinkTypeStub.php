<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\LinkType;
use Mpwar\Test\Infrastructure\Stub;

class LinkTypeStub extends Stub
{
    public static function create($value)
    {
        return new LinkType($value);
    }
    public static function random()
    {
        return self::create(
            self::factory()->randomElement(LinkType::VALID_TYPES)
        );
    }
}
