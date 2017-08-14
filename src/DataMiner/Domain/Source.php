<?php

namespace Mpwar\DataMiner\Domain;

class Source
{
    private $id;
    /**
     * @var string
     */
    private $name;

    public function __construct($id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}
