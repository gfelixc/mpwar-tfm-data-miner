<?php

namespace Mpwar\DataMiner\Application\Service;

use Mpwar\DataMiner\Application\DocumentTransformer;
use Mpwar\DataMiner\Application\MessageBus;
use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\Service\FinderService;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;

class FindKeyword
{
    /** @var StoreSearchResult */
    private $storeSearchResult;
    /** @var DocumentTransformer*/
    private $documentTransformer;
    /** @var MessageBus */
    private $messageBus;
    /** @var FinderService  */
    private $service;

    public function __construct(
        FinderService $service,
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
