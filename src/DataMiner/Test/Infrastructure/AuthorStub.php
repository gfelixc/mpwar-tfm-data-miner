<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use Mpwar\DataMiner\Domain\Author;
use Mpwar\Test\Infrastructure\Stub;

class AuthorStub extends Stub
{
    public static function create($name, $location)
    {
        return new Author($name, $location);
    }
    public static function random()
    {
        return self::create(self::factory()->firstName, self::factory()->country);
    }
}
