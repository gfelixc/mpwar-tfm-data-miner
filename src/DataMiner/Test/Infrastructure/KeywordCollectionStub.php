<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\KeywordCollection;
use Mpwar\Test\Infrastructure\Stub;

class KeywordCollectionStub extends Stub
{
    public static function random()
    {
        $numberOfKeywords = self::factory()->numberBetween(1, 10);
        $keywords         = [];
        for ($i = 0; $i < $numberOfKeywords; $i++) {
            $keywords[] = KeywordStub::random();
        }

        return self::create(...$keywords);
    }

    public static function create(...$values)
    {
        return new KeywordCollection(...$values);
    }

    public static function empty()
    {
        return self::create([]);
    }
}