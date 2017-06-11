<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Document\Document;
use Mpwar\Test\Infrastructure\Stub;

class DocumentStub extends Stub
{
    public static function random()
    {
        return self::create(
            DocumentIdStub::random(),
            ServiceNameStub::random(),
            KeywordStub::random(),
            DocumentContentStub::random()
        );
    }

    public static function create($id, $service, $keyword, $content)
    {
        return new Document($id, $service, $keyword, $content);
    }

    public static function fromString($string)
    {
        return self::create(
            DocumentIdStub::random(),
            ServiceNameStub::random(),
            KeywordStub::random(),
            DocumentContentStub::fromString($string)
        );
    }
}
