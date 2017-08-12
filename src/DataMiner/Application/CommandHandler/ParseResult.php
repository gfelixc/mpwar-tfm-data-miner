<?php

namespace Mpwar\DataMiner\Application\CommandHandler;

use Mpwar\DataMiner\Application\Command\ParseResultCommand;
use Mpwar\DataMiner\Application\Command\StoreDocumentCommand;
use Mpwar\DataMiner\Application\CommandBus\CommandBus;
use Mpwar\DataMiner\Application\EventDispatcher;
use Mpwar\DataMiner\Domain\Service\ResultWasAnalyzedEvent;

class ParseResult
{

    /**
     * @var ServiceParser
     */
    private $parser;
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function __construct(
        ServiceParser $parser,
        EventDispatcher $eventDispatcher
    ) {

        $this->parser = $parser;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(ParseResultCommand $command)
    {
        $analysisResults = $parser->analyze($command->result());

        $this->eventDispatcher->dispatch(
            ResultWasAnalyzedEvent::NAME,
            new ResultWasAnalyzedEvent(
                $command->service(),
                $command->keyword(),
                $analysisResults
            )
        );

        return $analysisResults;
    }
}
