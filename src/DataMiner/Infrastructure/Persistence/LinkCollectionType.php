<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use Mpwar\DataMiner\Domain\Link;
use Mpwar\DataMiner\Domain\LinkCollection;
use Mpwar\DataMiner\Domain\LinkUrl;

class LinkCollectionType extends CollectionType
{

    protected function type(): string
    {
        return 'LinkCollectionType';
    }

    protected function convertNestedToDatabase($value)
    {
        /** @var Link $value */
        return [
            "type" => $value->type()->value(),
            "url" => $value->url()->value()
        ];
    }

    protected function convertNestedToPHPValue($value)
    {
        new Link($value->type, new LinkUrl($value->url));
    }

    protected function emptyCollection()
    {
        return new LinkCollection();
    }
}
