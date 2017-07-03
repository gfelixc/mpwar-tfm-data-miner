<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Service\Twitter\Repository\TweetsCollection;
use Mpwar\Test\Infrastructure\Stub;

class TweetsCollectionStub extends Stub
{
    public static function create($tweets, $maxId)
    {
        return new TweetsCollection($tweets, $maxId);
    }
    public static function random()
    {
        return self::create(
            [
                self::factory()->realText()
            ],
            self::factory()->randomNumber()
        );
    }

    public static function empty()
    {

        return self::create(
            [],
            self::factory()->randomNumber()
        );
    }
}
