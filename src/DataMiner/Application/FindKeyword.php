<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\Service\Service;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;

class FindKeyword
{
    /**
     * @var Service
     */
    private $service;
    /**
     * @var StoreSearchResult
     */
    private $storeSearchResult;
    /**
     * @var DocumentTransformer
     */
    private $documentTransformer;
    /**
     * @var MessageBus
     */
    private $messageBus;

    public function __construct(
        Service $service,
        StoreSearchResult $storeSearchResult,
        DocumentTransformer $documentTransformer,
        MessageBus $messageBus
    ) {
        $this->service = $service;
        $this->storeSearchResult = $storeSearchResult;
        $this->documentTransformer = $documentTransformer;
        $this->messageBus = $messageBus;
    }

    public function find(Keyword $keyword)
    {
        $serviceRecordsCollection = $this->service->find($keyword);
        /** @var ServiceRecord $record */
        foreach ($serviceRecordsCollection as $record) {
            $document = $this->storeSearchResult->execute($record, $keyword);

            $message = [
                'eventName'  => 'RawDocumentWasStored',
                'occurredOn' => (new \DateTime())->format(DATE_ATOM),
                'data'       => $this->documentTransformer->transform($document)
            ];

            $this->messageBus->dispatch(json_encode($message));
        }
    }
}
