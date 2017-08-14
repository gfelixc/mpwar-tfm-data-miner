<?php

namespace Mpwar\DataMiner\Domain;

class Author
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $location;

    public function __construct(string $name, string $location)
    {
        $this->name     = $name;
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function location(): string
    {
        return $this->location;
    }
}
