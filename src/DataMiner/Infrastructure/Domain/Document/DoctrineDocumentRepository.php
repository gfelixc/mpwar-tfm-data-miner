<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Mpwar\DataMiner\Domain\Document\Document;
use Mpwar\DataMiner\Domain\Document\DocumentsRepository;

class DoctrineDocumentRepository extends DocumentRepository implements DocumentsRepository
{
    public function save(Document $document): void
    {
        $documentManager = $this->getDocumentManager();
        $documentManager->persist($document);
        $documentManager->flush();
    }
}
