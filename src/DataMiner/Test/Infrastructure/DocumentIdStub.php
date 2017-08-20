<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\DocumentId;
use Mpwar\Test\Infrastructure\Stub;

class DocumentIdStub extends Stub
{
    public static function random()
    {
        return self::create(self::factory()->uuid);
    }

    public static function create($value): DocumentId
    {
        return DocumentId::fromString($value);
    }
}
