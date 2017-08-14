<?php

namespace Mpwar\DataMiner\Infrastructure\Persistence;

use Mpwar\DataMiner\Domain\CreatedAt;

class CreatedAtType extends StringValueObjectType
{
    public function convertToPHPValue($value)
    {
        return new CreatedAt($value);
    }

    protected function type(): string
    {
        return 'CreatedAtType';
    }
}
