<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Document;

use Doctrine\ODM\MongoDB\DocumentRepository as DoctrineRepository;
use Mpwar\DataMiner\Domain\Document;
use Mpwar\DataMiner\Domain\DocumentRepository;

class DoctrineDocumentRepository extends DoctrineRepository implements DocumentRepository
{
    public function save(Document $document): void
    {
        $documentManager = $this->getDocumentManager();
        $documentManager->persist($document);
        $documentManager->flush();
    }
}
