<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Mpwar\DataMiner\Domain\Document\Document;
use Mpwar\DataMiner\Domain\Document\DocumentRepository;

class DoctrineDocumentRepository extends DocumentRepository implements DocumentRepository
{
    public function save(Document $document): void
    {
        $documentManager = $this->getDocumentManager();
        $documentManager->persist($document);
        $documentManager->flush();
    }
}
