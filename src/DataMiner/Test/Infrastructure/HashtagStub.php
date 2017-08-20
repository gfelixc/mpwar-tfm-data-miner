<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Hashtag;
use Mpwar\Test\Infrastructure\Stub;

class HashtagStub extends Stub
{
    public static function create($value)
    {
        return new Hashtag($value);
    }
    public static function random()
    {
        return self::create(self::factory()->word);
    }
}
