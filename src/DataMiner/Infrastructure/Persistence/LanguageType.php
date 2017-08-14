<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use AntPack\DataTypes\Common\Language;

class LanguageType extends StringValueObjectType
{
    public function convertToPHPValue($value)
    {
        return new Language($value);
    }

    protected function type(): string
    {
        return 'LanguageType';
    }
}
