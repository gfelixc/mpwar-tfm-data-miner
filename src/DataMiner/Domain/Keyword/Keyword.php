<?php

namespace Mpwar\DataMiner\Domain\Keyword;

use Mpwar\DataMiner\Domain\DataType\StringValueObject;
use Mpwar\DataMiner\Domain\DomainEventPublisher;

class Keyword extends StringValueObject
{
    protected function setValue(string $value): void
    {
        parent::setValue($value);

        DomainEventPublisher::instance()->publish(
            new KeywordWasRetrievedEvent($this)
        );
    }
}
