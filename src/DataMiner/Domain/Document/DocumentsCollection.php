<?php

namespace Mpwar\DataMiner\Domain\Document;

use Mpwar\DataMiner\Domain\DataType\ArrayCollection;

class DocumentsCollection extends ArrayCollection
{

    protected function typeOfCollection(): string
    {
        return Document::class;
    }
}
