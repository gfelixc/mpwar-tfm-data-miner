<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Keyword\KeywordWasRetrievedEvent;

class KeywordWasRetrievedEventStub
{
    public static function random()
    {
        return self::create(KeywordStub::random());
    }

    public static function create($keyword)
    {
        return new KeywordWasRetrievedEvent($keyword);
    }

    public static function fromKeyword(Keyword $keyword)
    {
        return self::create($keyword);
    }
}