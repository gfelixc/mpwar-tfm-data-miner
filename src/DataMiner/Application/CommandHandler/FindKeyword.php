<?php

namespace Mpwar\DataMiner\Application\CommandHandler;

use Mpwar\DataMiner\Application\Command\FindKeywordCommand;
use Mpwar\DataMiner\Application\MessageBus;
use Mpwar\DataMiner\Domain\Document\DocumentFactory;
use Mpwar\DataMiner\Domain\Document\DocumentRepository;
use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\Service;
use Mpwar\DataMiner\Domain\Service\Visit;
use Mpwar\DataMiner\Domain\Service\ServiceVisitsRepository;

class FindKeyword
{

    /**
     * @var Service
     */
    private $service;
    /**
     * @var ServiceVisitsRepository
     */
    private $visitsRepository;
    /**
     * @var DocumentFactory
     */
    private $documentFactory;
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    public function __construct(
        Service $service,
        ServiceVisitsRepository $visitsRepository,
        DocumentFactory $documentFactory,
        DocumentRepository $documentRepository
    ) {
        $this->service            = $service;
        $this->visitsRepository   = $visitsRepository;
        $this->documentFactory    = $documentFactory;
        $this->documentRepository = $documentRepository
    }

    public function execute(FindKeywordCommand $command): void
    {
        $keyword = new Keyword($command->keyword());

        $lastVisitByKeyword       = $this->visitsRepository->lastByKeyword($keyword, $this->service->name());
        $serviceRecordsCollection = $this->service->findSince($keyword, $lastVisitByKeyword);

        if ($serviceRecordsCollection->lastRecordVisited()) {
            $this->visitsRepository->registerVisit(
                new Visit(
                    $this->service->name(), $keyword, $serviceRecordsCollection->lastRecordVisited()
                )
            );
        }

        foreach ($serviceRecordsCollection as $result) {
            $parsedResult = $this->service->parse($result);
            $document     = $this->documentFactory->build($this->service->name(), $keyword, $parsedResult);
            $this->documentRepository->save($document);
        }
    }
}
