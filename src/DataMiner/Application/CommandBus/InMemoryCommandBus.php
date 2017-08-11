<?php

namespace Mpwar\DataMiner\Application\CommandBus;

use Mpwar\DataMiner\Application\CommandBus\Command;
use Mpwar\DataMiner\Application\CommandBus\CommandBus;
use Mpwar\DataMiner\Application\CommandBus\CommandHandler;
use Mpwar\DataMiner\Application\RewriteCommandHandlerNotAllowedException;

class InMemoryCommandBus implements CommandBus
{
    private $commandHandlers;

    public function __construct()
    {
        $this->commandHandlers = [];
    }

    public function addHandler($commandName, $commandHandler)
    {
        if (key_exists($commandName, $this->commandHandlers)) {
            throw new RewriteCommandHandlerNotAllowedException();
        }

        $this[$commandName] = $commandHandler;
    }

    public function handle($command)
    {
        $commandName = get_class($command);
        $this->commandHandlers[$commandName]->execute($command);
    }
}
