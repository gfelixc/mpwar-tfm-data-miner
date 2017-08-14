<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use Mpwar\DataMiner\Domain\Text;
use Mpwar\DataMiner\Domain\TextCollection;

class TextCollectionType extends CollectionType
{

    protected function type(): string
    {
        return 'TextCollectionType';
    }

    protected function convertNestedToDatabase($value)
    {
        /** @var Text $value */
        return $value->value();
    }

    protected function convertNestedToPHPValue($value)
    {
        return new Text($value);
    }

    protected function emptyCollection()
    {
        return new TextCollection();
    }
}
