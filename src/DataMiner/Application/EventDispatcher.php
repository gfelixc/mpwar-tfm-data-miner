<?php

namespace Mpwar\DataMiner\Application;

interface EventDispatcher
{
    public function dispatch($eventName, $data);
}
