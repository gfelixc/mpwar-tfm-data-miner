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
     * @var MessageBus
     */
    private $messageBus;

    public function __construct(
        Service $service,
        DocumentsFactory $documentsFactory,
        DocumentsRepository $documentsRepository,
        MessageBus $messageBus
    ) {
        $this->documentsRepository = $documentsRepository;
        $this->service = $service;
        $this->documentsFactory = $documentsFactory;
        $this->messageBus = $messageBus;
    }

    public function find(Keyword $keyword)
    {
        echo 'Find Keyword -> '. $keyword . ' - ' . $this->service->serviceName()->value() . "\n";
        $serviceRecordsCollection = $this->service->find($keyword);
        /** @var ServiceRecord $record */
        foreach ($serviceRecordsCollection as $record) {
            $document = $this->documentsFactory->build(
                $this->service->serviceName(),
                $keyword,
                $record->value()
            );

            $this->documentsRepository->save($document);

            $message = [
                'eventName' => 'RawDocumentWasStored',
                'occurredOn' => \DateTimeImmutable::createFromFormat(DATE_ATOM, 'now'),
                'rawDocument' => [
                    'id' => $document->id()->value(),
                    'source' => $document->service()->value(),
                    'keyword' => $document->keyword()->value(),
                    'content' => json_decode($document->content()->value())
                ]
            ];

            $this->messageBus->dispatch(json_encode($message));
        }
    }
}
