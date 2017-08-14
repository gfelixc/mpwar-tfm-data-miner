<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\Document;

interface DocumentTransformer
{
    public function transform(Document $document);
}
