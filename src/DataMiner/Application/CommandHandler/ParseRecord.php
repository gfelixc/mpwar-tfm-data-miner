<?php

namespace Mpwar\DataMiner\Application\CommandHandler;

use Mpwar\DataMiner\Application\Command\ParseRecordCommand;
use Mpwar\DataMiner\Application\Command\StoreDocumentCommand;
use Mpwar\DataMiner\Application\CommandBus\CommandBus;

class ParseRecord
{
    /**
     * @var RecordParser
     */
    private $recordParser;
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(
        RecordParser $recordParser,
        CommandBus $commandBus
    ) {
        $this->recordParser = $recordParser;
        $this->commandBus = $commandBus;
    }

    public function execute(ParseRecordCommand $command)
    {

        $this->commandBus->handle(
            new StoreDocumentCommand()
        );
    }
}
