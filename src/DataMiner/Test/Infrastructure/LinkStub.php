<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Link;
use Mpwar\DataMiner\Domain\LinkType;
use Mpwar\DataMiner\Domain\LinkUrl;
use Mpwar\Test\Infrastructure\Stub;

class LinkStub extends Stub
{
    public static function create(LinkType $type, LinkUrl $url)
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
