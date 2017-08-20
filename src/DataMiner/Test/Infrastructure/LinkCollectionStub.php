<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\LinkCollection;
use Mpwar\Test\Infrastructure\Stub;

class LinkCollectionStub extends Stub
{
    public static function create($value)
    {
        return new LinkCollection($value);
    }
    public static function random()
    {
        return self::create(LinkStub::random());
    }
}
