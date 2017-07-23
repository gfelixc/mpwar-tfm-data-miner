<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Document;

use Doctrine\ORM\EntityRepository;
use Mpwar\DataMiner\Domain\Document\Document;
use Mpwar\DataMiner\Domain\Document\DocumentsRepository;

class DoctrineDocumentRepository extends EntityRepository implements DocumentsRepository
{

    public function save(Document $document): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($document);
    }
}
