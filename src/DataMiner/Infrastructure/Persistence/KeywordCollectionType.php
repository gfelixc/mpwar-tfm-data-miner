<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\KeywordCollection;

class KeywordCollectionType extends CollectionType
{

    protected function type(): string
    {
        return 'KeywordCollectionType';
    }

    protected function convertNestedToDatabase($value)
    {
        /** @var Keyword $value */
        return $value->value();
    }

    protected function convertNestedToPHPValue($value)
    {
        return new Keyword($value);
    }

    protected function emptyCollection()
    {
        return new KeywordCollection();
    }
}
