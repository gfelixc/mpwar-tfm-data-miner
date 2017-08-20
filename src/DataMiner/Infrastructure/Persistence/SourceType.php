<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Types\Type;
use Mpwar\DataMiner\Domain\Source;

class SourceType extends Type
{

    public function convertToDatabaseValue($value)
    {
        /** @var Source $value */
        if ($value !== null && !is_a($value, Source::class)) {
            throw MongoDBException::invalidValueForType('SourceType', ['SourceType', 'null'], $value);
        }

        return $value !== null ? [
            'id'   => $value->id(),
            'name' => $value->name()
        ] : null;
    }

    public function convertToPHPValue($value)
    {
        return new Source($value->id, $value->name);
    }
}
