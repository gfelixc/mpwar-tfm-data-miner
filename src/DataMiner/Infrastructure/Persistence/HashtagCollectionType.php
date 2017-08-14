<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use Mpwar\DataMiner\Domain\Hashtag;
use Mpwar\DataMiner\Domain\HashtagCollection;

class HashtagCollectionType extends CollectionType
{

    protected function type(): string
    {
        return 'HashtagCollectionType';
    }

    protected function convertNestedToDatabase($value)
    {
        /** @var Hashtag $value */
        return $value->value();
    }

    public function convertNestedToPHPValue($value)
    {
        return new Hashtag($value);
    }

    protected function emptyCollection()
    {
        return new HashtagCollection();
    }
}
