<?php

namespace Mpwar\DataMiner\Application;

interface CommandBus
{
    public function register(CommandHandler $commandHandler);

    public function dispatch(Command $command);
}
