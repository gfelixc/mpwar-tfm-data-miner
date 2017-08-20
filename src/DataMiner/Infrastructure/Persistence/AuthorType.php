<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Types\Type;
use Mpwar\DataMiner\Domain\Author;

class AuthorType extends Type
{

    public function convertToDatabaseValue($value)
    {
        /** @var Author $value */
        if ($value !== null && !is_a($value, Author::class)) {
            throw MongoDBException::invalidValueForType('AuthorType', ['AuthorType', 'null'], $value);
        }

        return $value !== null ? [
            'name'     => $value->name(),
            'location' => $value->location()
        ] : null;
    }

    public function convertToPHPValue($value)
    {
        return new Author($value->name, $value->location);
    }
}
