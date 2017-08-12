<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\Service\ResultWasFoundEvent;
use Mpwar\DataMiner\Domain\DataType\StringValueObject;
use Mpwar\DataMiner\Domain\DomainEventPublisher;

class ServiceRecord extends StringValueObject
{
    public function __construct($value)
    {
        parent::__construct($value);

        DomainEventPublisher::instance()->publish(
            new ResultWasFoundEvent(
                $this->service->serviceName()->value(),
                $keyword->value(),
                $record->value()
            )
        );
    }
}
