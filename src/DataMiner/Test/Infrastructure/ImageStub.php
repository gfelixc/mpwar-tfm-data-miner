<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Image;
use Mpwar\Test\Infrastructure\Stub;

class ImageStub extends Stub
{
    public static function create($linkUrl, $text)
    {
        return new Image($linkUrl, $text);
    }
    public static function random()
    {
        return self::create(
            LinkUrlStub::random(),
            TextStub::random()
        );
    }
}
