<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Document;

use Mpwar\DataMiner\Domain\Document\Document;
use Mpwar\DataMiner\Domain\Document\DocumentContent;
use Mpwar\DataMiner\Domain\Document\DocumentId;
use Mpwar\DataMiner\Domain\Document\DocumentFactory;
use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\ServiceName;

class DoctrineDocumentFactory implements DocumentFactory
{

    public function build(
        ServiceName $serviceName,
        Keyword $keyword,
        string $value
    ): Document {
        return new DoctrineDocument(
            DocumentId::new(),
            $serviceName,
            $keyword,
            new DocumentContent($value)
        );
    }
}
