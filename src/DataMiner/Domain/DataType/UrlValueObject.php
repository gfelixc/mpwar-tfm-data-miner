<?php

namespace Mpwar\DataMiner\Domain\DataType;

use AntPack\DataTypes\Common\StringValueObject;
use InvalidArgumentException;

class UrlValueObject extends StringValueObject
{
    protected function setValue(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid url");
        }
        parent::setValue($value);
    }
}
