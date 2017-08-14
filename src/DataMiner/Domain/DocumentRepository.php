<?php

namespace Mpwar\DataMiner\Domain;


interface DocumentRepository
{

    public function save(Document $document): void;
}
