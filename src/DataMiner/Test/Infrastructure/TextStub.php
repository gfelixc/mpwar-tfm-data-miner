<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Text;
use Mpwar\Test\Infrastructure\Stub;

class TextStub extends Stub
{
    public static function create($value)
    {
        return new Text($value);
    }
    public static function random()
    {
        return self::create(self::factory()->text());
    }
}
