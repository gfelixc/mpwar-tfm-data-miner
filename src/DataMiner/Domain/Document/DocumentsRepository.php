<?php

namespace Mpwar\DataMiner\Domain\Document;

interface DocumentsRepository
{

    public function save(Document $document): void;
}
