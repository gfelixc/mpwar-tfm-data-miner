<?php

namespace Mpwar\DataMiner\Application\CommandHandler;

use Mpwar\DataMiner\Application\Command\StoreDocumentCommand;
use Mpwar\DataMiner\Domain\Document\DocumentFactory;
use Mpwar\DataMiner\Domain\Document\DocumentRepository;

class StoreDocument
{
    /**
     * @var DocumentFactory
     */
    private $documentFactory;
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    public function __construct(
        DocumentFactory $documentFactory,
        DocumentRepository $documentRepository
    ) {
        $this->documentFactory = $documentFactory;
        $this->documentRepository = $documentRepository;
    }

    public function execute(StoreDocumentCommand $command)
    {
        $document = $this->documentFactory->build(
            1,
            2,
            3
        );

        $this->documentRepository->save($document);
    }
}
