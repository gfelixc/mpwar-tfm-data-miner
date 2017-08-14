<?php

namespace Mpwar\DataMiner\Domain;

use AntPack\DataTypes\Common\StringValueObject;
use InvalidArgumentException;

class LinkType extends StringValueObject
{
    const DIRECT = "direct";
    const RELATED = "related";
    const VALID_TYPES = [
        self::DIRECT,
        self::RELATED
    ];

    protected function setValue(string $value): void
    {
        if (!in_array($value, self::VALID_TYPES)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Invalid link type, received: %s, valid types: %s",
                    $value,
                    implode(",", self::VALID_TYPES
                    )
                )
            );
        }

        parent::setValue($value);
    }
}
