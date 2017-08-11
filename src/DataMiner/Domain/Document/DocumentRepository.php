<?php

namespace Mpwar\DataMiner\Domain\Document;

interface DocumentRepository
{

    public function save(Document $document): void;
}
