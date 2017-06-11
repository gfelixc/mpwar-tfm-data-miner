<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Document\DocumentContent;
use Mpwar\Test\Infrastructure\Stub;

class DocumentContentStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->text());
    }

    public static function create($value)
    {
        return new DocumentContent($value);
    }

    public static function fromString($string)
    {
        return DocumentContent::fromString($string);
    }
}
