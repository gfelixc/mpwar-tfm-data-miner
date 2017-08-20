<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\TextCollection;
use Mpwar\Test\Infrastructure\Stub;

class TextCollectionStub extends Stub
{
    public static function create($value)
    {
        return new TextCollection($value);
    }
    public static function random()
    {
        return self::create(TextStub::random());
    }
}
