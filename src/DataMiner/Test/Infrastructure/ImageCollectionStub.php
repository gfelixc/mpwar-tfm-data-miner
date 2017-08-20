<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\ImageCollection;
use Mpwar\Test\Infrastructure\Stub;

class ImageCollectionStub extends Stub
{
    public static function create($value)
    {
        return new ImageCollection($value);
    }
    public static function random()
    {
        return self::create(ImageStub::random());
    }
}
