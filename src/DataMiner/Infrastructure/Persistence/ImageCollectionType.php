<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use Mpwar\DataMiner\Domain\Image;
use Mpwar\DataMiner\Domain\ImageCollection;
use Mpwar\DataMiner\Domain\LinkUrl;
use Mpwar\DataMiner\Domain\Text;

class ImageCollectionType extends CollectionType
{

    protected function type(): string
    {
        return 'ImageCollectionType';
    }

    protected function convertNestedToDatabase($value)
    {
        /** @var Image $value */
        return [
            "url" => $value->url()->value(),
            "text" => $value->text()->value()
        ];
    }

    protected function convertNestedToPHPValue($value)
    {
        return new Image(
            new LinkUrl($value->url),
            new Text($value->text)
        );
    }

    protected function emptyCollection()
    {
        return new ImageCollection();
    }
}
