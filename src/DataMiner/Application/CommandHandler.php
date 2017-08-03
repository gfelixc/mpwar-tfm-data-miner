<?php

namespace Mpwar\DataMiner\Application;

abstract class CommandHandler
{
    abstract public function commandName(): string;

    abstract public function handle(Command $command): void;
}
