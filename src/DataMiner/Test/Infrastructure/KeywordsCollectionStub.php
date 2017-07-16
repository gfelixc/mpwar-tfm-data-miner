<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Keyword\KeywordsCollection;
use Mpwar\Test\Infrastructure\Stub;

class KeywordsCollectionStub extends Stub
{
    public static function random()
    {
        $numberOfKeywords = self::factory()->numberBetween(1, 10);
        $keywords         = [];
        for ($i = 0; $i < $numberOfKeywords; $i++) {
            $keywords[] = KeywordStub::random();
        }

        return self::create($keywords);
    }

    public static function create(array $values)
    {
        return new KeywordsCollection(...$values);
    }

    public static function empty()
    {
        return self::create([]);
    }
}