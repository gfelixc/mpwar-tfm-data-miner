<?php

namespace Mpwar\DataMiner\Domain\Service\Twitter;

use Mpwar\DataMiner\Domain\Service\Twitter\Repository\TweetsRepository;
use Mpwar\DataMiner\Domain\Document\Document;
use Mpwar\DataMiner\Domain\Document\DocumentContent;
use Mpwar\DataMiner\Domain\Document\DocumentId;
use Mpwar\DataMiner\Domain\Document\DocumentsRepository;
use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\ServiceName;
use Mpwar\DataMiner\Domain\Service\ServicesRepository;

class TwitterMiner
{
    const SERVICE_NAME = 'twitter';
    private $servicesRepository;
    private $tweetsRepository;
    private $documentsRepository;
    private $serviceName;

    public function __construct(
        ServicesRepository $servicesRepository,
        TweetsRepository $tweetsRepository,
        DocumentsRepository $documentsRepository
    ) {
        $this->servicesRepository  = $servicesRepository;
        $this->tweetsRepository    = $tweetsRepository;
        $this->documentsRepository = $documentsRepository;
        $this->serviceName         = new ServiceName(self::SERVICE_NAME);
    }

    public function execute(Keyword $keyword): void
    {
        $since = $this->servicesRepository->lastVisitWithService(
            $keyword,
            $this->serviceName
        );

        $tweetsCollection = $this->tweetsRepository->findKeywordSince(
            $keyword,
            $since
        );

        foreach ($tweetsCollection->tweets() as $tweet) {
            $document = new Document(
                DocumentId::new(),
                $this->serviceName,
                $keyword,
                DocumentContent::fromString($tweet)
            );

            $this->documentsRepository->save($document);
        }

        $this->servicesRepository->registerVisit(
            $this->serviceName,
            $tweetsCollection->maxId()
        );
    }
}
