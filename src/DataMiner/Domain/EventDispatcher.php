<?php

namespace Mpwar\DataMiner\Domain;

interface EventDispatcher
{

    public function dispatch($eventName, $data);
}
