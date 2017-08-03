<?php

namespace Mpwar\DataMiner\Application;

class InMemoryCommandBus implements CommandBus
{
    /** @var CommandHandler[] */
    private $commandHandlers;

    public function __construct(... $commandHandlersList)
    {
        $this->commandHandlers = [];

        foreach ($commandHandlersList as $commandHandler) {
            $this->register($commandHandler);
        }
    }

    public function register(CommandHandler $commandHandler)
    {
        if (key_exists($commandHandler->commandName(), $this->commandHandlers)) {
            throw new RewriteCommandHandlerNotAllowedException();
        }

        $this[$commandHandler->commandName()] = $commandHandler;
    }

    public function dispatch(Command $command)
    {
        $commandName = get_class($command);
        $this->commandHandlers[$commandName]->handle($command);
    }
}
