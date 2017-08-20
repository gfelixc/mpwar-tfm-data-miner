<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Link;
use Mpwar\Test\Infrastructure\Stub;

class LinkStub extends Stub
{
    public static function create($type, $url)
    {
        return new Link($type, $url);
    }
    public static function random()
    {
        return self::create(
            LinkTypeStub::random(),
            LinkUrlStub::random()
        );
    }
}
