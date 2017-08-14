<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use AntPack\DataTypes\Common\StringValueObject;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Types\Type;

abstract class StringValueObjectType extends Type
{
    public function convertToDatabaseValue($value)
    {
        if ($value !== null && ! is_a($value, StringValueObject::class)) {
            throw MongoDBException::invalidValueForType($this->type(), array($this->type(), 'null'), $value);
        }
        return $value !== null ? $value->value() : null;
    }

    abstract protected function type():string ;
}
