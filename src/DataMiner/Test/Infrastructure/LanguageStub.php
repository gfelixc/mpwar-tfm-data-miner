<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

use AntPack\DataTypes\Common\Language;
use Mpwar\Test\Infrastructure\Stub;

class LanguageStub extends Stub
{
    public static function create($value)
    {
        return new Language($value);
    }
    public static function random()
    {
        return self::create(self::factory()->languageCode);
    }
}
