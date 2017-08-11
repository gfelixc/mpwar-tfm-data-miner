<?php

namespace Mpwar\DataMiner\Application\CommandHandler;

use Mpwar\DataMiner\Application\Command\FindKeywordCommand;
use Mpwar\DataMiner\Application\Command\ParseRecordCommand;
use Mpwar\DataMiner\Application\CommandBus\CommandBus;
use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\Service;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;

class FindKeyword
{
    /**
     * @var Service
     */
    private $service;
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(
        Service $service,
        CommandBus $commandBus
    ) {
        $this->service = $service;
        $this->commandBus = $commandBus;
    }

    public function execute(FindKeywordCommand $command): void
    {
        $keyword = new Keyword($command->keyword());
        $serviceRecordsCollection = $this->service->find($keyword);
        /** @var ServiceRecord $record */
        foreach ($serviceRecordsCollection as $record) {
            $this->commandBus->handle(
                new ParseRecordCommand($this->service->serviceName(), $record)
            );
        }
    }
}
