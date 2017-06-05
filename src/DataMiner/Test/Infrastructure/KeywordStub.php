<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\Test\Infrastructure\Stub;


class KeywordStub extends Stub
{
    public static function create($value)
    {
        return Keyword::fromString($value);
    }
    public static function random()
    {
        return self::create(self::factory()->word);
    }
}