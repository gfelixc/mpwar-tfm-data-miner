<?php

namespace Mpwar\DataMiner\Application;

interface MessageBus
{
    public function dispatch(string $message): void;
}
