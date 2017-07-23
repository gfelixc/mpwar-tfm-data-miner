<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\Document\Document;

class DocumentWasStoredEvent
{
    const NAME = 'document.stored';
    /**
     * @var Document
     */
    private $document;
    private $occurredOn;

    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->occurredOn = new \DateTimeImmutable();
    }

    /**
     * @return Document
     */
    public function document(): Document
    {
        return $this->document;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
