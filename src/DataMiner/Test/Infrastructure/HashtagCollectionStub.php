<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\HashtagCollection;
use Mpwar\Test\Infrastructure\Stub;

class HashtagCollectionStub extends Stub
{
    public static function create($value)
    {
        return new HashtagCollection($value);
    }
    public static function random()
    {
        return self::create(HashtagStub::random());
    }
}
