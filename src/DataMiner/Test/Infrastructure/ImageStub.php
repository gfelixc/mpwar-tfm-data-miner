<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Image;
use Mpwar\DataMiner\Domain\LinkUrl;
use Mpwar\DataMiner\Domain\Text;
use Mpwar\Test\Infrastructure\Stub;

class ImageStub extends Stub
{
    public static function create(LinkUrl $linkUrl, Text $text)
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
