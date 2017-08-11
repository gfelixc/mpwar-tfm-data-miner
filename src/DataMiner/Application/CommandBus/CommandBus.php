<?php

namespace Mpwar\DataMiner\Application\CommandBus;

interface CommandBus
{
    public function addHandler($commandName, $commandHandler);

    public function handle($command);
}
