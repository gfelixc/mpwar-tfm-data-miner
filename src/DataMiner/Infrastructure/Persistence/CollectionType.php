<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use AntPack\DataTypes\Common\ArrayCollection;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Types\Type;

abstract class CollectionType extends Type
{

    public function convertToDatabaseValue($value)
    {
        if ($value !== null && ! is_a($value, ArrayCollection::class)) {
            throw MongoDBException::invalidValueForType($this->type(), array($this->type(), 'null'), $value);
        }

        if ($value === null) {
            return null;
        }

        $array = [];
        foreach ($value as $item) {
            $array[] = $this->convertNestedToDatabase($item);
        }

        return $array;
    }

    public function convertToPHPValue($value)
    {
        /** @var ArrayCollection $collection */
        $collection = $this->emptyCollection();
        if ($value === null) {
            return $collection;
        }

        foreach ($value as $item) {
            $collection->add($this->convertNestedToPHPValue($item));
        }

        return parent::convertToPHPValue($value);
    }

    abstract protected function type():string;
    abstract protected function convertNestedToDatabase($value);
    abstract protected function convertNestedToPHPValue($value);
    abstract protected function emptyCollection();
}
