<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\Document\DocumentsFactory;
use Mpwar\DataMiner\Domain\Document\DocumentsRepository;
use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\Service;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;

class FindKeyword
{
    /**
     * @var DocumentsRepository
     */
    private $documentsRepository;
    /**
     * @var Service
     */
    private $service;
    /**
     * @var DocumentsFactory
     */
    private $documentsFactory;
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function __construct(
        Service $service,
        DocumentsFactory $documentsFactory,
        DocumentsRepository $documentsRepository,
        EventDispatcher $eventDispatcher
    ) {
        $this->documentsRepository = $documentsRepository;
        $this->service = $service;
        $this->documentsFactory = $documentsFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function find(Keyword $keyword)
    {
        $serviceRecordsCollection = $this->service->find($keyword);
        /** @var ServiceRecord $record */
        foreach ($serviceRecordsCollection as $record) {
            $document = $this->documentsFactory->build(
                $this->service->serviceName(),
                $keyword,
                $record->value()
            );

            $this->documentsRepository->save($document);
            $this->eventDispatcher->dispatch(
                DocumentWasStoredEvent::NAME,
                new DocumentWasStoredEvent($document)
            );
        }
    }
}
